@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش فایل اطلاعیه ایمیلی</title>
    <link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">اطلاع رسانی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">اطلاعیه ایمیلی</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش فایل اطلاعیه ایمیلی</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش فایل اطلاعیه ایمیلی</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.notify.email-file.index', $file->email->id)}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.notify.email-file.update', $file->id)}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="file">فایل</label>
                                    <input class="form-control form-control-smr" type="file" name="file" id="file" value="{{{old('file', $file->file)}}}">
                                </div>
                                @error('file')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-1">
                                <div class="form-group">
                                    <label for="">ذخیره در پوشه ی</label>
                                    <select name="storage" id="" class="form-control form-control-sm">
                                        <option value="1" @if (old('storage') == 1)
                                            selected                                        
                                        @endif>storage</option>
                                        <option value="0" @if (old('storage') == 0)
                                            selected                                        
                                        @endif>public</option>
                                    </select>
                                </div>
                                @error('storage')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 mt-1">
                                <div class="form-group">
                                    <label for="">وضعیت</label>
                                    <select name="status" id="" class="form-control form-control-sm">
                                        <option value="1" @if (old('status', $file->status) == 1)
                                            selected                                        
                                        @endif>فعال</option>
                                        <option value="0" @if (old('status', $file->status) == 0)
                                            selected                                        
                                        @endif>غیرفعال</option>
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

@section('script')
    <script src="{{asset('admin-assets/js/ckeditor/ckeditor.js')}}"></script>
    <script>
        CKEDITOR.replace('body');
    </script>

    <script src="{{asset('admin-assets/jalalidatepicker/persian-date.min.js')}}"></script>
    <script src="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.js')}}"></script>

    <script>
        $(document).ready(function(){
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField : '#published_at' ,
                timePicker: {
                    enabled: true,
                    meridiem: {
                        enabled: true
                    }
                }
            });
        });
    </script>
@endsection