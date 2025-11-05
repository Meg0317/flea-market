<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Condition;
use App\Http\Requests\exhibitions\ExhibitionRequest;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function index(Request $request)
    {
        $tab = $request->query('tab', 'recommend');
        $userId = auth()->id();

        // ========== 「マイリスト」タブ ==========
        if ($tab === 'mylist') {
            if (auth()->check()) {
                // ログイン中 → 自分がいいねした商品だけ取得
                $products = Product::whereHas('favoredBy', function ($query) use ($userId) {
                        $query->where('user_id', $userId);
                    })
                    ->where(function ($query) use ($userId) {
                        $query->where('user_id', '!=', $userId)
                            ->orWhereNull('user_id');
                    })
                    ->with('order')
                    ->get();
            } else {
                // 未ログイン → 空
                $products = collect(); // ← ここ重要（空のコレクションを渡す）
            }
        }

        // ========== 「おすすめ」タブ（全商品） ==========
        else {
            $products = Product::query()
                ->when($userId, function ($query, $userId) {
                    $query->where('user_id', '!=', $userId)
                        ->orWhereNull('user_id');
                })
                ->with('order')
                ->get();
        }

        return view('products.product', compact('products', 'tab'));
    }

    public function search(Request $request) {
        $products = Product::KeywordSearch($request->input('keyword'))->get();
        $tab = $request->query('tab', 'recommend');
        return view('products.product', compact('products', 'tab'));
    }

    public function show(Product $product)
    {
        $product->load([
            'categories',
            'condition',
            'comments.user.profile',
        ]);

        $product->loadCount('favoredBy', 'comments');

        // ログイン中ユーザーがこの商品を既にお気に入りしているかどうか
        $isFavorited = auth()->check() && $product->favoredBy->contains(auth()->id());

        return view('products.detail', [
            'product' => $product,
            'isFavorited' => $isFavorited,
        ]);
    }

    public function create()
    {
        $product = new Product();
        $categories = Category::all();
        $conditions = Condition::all();
        return view('products.create', compact('categories', 'conditions'));
    }

    public function store(ExhibitionRequest $request)
    {
        $data = $request->only(['name', 'brand', 'condition_id', 'price', 'description']);
        $data['user_id'] = auth()->id();

        $path = $request->file('image')->store('products', 'public');
        $data['image'] = $path;
        //DBに保存
        $product = Product::create($data);

        $product->categories()->sync($request->input('category_ids'));


        return redirect('/');
    }
}

