@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش کاربر ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش کاربران</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">کاربر ادمین</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش کاربر ادمین</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش کاربر ادمین</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.user.admin-user.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.user.admin-user.update', $admin->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام</label>
                                    <input class="form-control form-control-sm" name="first_name" type="text" value="{{old('first_name', $admin->first_name)}}">
                                </div>
                                @error('first_name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام خانوادگی</label>
                                    <input class="form-control form-control-sm" type="text" name="last_name" value="{{old('last_name', $admin->last_name)}}">
                                </div>
                                @error('last_name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">تصویر</label>
                                    <input class="form-control form-control-sm" type="file" name="profile_photo_path">
                                    @if ($admin->profile_photo_path != null)
                                        <img src="{{asset($admin->profile_photo_path)}}" class="mt-3 rounded" width="100" height="100" alt="">
                                    @endif
                                    
                                </div>
                                @error('profile_photo_path')
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