@extends('admin.layouts.master')

@section('head-tag')
    <title>تنظیمات</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">تنظیمات</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش تنظیمات</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش تنظیمات</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.setting.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form id="form" action="{{route('admin.setting.update', $setting->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="title">عنوان سایت</label>
                                    <input class="form-control form-control-sm @error('title') is-invalid @enderror" type="text" name="title" id="title" value="{{old('title',$setting->title)}}">
                                </div>
                                @error('title')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="name">توضیحات سایت</label>
                                    <input class="form-control form-control-sm @error('description') is-invalid @enderror" type="text" name="description" id="description" value="{{old('description',$setting->description)}}">
                                </div>
                                @error('description')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="name">کلمات کلیدی سایت</label>
                                    <input class="form-control form-control-sm @error('keywords') is-invalid @enderror" type="text" name="keywords" id="keywords" value="{{old('keywords',$setting->keywords)}}">
                                </div>
                                @error('keywords')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="logo">لوگو</label>
                                    <input class="form-control form-control-sm @error('logo') is-invalid @enderror" type="file" name="logo" id="logo">
                                </div>
                                @error('logo')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="icon">آیکون</label>
                                    <input class="form-control form-control-sm @error('icon') is-invalid @enderror" type="file" name="icon" id="icon">
                                </div>
                                @error('icon')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                        </section>
                        <section class="col-12 mt-2 my-3">
                            <button class="btn btn-primary btn-sm" type="submit">ثبت</button>
                        </section>
                    </form>
                </section>
            </section>
        </section>
    </section>
@endsection
