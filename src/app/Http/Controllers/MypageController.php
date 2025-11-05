<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Profile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $page = request('page', 'sell');

        if ($page === 'buy') {
            $products = $user->orders()->with('product')->get()->pluck('product')->filter();
        } else {
            $products = $user->products;
        }

        return view('mypage.index', compact('user', 'profile', 'page', 'products' ));
    }
}
