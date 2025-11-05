
@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profiles/create.css') }}">
@endsection

@section('content')
<div class="create-form__content">
    <div class="create-form__heading">
        <h2>プロフィール設定</h2>
    </div>
    <div class="create-form__inner">
        <form action="/profile" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form__group">
                <div class="form__group-image">
                    @if(isset($profile->image))
                        <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像" class="profile-image">
                    @else
                        <div class="profile-image--default"></div>
                    @endif

                    <label for="image" class="image-upload-label">画像を選択する</label>
                    <input id="image" class="image-upload-input" type="file" name="image" accept="image/*">
                </div>
                <div class="form__group-title">
                    <span class="form__label--item">ユーザー名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="name" value="{{ old('name') }}" />
                    </div>
                    <p class="create-form__error-message">
                    @error('name')
                    {{ $message }}
                    @enderror
                    </p>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">郵便番号</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="postcode" name="postcode" value="{{ old('postcode') }}" />
                    </div>
                    <p class="create-form__error-message">
                    @error('postcode')
                    {{ $message }}
                    @enderror
                    </p>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">住所</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input type="text" name="address" value="{{ old('address') }}" />
                    </div>
                    <p class="create-form__error-message">
                    @error('address')
                    {{ $message }}
                    @enderror
                    </p>
                </div>
            </div>
            <div class="form__group">
                <div class="form__group-title">
                    <span class="form__label--item">建物名</span>
                </div>
                <div class="form__group-content">
                    <div class="form__input--text">
                        <input class="create-form__input" type="text" name="building"  value="{{ old('building') }}" />
                    </div>
                </div>
            </div>
            <div class="form__button">
                <button class="form__button-submit" type="submit">更新する</button>
            </div>
        </form>
    </div>
</div>
@endsection
