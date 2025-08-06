@extends('admin.layouts.master')

@section('head-tag')
    <title>تیکت</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش تیکت ها</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">اولویت تیکت ها</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>اولویت تیکت ها</h5>
                </section>

                {{-- @include('admin.alerts.alert-section.success') --}}

                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.ticket.priority.create')}}" class="btn btn-info btn-sm">ایجاد اولویت</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام اولویت</th>
                                <th>وضعیت</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($ticketPriorities as $key => $ticketPriority )
                                <tr>
                                    <th>{{$key+1}}</th>
                                    <td>{{$ticketPriority->name}}</td>
                                    <td>
                                        <input type="checkbox" id="{{$ticketPriority->id}}" data-url="{{route('admin.ticket.priority.status', $ticketPriority->id)}}"
                                         onchange="changeStatus({{$ticketPriority->id}})" @if ($ticketPriority->status === 1)
                                            checked 
                                         @endif>
                                    </td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.ticket.priority.edit', $ticketPriority->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form class="d-inline" action="{{route('admin.ticket.priority.destroy', $ticketPriority->id)}}" method="post">
                                            @csrf
                                            {{-- @method('delete') --}}
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
                            successToast('اولویت با موفقیت فعال شد');
                        }else{

                            element.prop('checked', false); 
                            successToast('اولویت با موفقیت غیرفعال شد');
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