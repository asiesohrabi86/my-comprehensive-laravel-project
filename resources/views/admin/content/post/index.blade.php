@extends('admin.layouts.master')

@section('head-tag')
    <title>پست ها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">پست ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>پست ها</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.content.post.create')}}" class="btn btn-info btn-sm">ایجاد پست</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان پست</th>
                                <th>دسته</th>
                                <th>تصویر</th>
                                <th>وضعیت</th>
                                <th>امکان درج کامنت</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $number = 1;
                            @endphp
                            @foreach ($posts as $key => $post)
                                <tr>
                                    <th>{{$key}}</th>
                                    <td>{{$post->title}}</td>
                                    <td>  
                                        {{$post->postCategory->name}}  
                                    </td>
                                    <td>
                                        <img src="{{asset($post->image['indexArray'][$post->image['currentImage']])}}" alt="" height="50" width="100" class="max-height-2rem">
                                    </td>
                                    <td>
                                        <label for="">
                                            <input type="checkbox" data-url = "{{route('admin.content.post.status', $post->id)}}" id="{{$post->id}}" onchange="changeStatus({{$post->id}})" @if ($post->status === 1)
                                                checked
                                            @endif>
                                        </label>
                                    </td>
                                    <td>
                                        <label for="">
                                            <input type="checkbox" data-url = "{{route('admin.content.post.commentable', $post->id)}}" id="{{$post->id}}-commentable" onchange="changeCommentable({{$post->id}})" @if ($post->commentable === 1)
                                                checked
                                            @endif>
                                        </label>
                                    </td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.content.post.edit', $post->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{route('admin.content.post.destroy', $post->id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-alt"></i> حذف</button>
                                        </form>
                                        
                                    </td>
                                </tr> 
                                @php
                                    $number++;
                                @endphp
                            @endforeach
                        </tbody>
                    </table>
                </section>
            </section>
        </section>
    </section>
@endsection

@section('script')
    <script type="text/javascript">

    function changeStatus(id){
            
            var element = $("#" + id);
            var url = element.attr('data-url');
            var elementValue = ! element.prop('checked');
        

            $.ajax({
                    url : url,
                    type : "GET",

                    success: function(response){
                        if(response.status){

                            if(response.checked){
                                element.prop('checked', true);
                                successToast('پست با موفقیت فعال شد');
                            }else{
                                element.prop('checked', false); 
                                successToast('پست با موفقیت غیرفعال شد');
                            }
                        }else{
                            element.prop('checked', elementValue);
                            errorToast('هنگام ویرایش مشگلی به وجود آمده است');
                        }
                    },

                    error: function(){
                        element.prop('checked', elementValue);
                        errorToast('ارتباط برقرار نشد');
                    }

            });

            function successToast(message){
        
                    var successToastTag = '<section class="toast" data-bs-delay="5000">\n'+
                        '<section class="toast-body py-3 d-flex bg-success text-white">\n'+
                            ' <strong class="ms-auto">'+message+'</strong>\n'+
                            '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n'+
                        '</section>\n'+
                        '</section>';

                        $('.toast-wrapper').append(successToastTag);
                        $('.toast').toast('show').delay(5500).queue(function(){
                            $(this).remove();
                        });
            }

            function errorToast(message){
                    var errorToastTag = '<section class="toast" data-bs-delay="5000">\n'+
                        '<section class="toast-body py-3 d-flex bg-danger text-white">\n'+
                            '<strong class="ms-auto">'+message+'</strong>\n'+
                            '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n'+
                            '</section>\n'+
                            '<section>';
                            
                    $('.toast-wrapper').append(errorToastTag);
                    $('.toast').toast('show').delay(5500).queue(function(){
                        $(this).remove();
                    });
            }
    }

    function changeCommentable(id){
            
            var element = $("#" + id + '-commentable');
            var url = element.attr('data-url');
            var elementValue = ! element.prop('checked');
        

            $.ajax({
                    url : url,
                    type : "GET",

                    success: function(response){
                        if(response.commentable){

                            if(response.checked){
                                element.prop('checked', true);
                                successToast('امکان درج کامنت با موفقیت فعال شد');
                            }else{
                                element.prop('checked', false); 
                                successToast('امکان درج کامنت با موفقیت غیرفعال شد');
                            }
                        }else{
                            element.prop('checked', elementValue);
                            errorToast('هنگام ویرایش مشگلی به وجود آمده است');
                        }
                    },

                    error: function(){
                        element.prop('checked', elementValue);
                        errorToast('ارتباط برقرار نشد');
                    }

            });

            function successToast(message){
        
                    var successToastTag = '<section class="toast" data-bs-delay="5000">\n'+
                        '<section class="toast-body py-3 d-flex bg-success text-white">\n'+
                            ' <strong class="ms-auto">'+message+'</strong>\n'+
                            '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n'+
                        '</section>\n'+
                        '</section>';

                        $('.toast-wrapper').append(successToastTag);
                        $('.toast').toast('show').delay(5500).queue(function(){
                            $(this).remove();
                        });
            }

            function errorToast(message){
                    var errorToastTag = '<section class="toast" data-bs-delay="5000">\n'+
                        '<section class="toast-body py-3 d-flex bg-danger text-white">\n'+
                            '<strong class="ms-auto">'+message+'</strong>\n'+
                            '<button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>\n'+
                            '</section>\n'+
                            '<section>';
                            
                    $('.toast-wrapper').append(errorToastTag);
                    $('.toast').toast('show').delay(5500).queue(function(){
                        $(this).remove();
                    });
            }
    }
    </script>
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete']);
@endsection