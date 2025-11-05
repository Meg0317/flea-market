@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/orders/order.css') }}">
@endsection

@section('content')
<div class="order-form__group">

    {{-- ============================
        上ブロック：商品情報
    ============================= --}}
    <div class="order-form__block order-form__product-area">

        {{-- 左ブロック：商品画像・情報 --}}
        <div class="order-form__left">
            <div class="order-form__card-area">
                <img class="card-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
                <hr class="product-divider">

                <div class="order-form__name-input">
                    <p class="product-list">{{ $product->name }}</p>
                    <p class="price-list">¥{{ number_format($product->price) }}</p>
                </div>
            </div>
        </div>

        {{-- 右ブロック：確認テーブル --}}
        <div class="order-form__right">
            <div class="order-form__confirm-area">
                <table class="order-table">
                    <tr>
                        <th>商品代金</th>
                        <td>¥{{ number_format($product->price) }}</td>
                    </tr>
                    <tr>
                        <th>支払方法</th>
                        <td>
                            @php
                                // ① request に値があるならそれを優先
                                // ② なければ session に保存された値
                                // ③ それもなければ DB の order.payment_method
                                $pay = request('payment') ?? session('payment_method') ?? ($order->payment_method ?? null);
                            @endphp

                            @if ($pay == 1)
                                コンビニ払い
                            @elseif ($pay == 2)
                                カード支払い
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    {{-- ============================
        中ブロック：支払い方法
    ============================= --}}
    <div class="order-form__block order-form__payment-area">
        <form action="/purchase/{{ $product->id }}" method="post">
            @csrf

            {{-- 左ブロック：支払い方法選択 --}}
            <div class="order-form__left order-form__payment-left">
                <label for="payment_method" class="payment-label">支払方法</label>
                <div class="order-form__select-inner">
                    <select id="payment_method" name="payment_method" class="order-form__select" {{ $isPurchased ? 'disabled' : '' }}>
                        <option value="" {{ empty($payment) ? 'selected' : '' }}>選択してください</option>
                        <option value="1" {{ $payment == 1 ? 'selected' : '' }}>コンビニ払い</option>
                        <option value="2" {{ $payment == 2 ? 'selected' : '' }}>カード支払い</option>
                    </select>
                </div>
                @error('payment_method')
                    <p class="order-form__error-message">{{ $message }}</p>
                @enderror
                <hr class="payment-divider">
            </div>

            {{-- 右ブロック：購入ボタン --}}
            <div class="order-form__right order-form__btn-inner">
                @if (!$isPurchased)
                    <button type="submit" class="order-form__send-btn">購入する</button>
                @else
                    <p class="already-purchased__msg" style="color: gray;">
                        ※この商品はすでに購入されています。
                    </p>
                @endif
            </div>
        </form>
    </div>


    {{-- ============================
        下ブロック：配送先情報
    ============================= --}}
    <div class="order-form__block order-form__address-area">

        {{-- 左ブロック：配送先情報 --}}
        <div class="order-form__left">
            <div class="address-header">
                <p class="address-label">配送先</p>
                @if (!$isPurchased)
                    <a href="/purchase/address/{{ $product->id }}" class="address-change__send">変更する</a>
                @endif
            </div>

            <div class="address-list">
                @if ($address)
                    <span>{{ $address->postcode }}</span>
                    <span>{{ $address->address }}</span>
                    <span>{{ $address->building }}</span>
                @endif
            </div>


            <hr class="address-divider">
        </div>

        {{-- 下ブロックに右ブロックはなし --}}
        <div class="order-form__right"></div>
    </div>
</div>

@endsection