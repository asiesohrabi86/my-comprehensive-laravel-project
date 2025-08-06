@extends('admin.layouts.master')

@section('head-tag')
    <title>فاکتور سفارش</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">فاکتور سفارش</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>فاکتور سفارش</h5>
                </section>
                
                <section class="table-responsive">
                    <table class="table table-striped table-hover h-220px" id="printable">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-primary">
                                <th>{{$order->id}}</th>
                                <td class="width-8-rem text-start">
                                    <a href="#" class="btn btn-sm btn-dark text-white" id="print">
                                        <i class="fa fa-print"></i>
                                        جاپ
                                    </a>
                                    <a href="{{route('admin.market.order.show.detail', $order->id)}}" class="btn btn-sm btn-warning">
                                        <i class="fa fa-book"></i>
                                        جزئیات سفارش
                                    </a>
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th>نام مشتری</th>
                                <td class="text-start font-weight-bolder">{{$order->user->fullName ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>آدرس</th>
                                <td class="text-start font-weight-bolder">{{$order->address->address ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>شهر</th>
                                <td class="text-start font-weight-bolder">{{$order->address->city->name ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>کد پستی</th>
                                <td class="text-start font-weight-bolder">{{$order->address->postal_code ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>پلاک</th>
                                <td class="text-start font-weight-bolder">{{$order->address->no ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>واحد</th>
                                <td class="text-start font-weight-bolder">{{$order->address->unit ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>نام گیرنده</th>
                                <td class="text-start font-weight-bolder">{{$order->address->recepient_first_name ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>نام خانوادگی گیرنده</th>
                                <td class="text-start font-weight-bolder">{{$order->address->recepient_last_name ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>موبایل</th>
                                <td class="text-start font-weight-bolder">{{$order->address->mobile ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>نوع پرداخت</th>
                                <td class="text-start font-weight-bolder">
                                    {{$order->payment_type_value }}
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th>وضعیت پرداخت</th>
                                <td class="text-start font-weight-bolder">
                                    {{$order->payment_status_value }}
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مبلغ ارسال</th>
                                <td class="text-start font-weight-bolder">{{$order->delivery_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>وضعیت ارسال</th>
                                <td class="text-start font-weight-bolder">
                                    {{$order->delivery_status_value }}
                                </td>
                            </tr>
                            <tr class="border-bottom">
                                <th>تاریخ ارسال</th>
                                <td class="text-start font-weight-bolder">{{jalaliDate($order->delivery_date) ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مجموع مبلغ سفارش (بدون تخفیف)</th>
                                <td class="text-start font-weight-bolder">{{$order->order_final_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مجموع تمامی مبلغ تخفیفات</th>
                                <td class="text-start font-weight-bolder">{{$order->order_discount_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مبلغ تخفیف همه محصولات</th>
                                <td class="text-start font-weight-bolder">{{$order->order_total_products_discount_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مبلغ نهایی</th>
                                <td class="text-start font-weight-bolder">{{$order->order_final_amount - $order->order_discount_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>بانک</th>
                                <td class="text-start font-weight-bolder">{{$order->payment->paymentable->gateway ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>کوپن استفاده شده</th>
                                <td class="text-start font-weight-bolder">{{$order->copan->code ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>تخفیف کد تخفیف</th>
                                <td class="text-start font-weight-bolder">{{$order->order_copan_discount_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>تخفیف عمومی استفاده شده</th>
                                <td class="text-start font-weight-bolder">{{$order->commonDiscount->title ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>مبلغ تخفیف عمومی</th>
                                <td class="text-start font-weight-bolder">{{$order->order_common_discount_amount ?? '-'}}</td>
                            </tr>
                            <tr class="border-bottom">
                                <th>وضعیت سفارش</th>
                                <td class="text-start font-weight-bolder">
                                    {{$order->order_status_value }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script>
        var printBtn = document.getElementById('print');
        printBtn.addEventListener('click', () => {
            alert('hi');
            printContent('printable');
        });
        function printContent(id){
            // کل محتوای صفحه را جایی ذخیره کنیم که قبل از پرینت محتوای صفحه را خالی کنیم
            // و جدول را بجای آن قرار دهیم بعد از پرینت گرفتن محتوای قبلی را برگردانیم:
            // var restorePage = $('body').html();
            // var printContent = $('#'+id).clone();
            // $('body').empty().html(printContent);
            // window.print();
            // $('body').html(restorePage);

            // روش دوم با جاوااسکریپت
            var restorePage = document.body.cloneNode(true);
            var printContent = document.getElementById(id).cloneNode(true);
            console.log(printContent)
            document.body.innerHTML = "";
            document.body.appendChild(printContent);
            window.print();
            document.body.removeChild(printContent);
            document.body = restorePage;     
        }
    </script>
@endsection