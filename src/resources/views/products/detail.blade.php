@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/detail.css') }}">
@endsection

@section('content')
<div class="detail-area">
    <div class="detail-form__image-area">
        <div class="product-card">
            <div class="card-area">
                <img class="card-image" src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}">
            </div>
        </div>
    </div>
    <div class="detail-form__input-area">
        <div class="detail-form__name-input">
            <p class="product-list">
                <span class="product-name">{{ $product->name }}</span>
                <span class="product-brand">{{ $product->brand ?? "" }}</span>
            </p>
            <span class="price-wrap">
                <span class="yen">¥</span>
                <span class="price">{{ number_format($product->price) }}</span>
                <span class="tax">(税込)</span>
            </span>
        </div>
        <div class="icons">
            @php
                $isFavorited = auth()->check() && auth()->user()->favorites->contains($product->id);
            @endphp

            <div class="icon-item">
                @if($isFavorited)
                    {{-- いいね解除 --}}
                    <form action="/item/{{ $product->id }}/favorite" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="like-button active">
                            <img src="{{ asset('images/star.png') }}" alt="いいね済み">
                        </button>
                    </form>
                @else
                    {{-- いいね追加 --}}
                    <form action="/item/{{ $product->id }}/favorite" method="POST">
                        @csrf
                        <button type="submit" class="like-button">
                            <img src="{{ asset('images/star.png') }}" alt="いいね">
                        </button>
                    </form>
                @endif

                <span class="count">{{ $product->favored_by_count }}</span>
            </div>

            <div class="icon-item">
                <img class="icon-comments" src="{{ asset('images/comment.png') }}" alt="コメント">
                <span class="count">{{ $product->comments_count }}</span>
            </div>
        </div>
        <div class="button-content">
            <a class="detail-form__send-btn" href="/purchase/{{ $product->id }}">
                購入手続きへ
            </a>
        </div>

        <div class="detail-form__description-area">
            <h3 class="description-title">商品説明</h3>
            <p class="description-text">{{ $product->description }}</p>
        </div>

        <div class="detail-form__information-area">
            <h3 class="information-title">商品の情報</h3>

            <dl class="information-list">
                <div class="information-item">
                    <dt class="information-term">カテゴリー</dt>
                    <dd class="information-desc categories">
                        @foreach ($product->categories as $category)
                            <span class="category-label">{{ $category->category_name }}</span>
                        @endforeach
                    </dd>
                </div>

                <div class="information-item">
                    <dt class="information-term">商品の状態</dt>
                    <dd class="information-desc condition">
                        {{ $product->condition->condition_name }}
                    </dd>
                </div>
            </dl>
        </div>

        <div class="detail-form__comments-area">
            <div class="comments-wrap">
                <h3 class="comments-title">コメント</h3>
                <span class="comment-count">({{ $product->comments_count }})</span>
            </div>
            <div class="comments-list">
                @foreach ($product->comments as $comment)
                    <div class="user-wrap">
                        @if ($comment->user->profile && $comment->user->profile->image)
                            <img src="{{ asset('storage/' . $comment->user->profile->image) }}" alt="プロフィール画像">
                        @else
                            <div class="no-image"></div>
                        @endif

                        {{-- ユーザー名（users.name） --}}
                        <span>{{ $comment->user->name }}</span>
                    </div>

                    <div class="comments">
                        {{-- コメント本文 --}}
                        <span>{{ $comment->comment }}</span>
                    </div>
                @endforeach
            </div>
            <div class="comments-input">
                <span class="comment-label">商品へのコメント</span>
                <form action="/item/{{ $product->id }}/comment" method="POST">
                @csrf
                    <textarea class="comments-form__textarea" name="comment" id="" cols="20" rows="7" ></textarea>
                    <div class="comments-form__btn-inner">
                        <button class="detail-form__send-btn" type="submit" name="send" value="送信">
                            コメントを送信する
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection