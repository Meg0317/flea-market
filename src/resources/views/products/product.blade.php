@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/product.css') }}">
@endsection

@section('content')

<div class="product-area">
    <div class="product-menu">
        <a href="/?tab=recommend" class="{{ $tab === 'recommend' ? 'active' : '' }}">
            おすすめ
        </a>
        <a href="/?tab=mylist" class="{{ $tab === 'mylist' ? 'active' : '' }}">
            マイリスト
        </a>

    </div>
    <div class="list-block">
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-item">
                    <a href="{{ url('/item/' . $product->id) }}">
                        <div class="card">
                            <div class="image-wrap">
                                <img class="card-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                                {{-- ★ 売り切れ表示 --}}
                                @if ($product->order)
                                    <span class="sold-badge">SOLD</span>
                                @endif
                            </div>
                        </div>
                        <p class="product-name">{{ $product->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
