@extends('admin.layouts.master')

@section('head-tag')
    <title>روش های ارسال</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">روش های ارسال</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>روش های ارسال</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.delivery.create')}}" class="btn btn-info btn-sm">ایجاد روش ارسال جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام روش ارسال</th>
                                <th>هزینه ارسال</th>
                                <th>زمان ارسال</th>
                                <th>وضعیت</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($delivery_methods as $delivery_method)
                                <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <th>{{$delivery_method->name}}</th>
                                    <td>{{$delivery_method->amount}}تومان</td>
                                    <td>{{$delivery_method->delivery_time}} {{$delivery_method->delivery_time_unit}}</td>
                                    <td>
                                        <input type="checkbox" name="status" id="{{$delivery_method->id}}" data-url="{{route('admin.market.delivery.status', $delivery_method->id)}}" onchange="changeStatus({{$delivery_method->id}})" @if ($delivery_method->status === 1) 
                                        checked      
                                        @endif>
                                    </td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.market.delivery.edit', $delivery_method->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{route('admin.market.delivery.destroy', $delivery_method->id)}}" method="post">
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
                            successToast('فعالسازی روش ارسال با موفقیت انجام شد');
                        }else{

                            element.prop('checked', false); 
                            successToast('غیرفعالسازی روش ارسال با موفقیت انجام شد');
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