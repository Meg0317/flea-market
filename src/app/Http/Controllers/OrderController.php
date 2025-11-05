<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Orders\purchaseRequest;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(PurchaseRequest $request, Product $product)
    {

        $user = Auth::user();
        session(['payment_method' => $request->payment_method]);

        // セッションに保存された購入住所を優先、なければプロフィール住所を使用
        $address = session('purchase_address') ?? $user->profile;

        Order::create([
            'user_id'           => $user->id,
            'product_id'        => $product->id,
            'payment_method'    => $request->payment_method,
            'sending_postcode'  => is_array($address) ? $address['postcode'] : $address->postcode,
            'sending_address'   => is_array($address) ? $address['address']  : $address->address,
            'sending_building'  => is_array($address) ? $address['building'] : $address->building,
        ]);

        // 一時住所を削除（DB保存には影響しない）
        session()->forget('purchase_address');

        // ホーム画面へリダイレクト
        return redirect('/');
    }

    public function create(Product $product)
    {
        $user = auth()->user();

        // 商品が購入済みか判定
        $order = $product->order;
        $isPurchased = !is_null($order);

        // 購入時に使う住所（セッションにあれば優先）
        $address = session('purchase_address') ?? $user->profile;

        // ✅ 支払方法の取得（購入済みならDB、未購入ならセッション）
        $payment = $isPurchased
            ? $order->payment_method
            : session('payment_method');

        return view('orders.order', compact('product', 'address', 'isPurchased', 'payment', 'order'));
    }

    public function address()
    {
        $profile = Auth::user()->profile; // ログイン中ユーザーの住所を取得
        return view('orders.address', compact('profile'));
    }
}