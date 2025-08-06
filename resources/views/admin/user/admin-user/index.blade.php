@extends('admin.layouts.master')

@section('head-tag')
    <title>کاربران ادمین</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش کاربران</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">کاربران ادمین</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>کاربران ادمین</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.user.admin-user.create')}}" class="btn btn-info btn-sm">ایجاد ادمین جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ایمیل</th>
                                <th>شماره موبایل</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>فعالسازی</th>
                                <th>وضعیت</th>
                                <th>نقش</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($admins as $key => $admin)
                            <tr>
                                <th>{{$key+1}}</th>
                                <td>{{$admin->email}}</td>
                                <td>{{$admin->mobile}}</td>
                                <td>{{$admin->first_name}}</td>
                                <td>{{$admin->last_name}}</td>
                                <td>
                                    <input type="checkbox" name="activation" id="{{$admin->id}}-active" data-url="{{route('admin.user.admin-user.activation', $admin->id)}}" onchange="changeActivation({{$admin->id}})" @if ($admin->activation === 1) 
                                    checked      
                                    @endif>
                                </td>
                                <td>
                                    <input type="checkbox" name="status" id="{{$admin->id}}" data-url="{{route('admin.user.admin-user.status', $admin->id)}}" onchange="changeStatus({{$admin->id}})" @if ($admin->status === 1) 
                                    checked      
                                    @endif>
                                </td>
                                <td>{{$admin->user_type == 1 ? 'سوپرادمین' : 'ادمین'}}</td>
                                <td class="text-start width-22-rem">
                                    <a href="#" class="btn btn-sm btn-warning"><i class="fa fa-edit"></i> نقش</a>
                                    <a href="{{route('admin.user.admin-user.edit', $admin->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                    <form class="d-inline" action="{{route('admin.user.admin-user.destroy', $admin->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm delete"><i class="fa fa-trash-alt"></i> حذف</button>
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
   
        function changeActivation(id){
            
            var element = $("#" + id + "-active");
            var url = element.attr('data-url');
            var elementValue = !element.prop('checked');

            $.ajax({
                url : url,
                type : "GET",

                success : function(response){
                    if(response.status){

                        if (response.checked) {
                            element.prop('checked', true);
                            successToast('فعالسازی ادمین با موفقیت انجام شد');
                        }else{

                            element.prop('checked', false); 
                            successToast('غیرفعالسازی ادمین با موفقیت انجام شد');
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
                            successToast('ادمین با موفقیت فعال شد');
                        }else{

                            element.prop('checked', false); 
                            successToast('ادمین با موفقیت غیرفعال شد');
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