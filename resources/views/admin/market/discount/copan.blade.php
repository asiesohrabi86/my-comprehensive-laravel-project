@extends('admin.layouts.master')

@section('head-tag')
    <title>کوپن تخفیف</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">کوپن تخفیف</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>کوپن تخفیف</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.discount.copan.create')}}" class="btn btn-info btn-sm">ایجاد کوپن تخفیف</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>کد تخفیف</th>
                                <th>میزان تخفیف</th>
                                <th>نوع تخفیف</th>
                                <th>سقف تخفیف</th>
                                <th>نوع کوپن</th>
                                <th>تاریخ شروع</th>
                                <th>تاریخ پایان</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($copans as $copan)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$copan->code}}</td>
                                    <td>{{$copan->amount}}{{$copan->amount_type == 1 ? 'تومان' : '%'}}</td>
                                    <td>{{$copan->amount_type == 0 ? 'درصدی' : 'عددی'}}</td>
                                    <td>{{$copan->discount_ceiling ?? '-'}}تومان</td>
                                    <td>{{$copan->type == 0 ? 'عمومی' : 'خصوصی'}}</td>
                                    <td>{{jalaliDate($copan->start_date)}}</td>
                                    <td>{{jalaliDate($copan->end_date)}}</td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.market.discount.copan.edit', $copan->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{route('admin.market.discount.copan.destroy', $copan->id)}}" method="post">
                                            @csrf
                                            {{method_field('delete')}}
                                            <button type="submit" class="btn btn-danger delete btn-sm"><i class="fa fa-trash-alt"></i> حذف</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection
@section('script')
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection