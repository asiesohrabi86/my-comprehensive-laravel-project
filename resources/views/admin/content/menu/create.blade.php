@extends('admin.layouts.master')

@section('head-tag')
    <title>ایجاد منو</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">منو</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ایجاد منو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ایجاد منو</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.content.menu.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.content.menu.store')}}" method="post">
                        @csrf
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">عنوان منو</label>
                                    <input class="form-control form-control-sm" name="name" value="{{old('name')}}" type="text">
                                </div>
                                @error('name')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">منوی والد</label>
                                    <select class="form-control form-control-sm" name="parent_id">
                                        <option value="">منوی اصلی</option>
                                        @foreach ($menus as $menu)
                                            <option value="{{$menu->id}}" @if (old('parent_id') == $menu->id)
                                                selected
                                            @endif>{{$menu->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                @error('parent_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">آدرس url</label>
                                    <input class="form-control form-control-sm" value="{{old('url')}}" name="url" type="text">
                                </div>
                                @error('url')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">وضعیت</label>
                                    <select name="status" id="" class="form-control form-control-sm @error('status')
                                        is-invalid @enderror">
                                        <option value="1" @if (old('status') == 1) selected @endif>فعال</option>
                                        <option value="0" @if (old('status') == 0) selected @endif>غیرفعال</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
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