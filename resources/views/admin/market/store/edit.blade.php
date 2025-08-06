@extends('admin.layouts.master')

@section('head-tag')
    <title>ویرایش انبار</title>
@endsection

@section('content')
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
        <li class="breadcrumb-item font-size-12"><a href="#">خانه</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">بخش فروش</a></li>
        <li class="breadcrumb-item font-size-12"><a href="#">انبار</a></li>
        <li class="breadcrumb-item font-size-12 active" aria-current="page">ویرایش انبار</li>
        </ol>
    </nav>

    <section class="row">
        <section class="col-12">
            <section class="main-body-container">
                <section class="main-body-container-header">
                    <h5>ویرایش انبار</h5>
                </section>
                <section class="d-flex justify-content-between align-items-center mt-4 mb-3 border-bottom pb-2">
                    <a href="{{route('admin.market.store.index')}}" class="btn btn-info btn-sm">بازگشت</a>
                </section>
                <section>
                    <form action="{{route('admin.market.store.update', $product->id)}}" method="post">
                        @csrf
                        @method('PUT')
                        <section class="row">
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تعداد قابل فروش</label>
                                    <input name="marketable_number" value="{{old('marketable_number', $product->marketable_number)}}" class="form-control form-control-sm" type="text">
                                </div>
                                @error('marketable_number')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تعداد فروخته شده</label>
                                    <input name="sold_number" value="{{old('sold_number', $product->sold_number)}}" class="form-control form-control-sm" type="text">
                                </div>
                                @error('sold_number')
                                    <span class="alert_required bg-danger text-white p-1 rounded" role="alert">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </section>
                            <section class="col-12 col-md-6">
                                <div class="form-group">
                                    <label for="">تعداد رزرو شده</label>
                                    <input name="frozen_number" value="{{old('frozen_number', $product->frozen_number)}}"  class="form-control form-control-sm" type="text">
                                </div>
                                 @error('frozen_number')
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