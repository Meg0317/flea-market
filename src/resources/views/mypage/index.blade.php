@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/mypage/index.css') }}">
@endsection

@section('content')

<div class="mypage-area">
    <div class="profile-area">
        <div class="mypage-menu">
            <div class="user-wrap">
                <img src="{{ $profile->image ?? '/images/default.png' }}"
                    alt=""
                    width="50">
                <span>{{ $profile->user->name }}</span>
            </div>
        </div>
        <div class="profile-menu">
            <a class="profile-change__send" href="/mypage/profile">
                プロフィールを編集
            </a>
        </div>
    </div>
    <div class="product-menu">
        <a href="/mypage?page=sell" class="{{ $page === 'sell' ? 'active' : '' }}">
            出品した商品
        </a>
        <a href="/mypage?page=buy" class="{{ $page === 'buy' ? 'active' : '' }}">
            購入した商品
        </a>
    </div>
    <div class="list-block">
        <div class="product-grid">
            @if ($products->isEmpty())
                <p>商品はありません。</p>
            @else
                @foreach ($products as $product)
                <div class="card">
                    <a href="{{ url('/item/' . $product->id) }}">
                        <img class="card-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                        <p>
                            <span>{{ $product->name }}</span>
                        </p>
                    </a>
                </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection
