<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Comment;
use App\Http\Requests\Products\CommentRequest;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(CommentRequest $request, Product $product)
    {
        $validated = $request->validated();

        $product->comments()->create([
            'comment' => $validated['comment'],
            'user_id' => auth()->id(),
        ]);

        return back();
    }
}
