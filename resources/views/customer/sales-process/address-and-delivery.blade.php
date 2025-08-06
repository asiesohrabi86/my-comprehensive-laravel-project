@extends('customer.layouts.master-two-col')

@section('title')
    مدیریت آدرس ها
@endsection

@section('content')
   <!-- start cart -->
   <section class="mb-4">
        <section class="container-xxl" >
            <section class="row">
                <section class="col">
                    <!-- start vontent header -->
                    <section class="content-header">
                        <section class="d-flex justify-content-between align-items-center">
                            <h2 class="content-header-title">
                                <span>تکمیل اطلاعات ارسال کالا (آدرس گیرنده، مشخصات گیرنده، نحوه ارسال) </span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        @if ($errors->any())
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li class="text-danger">{{$error}}</li>
                                @endforeach
                            </ul>
                        @endif
                        <section class="col-md-9">
                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب آدرس و مشخصات گیرنده
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>

                                <section class="address-alert alert alert-primary d-flex align-items-center p-2" role="alert">
                                    <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                    <secrion>
                                        پس از ایجاد آدرس، آدرس را انتخاب کنید.
                                    </secrion>
                                </section>


                                <section class="address-select">
                                    @foreach (auth()->user()->addresses as $address)
                                        <input type="radio" name="address_id" form="myForm" value="{{$address->id}}" id="a-{{$address->id}}"/> <!--checked="checked"-->
                                        <label for="a-{{$address->id}}" class="address-wrapper mb-2 p-2">
                                            <section class="mb-2">
                                                <i class="fa fa-map-marker-alt mx-1"></i>
                                                آدرس : {{convertEnglishToPersian($address->address) ?? '-'}}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-user-tag mx-1"></i>
                                                گیرنده : {{$address->recepient_first_name ?? '-'}} {{$address->recepient_last_name ?? '-'}}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-mobile-alt mx-1"></i>
                                                موبایل گیرنده : {{'٠'.convertEnglishToPersian($address->mobile) ?? '-'}}
                                            </section>
                                            {{-- <a class="" href="#"><i class="fa fa-edit"></i> ویرایش آدرس</a> --}}
                                            <a onclick="editAddress({{$address->id}})" id="edit-btn-{{$address->id}}" type="button" data-bs-toggle="modal" data-bs-target="#edit-address"><i class="fa fa-edit"></i> ویرایش آدرس</a>
                                            <span class="address-selected">کالاها به این آدرس ارسال می شوند</span>
                                        </label>
                                    @endforeach
                                    <!-- start edit address Modal -->
                                    <section class="modal fade" id="edit-address" tabindex="-1" aria-labelledby="add-address-label" aria-hidden="true">
                                        <section class="modal-dialog">
                                            <section class="modal-content">
                                                <section class="modal-header">
                                                    <h5 class="modal-title" id="add-address-label"><i class="fa fa-edit"></i> ویرایش آدرس</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </section>
                                                <section class="modal-body">
                                                    <form method="post" class="row" id="edit-form" action="">
                                                        @csrf
                                                        @method('PUT')
                                                        <section class="col-6 mb-2">
                                                            <label for="edit-province" class="form-label mb-1">استان</label>
                                                            <select name="province_id" class="form-select form-select-sm" id="edit-province">
                                                                <option value="" selected>استان را انتخاب کنید</option>
                                                                @foreach ($provinces as $province)
                                                                    <option value="{{$province->id}}" data-url="{{route('customer.sales-process.get-cities', $province->id)}}">{{$province->name}}</option>
                                                                @endforeach
                                                            </select>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="city" class="form-label mb-1">شهر</label>
                                                            <select name="city_id" class="form-select form-select-sm" id="edit-city">
                                                                <option selected>شهر را انتخاب کنید</option>
                                                            </select>
                                                        </section>
                                                        <section class="col-12 mb-2">
                                                            <label for="address" class="form-label mb-1">نشانی</label>
                                                            <textarea name="address" class="form-control form-control-sm" id="edit-address" placeholder="نشانی"></textarea>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="edit-postal_code" class="form-label mb-1">کد پستی</label>
                                                            <input type="text" name="postal_code" class="form-control form-control-sm" id="edit-postal_code" placeholder="کد پستی">
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="no" class="form-label mb-1">پلاک</label>
                                                            <input type="text" name="no" class="form-control form-control-sm" id="edit-no" placeholder="پلاک">
                                                        </section>

                                                        <section class="col-3 mb-2">
                                                            <label for="unit" class="form-label mb-1">واحد</label>
                                                            <input type="text" name="unit" class="form-control form-control-sm" id="edit-unit" placeholder="واحد">
                                                        </section>
                                                        
                                                        <section class="border-bottom mt-2 mb-3"></section>

                                                        <section class="col-12 mb-2">
                                                            <section class="form-check">
                                                                <input class="form-check-input" type="checkbox" name="reciever" id="edit-reciever">
                                                                <label class="form-check-label" for="reciever">
                                                                    گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                                                </label>
                                                            </section>
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="first_name" class="form-label mb-1">نام گیرنده</label>
                                                            <input type="text" name="recepient_first_name" class="form-control form-control-sm" id="edit-first_name" placeholder="نام گیرنده">
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="last_name" class="form-label mb-1">نام خانوادگی گیرنده</label>
                                                            <input type="text" name="recepient_last_name" class="form-control form-control-sm" id="edit-last_name" placeholder="نام خانوادگی گیرنده">
                                                        </section>

                                                        <section class="col-6 mb-2">
                                                            <label for="mobile" class="form-label mb-1">شماره موبایل</label>
                                                            <input type="text" name="mobile" class="form-control form-control-sm" id="edit-mobile" placeholder="شماره موبایل">
                                                        </section>
 
                                                </section>
                                                <section class="modal-footer py-1">
                                                    <button type="submit" class="btn btn-sm btn-primary">ثبت آدرس</button>
                                                    <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بستن</button>
                                                </section>
                                            </form>
                                            </section>
                                        </section>
                                    </section>
                                    <!-- end edit address Modal -->

                                    <section class="address-add-wrapper">
                                        <button class="address-add-button" type="button" data-bs-toggle="modal" data-bs-target="#add-address" ><i class="fa fa-plus"></i> ایجاد آدرس جدید</button>
                                        <!-- start add address Modal -->
                                        <section class="modal fade" id="add-address" tabindex="-1" aria-labelledby="add-address-label" aria-hidden="true">
                                            <section class="modal-dialog">
                                                <section class="modal-content">
                                                    <section class="modal-header">
                                                        <h5 class="modal-title" id="add-address-label"><i class="fa fa-plus"></i> ایجاد آدرس جدید</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </section>
                                                    <section class="modal-body">
                                                        <form method="post" class="row" action="{{route('customer.sales-process.add-address')}}">
                                                            @csrf
                                                            <section class="col-6 mb-2">
                                                                <label for="province" class="form-label mb-1">استان</label>
                                                                <select name="province_id" class="form-select form-select-sm" id="province">
                                                                    <option selected>استان را انتخاب کنید</option>
                                                                    @foreach ($provinces as $province)
                                                                        <option value="{{$province->id}}" data-url="{{route('customer.sales-process.get-cities', $province->id)}}">{{$province->name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="city" class="form-label mb-1">شهر</label>
                                                                <select name="city_id" class="form-select form-select-sm" id="city">
                                                                    <option selected>شهر را انتخاب کنید</option>
                                                                </select>
                                                            </section>
                                                            <section class="col-12 mb-2">
                                                                <label for="address" class="form-label mb-1">نشانی</label>
                                                                <textarea name="address" class="form-control form-control-sm" id="address" placeholder="نشانی"></textarea>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="postal_code" class="form-label mb-1">کد پستی</label>
                                                                <input type="text" name="postal_code" class="form-control form-control-sm" id="postal_code" placeholder="کد پستی">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="no" class="form-label mb-1">پلاک</label>
                                                                <input type="text" name="no" class="form-control form-control-sm" id="no" placeholder="پلاک">
                                                            </section>

                                                            <section class="col-3 mb-2">
                                                                <label for="unit" class="form-label mb-1">واحد</label>
                                                                <input type="text" name="unit" class="form-control form-control-sm" id="unit" placeholder="واحد">
                                                            </section>
                                                            
                                                            <section class="border-bottom mt-2 mb-3"></section>

                                                            <section class="col-12 mb-2">
                                                                <section class="form-check">
                                                                    <input class="form-check-input" type="checkbox" name="reciever" id="reciever">
                                                                    <label class="form-check-label" for="reciever">
                                                                        گیرنده سفارش خودم نیستم (اطلاعات زیر تکمیل شود)
                                                                    </label>
                                                                </section>
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="first_name" class="form-label mb-1">نام گیرنده</label>
                                                                <input type="text" name="recepient_first_name" class="form-control form-control-sm" id="first_name" placeholder="نام گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="last_name" class="form-label mb-1">نام خانوادگی گیرنده</label>
                                                                <input type="text" name="recepient_last_name" class="form-control form-control-sm" id="last_name" placeholder="نام خانوادگی گیرنده">
                                                            </section>

                                                            <section class="col-6 mb-2">
                                                                <label for="mobile" class="form-label mb-1">شماره موبایل</label>
                                                                <input type="text" name="mobile" class="form-control form-control-sm" id="mobile" placeholder="شماره موبایل">
                                                            </section>


                                                        
                                                    </section>
                                                    <section class="modal-footer py-1">
                                                        <button type="submit" class="btn btn-sm btn-primary">ثبت آدرس</button>
                                                        <button type="button" class="btn btn-sm btn-danger" data-bs-dismiss="modal">بستن</button>
                                                    </section>
                                                </form>
                                                </section>
                                            </section>
                                        </section>
                                        <!-- end add address Modal -->
                                    </section>

                                </section>
                            </section>


                            <section class="content-wrapper bg-white p-3 rounded-2 mb-4">

                                <!-- start vontent header -->
                                <section class="content-header mb-3">
                                    <section class="d-flex justify-content-between align-items-center">
                                        <h2 class="content-header-title content-header-title-small">
                                            انتخاب نحوه ارسال
                                        </h2>
                                        <section class="content-header-link">
                                            <!--<a href="#">مشاهده همه</a>-->
                                        </section>
                                    </section>
                                </section>
                                <section class="delivery-select ">

                                    <section class="address-alert alert alert-primary d-flex align-items-center p-2" role="alert">
                                        <i class="fa fa-info-circle flex-shrink-0 me-2"></i>
                                        <secrion>
                                            نحوه ارسال کالا را انتخاب کنید. هنگام انتخاب لطفا مدت زمان ارسال را در نظر بگیرید.
                                        </secrion>
                                    </section>

                                    @foreach($deliveryMethods as $deliveryMethod)
                                        <input type="radio" name="delivery_id" form="myForm" value="{{$deliveryMethod->id}}" id="d-{{$deliveryMethod->id}}"/>
                                        <label for="d-{{$deliveryMethod->id}}" class="col-12 col-md-4 delivery-wrapper mb-2 pt-2">
                                            <section class="mb-2">
                                                <i class="fa fa-shipping-fast mx-1"></i>
                                                {{$deliveryMethod->name}}
                                            </section>
                                            <section class="mb-2">
                                                <i class="fa fa-calendar-alt mx-1"></i>
                                                تامین کالا از {{$deliveryMethod->delivery_time}} {{$deliveryMethod->delivery_time_unit}} کاری آینده
                                            </section>
                                        </label>
                                    @endforeach

                                </section>
                            </section>

                        </section>
                        <section class="col-md-3">
                            <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                                @php
                                    $totalProductPrice = 0;
                                    $totalDiscount = 0;
                                @endphp

                                @foreach($cartItems as $cartItem)
                                    @php
                                        $totalProductPrice += $cartItem->cartItemProductPrice() * $cartItem->number;
                                        $totalDiscount += $cartItem->cartItemProductDiscount() * $cartItem->number;
                                    @endphp
                                @endforeach

                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                    <p class="text-muted"><span  id="total_product_price">{{ priceFormat($totalProductPrice) }}</span> تومان</p>
                                </section>

                                @if($totalDiscount != 0)
                                    <section class="d-flex justify-content-between align-items-center">
                                        <p class="text-muted">تخفیف کالاها</p>
                                        <p class="text-danger fw-bolder"><span id="total_discount">{{ priceFormat($totalDiscount) }}</span> تومان</p>
                                    </section>
                                @endif
                                <section class="border-bottom mb-3"></section>
                                <section class="d-flex justify-content-between align-items-center">
                                    <p class="text-muted">جمع سبد خرید</p>
                                    <p class="fw-bolder"><span id="total_price">{{ priceFormat($totalProductPrice - $totalDiscount) }}</span> تومان</p>
                                </section>

                                <p class="my-3">
                                    <i class="fa fa-info-circle me-1"></i>کاربر گرامی  خرید شما هنوز نهایی نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد.
                                </p>

                                <form action="{{route('customer.sales-process.choose-address-and-delivery')}}" method="post" id="myForm">
                                    @csrf
                                </form>
                                <section class="">
                                    <button type="button" onclick="document.getElementById('myForm').submit();" class="btn btn-danger d-block w-100"
                                        >تکمیل فرآیند خرید
                                    </button>
                                </section>

                            </section>
                        </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

@endsection

@section('script')
    {{-- <script>
        $(document).ready(function(){
            $('#province').change(function(){
                var element = $('#province option:selected');
                var url = element.attr('data-url');

                $.ajax({
                    url: url,
                    type: "GET",
                    success: function(response) {
                        if (response.status) {
                            let cities = response.cities;
                            $('#city').empty();
                            cities.map(city => {
                                $('#city').append($('<option/>').val(city.id).text(city.name));
                            });
                        }else{
                            errorToast('خطایی پیش آمده است');
                        }
                        
                    },
                    error: function() {
                        errorToast('خطایی پیش آمده است');
                    }
                })
            });
        });
    </script> --}}
    {{-- ********************************************** --}}
   <script>
       const provinceSelect = document.getElementById('province');
       const provinceEditSelect = document.getElementById('edit-province');
    
        const provinceNodes = [provinceSelect, provinceEditSelect];
        provinceNodes.forEach(provinceNode => {
            provinceNode.addEventListener('change', (e) => {
            const province_id = provinceNode.value;
            const response = fetch(`/get-cities/${province_id}`)
            .then(response => response.json())
            .then(result => {
                if(result.status){
                    // const cities = result.cities;
                    const cities = result['cities'];
                    const citySelect = provinceNode.parentNode.nextElementSibling.children[1];
                    
                    citySelect.innerHTML = '<option selected>شهر را انتخاب کنید</option>';
                    cities.forEach(city => {
                        citySelect.insertAdjacentHTML('beforeEnd', `<option value="${city.id}">${city.name}</option>`);
                    });
                }else{
                    errorToast('خطایی پیش آمده است');
                }
                
            }).catch(error => errorToast('خطایی پیش آمده است'));
            
        });
        });
       
   </script>
   {{-- ********************************************** --}}
   <script>
        const editBtn = document.getElementById('edit-btn');
        const editProvinces = document.querySelectorAll('#edit-province > option');
        const editCity = document.getElementById('edit-city');
        const edit_address = document.querySelector('#edit-address textarea');
        const editPostalCode = document.getElementById('edit-postal_code');
        const editNo = document.getElementById('edit-no');
        const editUnit = document.getElementById('edit-unit');
        const editFirstName = document.getElementById('edit-first_name');
        const editLastName = document.getElementById('edit-last_name');
        const editMobile = document.getElementById('edit-mobile');
        
        function editAddress(id) {
            document.getElementById('edit-form').action = `/update-address/${id}`;
            const response = fetch(`/edit-address/${id}`)
                .then(response => response.json())
                .then(result => {
                    const address = result.address;
                   
                    editProvinces.forEach(editProvince => {
                        
                        if (editProvince.value != address.province_id) {
                            editProvince.removeAttribute('selected');
                        }
                        else if(editProvince.value == address.province_id){
                            editProvince.setAttribute('selected', true);
                        }
                    });

                    const cities = result.cities;
                    editCity.innerHTML = '<option selected>شهر را انتخاب کنید</option>';
                    cities.forEach(city => {
                        editCity.insertAdjacentHTML('beforeEnd', `<option value="${city.id}" ${address.city_id == city.id && 'selected'}>${city.name}</option>`);
                    });

                    edit_address.innerHTML = toFarsiNumber(address.address);
                    editPostalCode.value = toFarsiNumber(address.postal_code);
                    editNo.value = toFarsiNumber(address.no);
                    editUnit.value = toFarsiNumber(address.unit);
                    if(address.recepient_first_name != null){
                        document.getElementById('edit-reciever').setAttribute('checked', true);
                    }
                    else{
                        document.getElementById('edit-reciever').removeAttribute('checked'); 
                    }
                    
                    editFirstName.value = address.recepient_first_name ?? '';
                    editLastName.value = address.recepient_last_name ?? '';
                    editMobile.value = address.mobile ? toFarsiNumber(address.mobile) : '';

                }).catch(error => console.log(error));
        }
   </script>
   <script>
        function toFarsiNumber(number)
        {
            const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            //convert to persian
            return number.toString().replace(/\d/g, x => farsiDigits[x]);
        }
   </script>
@endsection