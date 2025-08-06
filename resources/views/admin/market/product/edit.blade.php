@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش کالا</title>
    <link rel="stylesheet" href="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.css')}}">
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">کالا</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش کالا</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش کالا</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.product.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.market.product.update', $product->id)}}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">نام کالا</label>
                                    <input name="name" value="{{old('name', $product->name)}}" class="form-control form-control-sm" type="text">
                                </div>
                                @error('name')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">انتخاب دسته</label>
                                    <select class="form-control form-control-sm" name="category_id">
                                        <option value="null">دسته را انتخاب کنید</option>
                                        @foreach ($productCategories as $productCategory)
                                            <option value="{{$productCategory->id}}" @if (old('category_id', $product->category_id) == $productCategory->id)
                                                selected 
                                            @endif>{{$productCategory->name}}</option> 
                                        @endforeach
                                    </select>
                                    @error('category_id')
                                        <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                            <strong>{{$message}}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">انتخاب برند</label>
                                    <select class="form-control form-control-sm" name="brand_id">
                                        <option value="null">دسته را انتخاب کنید</option>
                                        @foreach ($brands as $brand)
                                            <option value="{{$brand->id}}" @if (old('brand_id', $product->brand_id) === $brand->id)
                                                selected 
                                            @endif>{{$brand->original_name}}</option> 
                                        @endforeach
                                    </select>
                                @error('brand_id')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                                </div>
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تصویر</label>
                                    <input type="file" name="image" class="form-control form-control-sm">
                                    {{-- <img src="{{asset($post->image['indexArray'][$post->image['currentImage']])}}" alt="" width="100" height="50" class="mt-3"> --}}
                                </div>
                                @error('image')
                                    <span role="alert" class="alert_required bg-danger text-white p-1 rounded">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror 
                                <section class="row">
                                    @php
                                        $number = 1;
                                    @endphp
                                    @foreach ($product->image['indexArray'] as $key => $value)
                                        <section class="col-md-{{ 6/ $number}}">
                                            <div class="form-check">
                                                <input type="radio" name="current-image" class="form-ckeck-input" value="{{$key}}" id="{{$number}}" @if ($product->image['currentImage'] == $key)
                                                 checked 
                                                @endif
                                                >
                                                <label for="{{$number}}" class="form-ckeck-label">
                                                    <img src="{{asset($value)}}" class="w-100" alt="" srcset="">
                                                </label>
                                            </div>
                                        </section>
                                        @php
                                        $number++;
                                        @endphp
                                    @endforeach
                                    
                                </section>
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">وزن</label>
                                    <input name="weight" value="{{old('weight', $product->weight)}}" type="text" class="form-control form-control-sm">
                                </div>
                                @error('weight')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">طول</label>
                                    <input name="length" value="{{old('length', $product->length)}}" type="text" class="form-control form-control-sm">
                                </div>
                                @error('length')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">عرض</label>
                                    <input name="width" value="{{old('width', $product->width)}}" type="text" class="form-control form-control-sm">
                                </div>
                                @error('width')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">ارتفاع</label>
                                    <input name="height" value="{{old('height', $product->height)}}" type="text" class="form-control form-control-sm">
                                </div>
                                @error('height')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">قیمت کالا</label>
                                    <input name="price" value="{{old('price', $product->price)}}" type="text" class="form-control form-control-sm">
                                </div>
                                @error('price')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">توضیحات</label>
                                    <textarea name="introduction" id="introduction" rows="6" class="form-control form-control-sm">{{old('introduction', $product->introduction)}}</textarea>
                                </div>
                                @error('introduction')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" class="form-control form-control-sm" id="status">
                                        <option value="0" @if (old('status', $product->status) == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if (old('status', $product->status) == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('status')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6 my-2">
                                <div class="form-group">
                                    <label for="status">قابل فروش بودن</label>
                                    <select name="marketable" class="form-control form-control-sm" id="marketable">
                                        <option value="0" @if (old('marketable', $product->marketable) == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if (old('marketable', $product->marketable) == 1) selected @endif>فعال</option>
                                    </select>
                                </div>
                                @error('marketable')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="tags">تگ ها</label>
                                    <input class="form-control form-control-sm @error('tags') is-invalid @enderror" type="hidden" name="tags" id="tags" value="{{old('tags', $product->tags)}}">
                                    <select class="select2 form-control form-control-sm" id="select_tags" multiple>

                                    </select>
                                </div>
                                @error('tags')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تاریخ انتشار</label>
                                    <input type="text" name="published_at" id="published_at" class="form-control form-control-sm d-none">
                                    <input id="published_at_view" class="form-control form-control-sm"> 
                                </div>
                                @error('published_at')
                                        <span role="alert" class="alert_required bg-danger text-white p-1 rounded">
                                            <strong>{{$message}}</strong>
                                        </span>
                                @enderror 
                            </section>
                            <section class="col-12 border-top border-bottom mt-2 py-3 mb-3">
                               @foreach ($product->metas as $meta)
                                    <section class="row mb-2">
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="{{$meta->meta_key}}" name="meta_key[{{$meta->id}}]" class="form-control form-control-sm">
                                            </div>
                                            @error('meta_key.*')
                                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                        @enderror
                                        </section>
                                        <section class="col-6 col-md-3">
                                            <div class="form-group">
                                                <input type="text" value="{{$meta->meta_value}}" name="meta_value[]" class="form-control form-control-sm">
                                            </div>
                                            @error('meta_value.*')
                                                <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                                    <strong>{{$message}}</strong>
                                                </span>
                                            @enderror
                                        </section>
                                    </section>
                               @endforeach
                                
                            </section>
                        </section>
                        <section class="col-12">
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
    <script src="{{asset('admin-assets/jalalidatepicker/persian-date.min.js')}}"></script>
    <script src="{{asset('admin-assets/jalalidatepicker/persian-datepicker.min.js')}}"></script>
    <script>
        CKEDITOR.replace('introduction');
    </script>

    {{-- taghvim jalali --}}
    <script>
        $(document).ready(function(){
            $('#published_at_view').persianDatepicker({
                format: 'YYYY/MM/DD',
                altField : '#published_at' 
            });
        });
    </script>
    <script>
        $(document).ready(function(){
            var tags_input = $('#tags');
            var select_tags = $('#select_tags');
            var default_tags = tags_input.val();
            var default_data = null;

            if(tags_input.val()!==null && tags_input.val().length > 0){
                default_data = default_tags.split(',');
            }

            select_tags.select2({
                placeholder: 'لطفا تگ های خود را وارد نمایید',
                tags: true,
                data: default_data
            });

            select_tags.children('option').attr('selected', true).trigger('change');

            $('#form').submit(function( event ){
                if (select_tags.val() !== null && select_tags.val().length > 0) {
                var selectedSource = select_tags.val().join(',');
                tags_input.val(selectedSource);
            }
            });

        });
    </script>
@endsection