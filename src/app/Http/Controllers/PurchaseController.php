<?php

namespace App\Http\Controllers;

use App\Models\Product;   // 商品モデル
use App\Models\Profile;   // プロフィール（住所用）
use Illuminate\Support\Facades\Auth; // ログインユーザー情報取得用
use App\Http\Requests\Orders\AddressRequest;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function purchase(Product $product)
    {
        // セッション住所があればそれを優先、なければプロフィール住所
        $address = session('purchase_address') ?? auth()->user()->profile;

        return view('orders.order', [
            'product' => $product,
            'address' => $address,
        ]);
    }

    // 住所変更画面を表示
    public function address(Product $product)
    {
        $profile = Auth::user()->profile;

        return view('orders.address', [
            'product' => $product,
            'profile' => $profile,
        ]);
    }

    public function updateAddress(AddressRequest $request, Product $product)
    {
        $data = $request->only(['postcode', 'address', 'building']);

        // 一時保存（プロフィールには保存しない）
        session(['purchase_address' => $data]);

        return redirect("/purchase/{$product->id}");
    }

}
