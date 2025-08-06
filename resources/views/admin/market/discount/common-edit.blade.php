@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش تخفیف عمومی</title>
    <link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">برندها</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش تخفیف عمومی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش تخفیف عمومی</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.discount.commonDiscount')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.market.discount.commonDiscount.update', $commonDiscount)}}" method="post">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">درصد تخفیف</label>
                                    <input type="number" name="percentage" value="{{old('percentage', $commonDiscount->percentage)}}" class="form-control form-control-sm">
                                </div>
                                @error('percentage')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">حداکثر تخفیف</label>
                                    <input type="number" name="discount_ceiling" value="{{old('discount_ceiling', $commonDiscount->discount_ceiling)}}" class="form-control form-control-sm">
                                </div>
                                @error('discount_ceiling')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">حداقل مبلغ خرید</label>
                                    <input type="number" name="minimal_order_amount" value="{{old('minimal_order_amount', $commonDiscount->minimal_order_amount)}}" class="form-control form-control-sm">
                                </div>
                                @error('minimal_order_amount')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">عنوان مناسبت</label>
                                    <input type="text" name="title" value="{{old('title', $commonDiscount->title)}}" class="form-control form-control-sm">
                                </div>
                                @error('title')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">تاریخ شروع</label>
                                    <input type="text" name="start_date" id="start_date" class="form-control form-control-sm d-none">
                                    <input id="start_date_view" class="form-control form-control-sm"> 
                                </div>
                                @error('start_date')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 mb-2">
                                <div class="form-group">
                                    <label for="">تاریخ پایان</label>
                                    <input type="text" name="end_date" id="end_date" class="form-control form-control-sm d-none">
                                    <input id="end_date_view" class="form-control form-control-sm"> 
                                </div>
                                @error('end_date')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                        </section>
                        <section class="col-12 my-2">
                            <div class="form-group">
                                <label for="status">وضعیت</label>
                                <select name="status" class="form-control form-control-sm" id="status">
                                    <option value="0" @if (old('status', $commonDiscount->status) == 0) selected @endif>غیرفعال</option>
                                    <option value="1" @if (old('status', $commonDiscount->status) == 1) selected @endif>فعال</option>
                                </select>
                            </div>
                            @error('status')
                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                    <strong>{{$message}}</strong>
                                </span>
                            @enderror
                        </section>
                        <section class="col-12 mt-2">
                            <button class="btn btn-primary btn-sm" type="submit">ثبت</button>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    <script src="{{asset('admin-assets/jalalidatepicker/persian-date.min.js')}}"></script>
    <script src="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#start_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField : '#start_date' 
            });
        });
        $(document).ready(function(){
            $('#end_date_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField : '#end_date' 
            });
        });
    </script>
@endsection