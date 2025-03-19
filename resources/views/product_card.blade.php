@extends('master')
@php use Illuminate\Support\Facades\Vite; @endphp

@section('content')

    <div class="product_card-Container">
        <div class="product-card">
            <div class="product_card-Image">
                <img id="mainImage" src="{{ Vite::asset('resources/img/catalog/' . $products[0]->product_img) }}" alt="{{ $products[0]->product_name }}">
            </div>
            <div class="thumbnail-container">
                <img class="thumbnail" src="{{ Vite::asset('resources/img/catalog/' . $product->product_img) }}" alt="{{ $product->product_name }}" onclick="changeImage('{{ Vite::asset('resources/img/catalog/' . $product->product_img) }}')">

            </div>
        </div>

    </div>


@endsection
