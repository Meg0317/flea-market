@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/products/create.css') }}">
@endsection

@section('content')

<div class="exhibit-form__content">
    <div class="exhibit-form__heading">
        <h2>商品の出品</h2>
    </div>
    <div class="exhibit-form__inner">
        <form class="exhibit-form__form" action="/sell" method="post" enctype="multipart/form-data" >
            @csrf
            <div class="exhibit-form__group">
                <label class="exhibit-form__label">
                    商品画像
                </label>
                <div class="image-upload-box">
                    <input class="image-upload-input" type="file" name="image" id="image" accept="image/*">
                    <label for="image" class="image-upload-label">画像を選択する</label>
                </div>
                <p class="exhibit-form__error-message">
                    @error('image')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="exhibit-form__group">
                <h3>商品の詳細</h3>
                <hr class="detail-line" />
            </div>

            <div class="exhibit-form__group">
                <label class="exhibit-form__label">
                    カテゴリー
                </label>
                <div class="category-list">
                    @foreach($categories as $category)
                        <label class="category-item">
                            <input
                                type="checkbox"
                                name="category_ids[]"
                                value="{{ $category->id }}"
                                {{ in_array($category->id, old('category_ids', [])) ? 'checked' : '' }}
                            >
                            <span>{{ $category->category_name }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="exhibit-form__error-message">
                    @error('category_id')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="exhibit-form__group">
                <label class="exhibit-form__label">
                    商品の状態
                </label>
                <div class="exhibit-form__select-inner">
                    <select class="exhibit-form__select" name="condition_id" id="">
                        <option value="">選択してください</option>
                        @foreach ($conditions as $condition)
                        <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                            {{ $condition->condition_name }}
                        </option>
                        @endforeach
                    </select>
                </div>
                <p class="exhibit-form__error-message">
                    @error('condition_id')
                        {{ $message }}
                    @enderror
                </p>
            </div>

            <div class="exhibit-form__group">
                <h3>商品名と説明</h3>
                <hr class="explanation-line" />
            </div>

            <div class="form__group">
                <label class="exhibit-form__label">
                    商品名
                </label>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="name" value="{{ old('name') }}" />
                    </div>
                    <div class="exhibit-form__error-message">
                        @error('name')
                            {{ $message }}
                        @enderror
                    </div>
                </div>
            </div>

            <div class="form__group">
                <label class="exhibit-form__label">
                    ブランド名
                </label>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="brand" value="{{ old('brand') }}" />
                    </div>
                </div>
            </div>

            <div class="form__group">
                <label class="exhibit-form__label">
                    商品の説明
                </label>
                <div class="form__group-content">
                    <div class="form__input--textarea">
                        <textarea name="description">{{ old('description') }}</textarea>
                    </div>
                </div>
                <div class="exhibit-form__error-message">
                    @error('description')
                        {{ $message }}
                    @enderror
                </div>
            </div>

            <div class="form__group">
                <label class="exhibit-form__label">
                    販売価格
                </label>
                <div class="form__group-content">
                    <div class="price-input-wrap">
                        <span class="price-symbol">¥</span>
                        <input type="text" name="price" value="{{ old('price') }}">
                    </div>
                </div>
            </div>
            <div class="exhibit-form__error-message">
                @error('price')
                    {{ $message }}
                @enderror
            </div>

            <div class="form__button">
                <button class="form__button-submit" type="submit">出品する</button>
            </div>
        </form>
    </div>
</div>

@endsection
