@extends('customer.layouts.master-two-col')

@section('title')
    سبد خرید شما
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
                                <span>سبد خرید شما</span>
                            </h2>
                            <section class="content-header-link">
                                <!--<a href="#">مشاهده همه</a>-->
                            </section>
                        </section>
                    </section>

                    <section class="row mt-4">
                        <section class="col-md-9 mb-3">
                            <form action="" id="cart_items" method="post" class="content-wrapper bg-white p-3 rounded-2">
                                @csrf
                                @php
                                    $totalProductPrice = 0;
                                    $totalDiscount = 0;
                                @endphp

                                @foreach ($cartItems as $cartItem)
                                    @php
                                        $totalProductPrice += $cartItem->cartItemProductPrice();
                                        $totalDiscount += $cartItem->cartItemProductDiscount();
                                    @endphp

                                    <section class="cart-item d-md-flex py-3">
                                        <section class="cart-img align-self-start flex-shrink-1">
                                            <img src="{{ asset($cartItem->product->image['indexArray']['medium']) }}" alt="">
                                        </section>
                                        <section class="align-self-start w-100">
                                            <p class="fw-bold">{{ $cartItem->product->name }}</p>
                                            <p>
                                                @if(!empty($cartItem->color))
                                                <span style="background-color: {{ $cartItem->color->color }};" class="cart-product-selected-color me-1"></span> <span> {{ $cartItem->color->color_name }}</span>
                                                @else
                                                <span>رنگ منتخب وجود ندارد</span>
                                                @endif
                                            </p>
                                            <p>
                                                @if(!empty($cartItem->guarantee))
                                                <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span> {{ $cartItem->guarantee->name }}</span>
                                                @else
                                                <i class="fa fa-shield-alt cart-product-selected-warranty me-1"></i> <span> گارانتی ندارد</span>
                                                @endif
                                            </p>
                                            <p><i class="fa fa-store-alt cart-product-selected-store me-1"></i> <span>کالا موجود در انبار</span></p>
                                            <section>
                                                <section class="cart-product-number d-inline-block ">
                                                    <button class="cart-number cart-number-down" type="button">-</button>
                                                    <input class="number" name="number[{{ $cartItem->id }}]" data-product-price={{ $cartItem->cartItemProductPrice() }} data-product-discount={{ $cartItem->cartItemProductDiscount() }}  type="number" min="1" max="5" step="1" value="{{ $cartItem->number }}" readonly="readonly">
                                                    <button class="cart-number cart-number-up" type="button">+</button>
                                                </section>
                                                <a class="text-decoration-none ms-4 cart-delete" href="{{ route('customer.sales-process.remove-from-cart', $cartItem) }}"><i class="fa fa-trash-alt"></i> حذف از سبد</a>
                                            </section>
                                        </section>
                                        <section class="align-self-end flex-shrink-1">
                                            @if(!empty($cartItem->product->activeAmazingSales()))
                                                <section class="cart-item-discount text-danger text-nowrap mb-1">تخفیف {{ priceFormat($cartItem->cartItemProductDiscount()) }}</section>
                                            @endif
                                            <section class="text-nowrap fw-bold">{{ priceFormat($cartItem->cartItemProductPrice()) }} تومان</section>
                                        </section>
                                    </section>
                                @endforeach

                            </form>

                        </section>
                    <section class="col-md-3">
                        <section class="content-wrapper bg-white p-3 rounded-2 cart-total-price">
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">قیمت کالاها ({{ $cartItems->count() }})</p>
                                <p class="text-muted" id="total_product_price">{{ priceFormat($totalProductPrice) }} تومان</p>
                            </section>

                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">تخفیف کالاها</p>
                                <p class="text-danger fw-bolder" id="total_discount">{{ priceFormat($totalDiscount) }} تومان</p>
                            </section>
                            <section class="border-bottom mb-3"></section>
                            <section class="d-flex justify-content-between align-items-center">
                                <p class="text-muted">جمع سبد خرید</p>
                                <p class="fw-bolder" id="total_price">{{ priceFormat($totalProductPrice - $totalDiscount) }} تومان</p>
                            </section>

                            <p class="my-3">
                                <i class="fa fa-info-circle me-1"></i>کاربر گرامی  خرید شما هنوز نهایی نشده است. برای ثبت سفارش و تکمیل خرید باید ابتدا آدرس خود را انتخاب کنید و سپس نحوه ارسال را انتخاب کنید. نحوه ارسال انتخابی شما محاسبه و به این مبلغ اضافه شده خواهد شد. و در نهایت پرداخت این سفارش صورت میگیرد.
                            </p>

                            <section class="">
                                <button onclick="document.getElementById('cart_items').submit();" class="btn btn-danger d-block w-100">تکمیل فرآیند خرید</button>
                            </section>

                        </section>
                    </section>
                    </section>
                </section>
            </section>

        </section>
    </section>
    <!-- end cart -->

    <section class="mb-4">
        <section class="container-xxl" >
            <section class="row">
                <section class="col">
                    <section class="content-wrapper bg-white p-3 rounded-2">
                        <!-- start vontent header -->
                        <section class="content-header">
                            <section class="d-flex justify-content-between align-items-center">
                                <h2 class="content-header-title">
                                    <span>کالاهای مرتبط با سبد خرید شما</span>
                                </h2>
                                <section class="content-header-link">
                                    <!--<a href="#">مشاهده همه</a>-->
                                </section>
                            </section>
                        </section>
                        <!-- start vontent header -->
                        <section class="lazyload-wrapper" >
                            <section class="lazyload light-owl-nav owl-carousel owl-theme">

                                @foreach ($relatedProducts as $relatedProduct)
                                    <section class="item">
                                        <section class="lazyload-item-wrapper">
                                            <section class="product">
                                                <section class="product-add-to-cart"><a href="#" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به سبد خرید"><i class="fa fa-cart-plus"></i></a></section>
                                                @guest
                                                    <section class="product-add-to-favorite">
                                                        <button data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"
                                                            class="btn btn-sm btn-light text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                            <i class="fa fa-heart" data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"></i>
                                                        </button>
                                                    </section>
                                                @endguest
                                                @auth
                                                    @if($relatedProduct->user->contains(auth()->user()->id))
                                                        <section class="product-add-to-favorite">
                                                            <button data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"
                                                                class="btn btn-sm btn-light text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" title="حذف از علاقه مندی">
                                                                <i class="fa fa-heart text-danger" data-id="icon-{{$relatedProduct->id}}" data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"></i>
                                                            </button>
                                                        </section>

                                                    @else
                                                        <section class="product-add-to-favorite">
                                                            <button data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"
                                                                class="btn btn-sm btn-light text-decoration-none" data-bs-toggle="tooltip" data-bs-placement="left" title="افزودن به علاقه مندی">
                                                                <i class="fa fa-heart" data-id="icon-{{$relatedProduct->id}}" data-url="{{route('customer.market.add-to-favorite', $relatedProduct->slug)}}"></i>
                                                            </button>
                                                        </section>

                                                    @endif
                                                    
                                                @endauth
                                                <a class="product-link" href="#">
                                                    <section class="product-image">
                                                        <img class="" src="{{asset($relatedProduct->image['indexArray']['medium'])}}" alt="">
                                                    </section>
                                                    <section class="product-name"><h3>{{$relatedProduct->name}}</h3></section>
                                                    <section class="product-price-wrapper">
                                                        <section class="product-price">{{priceFormat($relatedProduct->price)}} تومان</section>
                                                    </section>
                                                    <section class="product-colors">
                                                        @foreach ($relatedProduct->colors as $color)
                                                            <section class="product-colors-item" style="background-color: {{$color->color}};"></section>
                                                        @endforeach
                                                    </section>
                                                </a>
                                            </section>
                                        </section>
                                    </section>
                                @endforeach
                               
                            </section>
                        </section>
                    </section>
                </section>
            </section>
        </section>
    </section>

