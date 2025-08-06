@extends('admin.layouts.master')

@section('head-tag')
    <title>سئوالات متداول</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">سئوالات متداول</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش سئوال</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش سئوال</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.content.faq.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.content.faq.update', $faq->id)}}" id="form" method="post">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">پرسش</label>
                                    <input class="form-control form-control-sm @error('question')
                                        is-invalid
                                    @enderror" type="text" name="question" value="{{old('question', $faq->question)}}">
                                </div>
                                @error('question')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="">پاسخ</label>
                                    <textarea class="form-control form-control-sm @error('answer')
                                       is-invalid 
                                    @enderror" rows="4" name="answer" id="answer" type="text">{{old('answer', $faq->answer)}}</textarea>
                                </div>
                                @error('answer')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="tags">تگ ها</label>
                                    <input class="form-control form-control-sm @error('tags') is-invalid @enderror" type="hidden" name="tags" id="tags" value="{{old('tags', $faq->tags)}}">
                                    <select class="select2 form-control form-control-sm" id="select_tags" multiple>

                                    </select>
                                </div>
                                @error('tags')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12">
                                <div class="form-group">
                                    <label for="status">وضعیت</label>
                                    <select name="status" class="form-control form-control-sm" id="status">
                                        <option value="0" @if (old('status', $faq->status) == 0) selected @endif>غیرفعال</option>
                                        <option value="1" @if (old('status', $faq->status) == 1) selected @endif>فعال</option>
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
        CKEDITOR.replace('answer');
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