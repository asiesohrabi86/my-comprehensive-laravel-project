@extends('admin.layouts.master')

@section('head-tag')
    <title>بنرها</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">بنرها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>بنرها</h5>
                </section>

                @include('admin.alerts.alert-section.success')
                
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.content.banner.create')}}" class="btn btn-info btn-sm">ایجاد بنرها</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>عنوان بنر</th>
                                <th>آدرس</th>
                                <th>تصویر</th>
                                <th>وضعیت</th>
                                <th>مکان</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($banners as $key => $banner)
                            <tr>
                                <th>{{$key += 1}}</th>
                                <td>{{$banner->title}}</td>
                                <td>{{$banner->url}}</td>
                                <td>
                                    <img src="{{asset($banner->image)}}" alt="" width="100" height="50">
                                </td>
                                <td>
                                    <label for="">
                                        <input type="checkbox" data-url = "{{route('admin.content.banner.status', $banner->id)}}" id="{{$banner->id}}" onchange="changeStatus({{$banner->id}})" @if($banner->status === 1)
                                          checked
                                        @endif>
                                    </label>
                                </td>
                                <td>{{$positions[$banner->position]}}</td>
                                <td class="width-16-rem">
                                    <a href="{{route('admin.content.banner.edit', $banner->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                    <form class="d-inline" action="{{route('admin.content.banner.destroy', $banner->id)}}" method="post">
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
     <script type="text/javascript">
   
        function changeStatus(id){
            
            var element = $("#" + id);
            var url = element.attr('data-url');
            var elementValue = !element.prop('checked');

            $.ajax({
                url : url,
                type : "GET",

                success : function(response){
                    if(response.status){

                        if (response.checked) {
                            element.prop('checked', true);
                            successToast('بنر با موفقیت فعال شد');
                        }else{

                            element.prop('checked', false); 
                            successToast('بنر با موفقیت غیرفعال شد');
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
    @include('admin.alerts.sweetalert.delete-confirm', ['className' => 'delete'])
@endsection