@endsection

@section('script')
    <script>
        $(document).ready(function(){
            bill();

            $('.cart-number').click(function() {
                bill();

            })
        })

        function bill() {
            var total_product_price = 0;
            var total_discount = 0;
            var total_price = 0;

            $('.number').each(function() {
                var productPrice = parseFloat($(this).data('product-price'));
                var productDiscount = parseFloat($(this).data('product-discount'));
                var number = parseFloat($(this).val());

                total_product_price += productPrice * number;
                total_discount += productDiscount * number;
            })

            total_price = total_product_price - total_discount;

            $('#total_product_price').html(toFarsiNumber(total_product_price));
            $('#total_discount').html(toFarsiNumber(total_discount));
            $('#total_price').html(toFarsiNumber(total_price));


            function toFarsiNumber(number)
            {
                const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                // add comma
                number = new Intl.NumberFormat().format(number);
                //convert to persian
                return number.toString().replace(/\d/g, x => farsiDigits[x]);
            }

        }

    </script>
    {{-- ***************************************************** --}}
    {{-- <script>
        document.addEventListener('DOMContentLoaded', () => {
            bill();
        });

        document.querySelectorAll('.cart-number').forEach(numberButton => {
            numberButton.addEventListener('click', () => {
                bill();
            });
        });

        function bill()
        {
            var total_product_price = 0;
            var total_product_discount = 0;
            var total_price = 0;

            document.querySelectorAll('.number').forEach(numberInput => {
                var product_price = parseFloat(numberInput.dataset.productPrice);
                var product_discount = parseFloat(numberInput.dataset.productDiscount);
                var number = parseFloat(numberInput.value);
        
                total_product_price += product_price * number;
                total_product_discount += product_discount * number;
            });

            total_price = total_product_price - total_product_discount;

            document.getElementById('total_product_price').innerHTML = toFarsiNumber(total_product_price);
            document.getElementById('total_discount').innerHTML = toFarsiNumber(total_product_discount);
            document.getElementById('total_price').innerHTML = toFarsiNumber(total_price);
        }

        function toFarsiNumber(number)
            {
                const farsiDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
                // add comma
                number = new Intl.NumberFormat().format(number);
                //convert to persian
                return number.toString().replace(/\d/g, x => farsiDigits[x]);
            }
        
    </script> --}}

    {{-- ************************************************************ --}}
    <script>
        const favoriteButtons = document.querySelectorAll('.product-add-to-favorite button i');
        console.log(favoriteButtons);
        
        favoriteButtons.forEach(favoriteButton => {
            
            favoriteButton.addEventListener('click', (e) => {

                var url = e.target.dataset.url;
                
                fetch(url).then(response => response.json())
                .then(result => {
                    if (result.status == 1) {
                        var targetId = e.target.dataset.id;
                        var targets = document.querySelectorAll(`i[data-id=${targetId}]`);
                        targets.forEach(target => {
                            target.classList.add('text-danger');
                            target.parentNode.setAttribute('data-bs-original-title', 'حذف از علاقه مندی');
                        });
                        
                    }else if(result.status == 2){
                        var targetId = e.target.dataset.id;
                        var targets = document.querySelectorAll(`i[data-id=${targetId}]`);
                        targets.forEach(target => {
                            target.classList.remove('text-danger');
                            target.parentNode.setAttribute('data-bs-original-title', 'افزودن به علاقه مندی');
                        });
            
                    }else if(result.status == 3){
                        $('.toast').toast('show');
                    }
                }).catch(error => console.log(error));
            
            });
        });
        
    </script>
@endsection