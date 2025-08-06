@extends('admin.layouts.master')

@section('head-tag')
    <title>منو</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش محتوی</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">منو</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>منو</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.content.menu.create')}}" class="btn btn-info btn-sm">ایجاد منوی جدید</a>
                    <div class="max-width-16-rem">
                        <input type="text" class="form-control form-control-sm form-text" placeholder="جستجو">
                    </div>
                </section>

                <section class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام منو</th>
                                <th>منوی والد</th>
                                <th>لینک منو</th>
                                <th>وضعیت</th>
                                <th class="text-center max-width-16-rem"><i class="fa fa-cogs"></i> تنظیمات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $key => $menu)
                                <tr>
                                    <th>{{$key+=1}}</th>
                                    <td>{{$menu->name}}</td>
                                    <td>{{$menu->parent_id ? $menu->parent->name : 'منوی اصلی'}}</td>
                                    <td>{{$menu->url}}</td>
                                    <td>
                                        <input type="checkbox" id="{{$menu->id}}" data-url="{{route('admin.content.menu.status', $menu->id)}}" onchange="changeStatus({{$menu->id}})" @if ($menu->status == 1)
                                            checked
                                        @endif>
                                    </td>
                                    <td class="text-start width-16-rem">
                                        <a href="{{route('admin.content.menu.edit', $menu->id)}}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i> ویرایش</a>
                                        <form action="{{route('admin.content.menu.destroy', $menu->id)}}" class="d-inline me-2" method="post">
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
                                    successToast('منو با موفقیت فعال شد');
                                }else{
                                    element.prop('checked', false); 
                                    successToast('منو با موفقیت غیرفعال شد');
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