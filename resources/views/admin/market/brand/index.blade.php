@extends('admin.layouts.master')

@section('head-tag')
    <title>برند</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">برندها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>برندها</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.brand.create')}}" class="btn btn-info btn-sm">ایجاد برند</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام فارسی برند</th>
                                <th>نام اصلی برند</th>
                                <th>لوگو</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($brands as $brand)
                                <tr>
                                    <th>{{$loop->iteration}}</th>
                                    <td>{{$brand->persian_name}}</td>
                                    <td>{{$brand->original_name}}</td>
                                    <td>
                                        <img src="{{asset($brand->logo['indexArray'][$brand->logo['currentImage']])}}" alt="" width="100" height="50" class="max-height-2rem">
                                    </td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.market.brand.edit', $brand->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{route('admin.market.brand.destroy', $brand->id)}}" method="post">
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