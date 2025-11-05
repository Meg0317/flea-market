<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\CommentController;

// 未ログインでもOKなルート
Route::get('/', [ProductController::class, 'index']); // ホーム＝商品一覧
Route::get('/item/search', [ProductController::class, 'search']);
Route::get('/item/{item_id}', [ProductController::class, 'show']);

// メール認証関連ルート
Route::get('/email/verify', function () {
    return view('auth.verify-email');
})->middleware('auth')->name('verification.notice');

// メール内リンククリック時（認証完了処理）
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill(); // email_verified_at に日時を記録
    return redirect('/profile/create'); // 認証後にプロフィール登録画面へ
})->middleware(['auth', 'signed'])->name('verification.verify');

// 認証メール再送信
Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();
    return back()->with('message', '認証メールを再送しました。');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send'); // ← 1分間に6回まで再送可能


// ログイン必須ルート
Route::middleware(['auth'])->group(function () {
     // メール認証済みユーザーのみ許可
    Route::middleware(['verified'])->group(function () {
        Route::get('/profile/create', [ProfileController::class, 'create']);
        Route::post('/profile', [ProfileController::class, 'store']);
    });
    Route::get('/profile/create', [ProfileController::class, 'create']);
    Route::post('profile', [ProfileController::class, 'store']);
    Route::get('/purchase/{item_id}', [PurchaseController::class, 'purchase']);
    Route::post('/purchase/{item_id}', [PurchaseController::class, 'purchase']);
    Route::get('/purchase/address/{item_id}', [PurchaseController::class, 'address']);
    Route::post('/purchase/address/{item_id}', [PurchaseController::class, 'updateAddress']);
    Route::post('/item/{item_id}/favorite', [FavoriteController::class, 'store']);
    Route::delete('/item/{item_id}/favorite', [FavoriteController::class, 'destroy']);
    Route::post('item/{item_id}/comment', [CommentController::class, 'store']);
    Route::get('orders/address', [OrderController::class, 'address']);
    Route::post('/purchase/{item_id}', [OrderController::class, 'store']);
    Route::get('/purchase/{item_id}', [OrderController::class, 'create']);
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::patch('/mypage/profile', [ProfileController::class, 'update']);
    Route::get('/sell', [ProductController::class, 'create']);
    Route::post('/sell', [ProductController::class, 'store']);
});
