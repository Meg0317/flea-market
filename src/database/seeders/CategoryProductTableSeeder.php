<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;

class CategoryProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '腕時計' => ['ファッション', 'メンズ'],
            'HDD' => ['家電'],
            '玉ねぎ3束' => ['キッチン'],
            '革靴' => ['ファッション', 'メンズ'],
            'ノートPC' => ['家電'],
            'マイク' => ['家電'],
            'ショルダーバッグ' => ['ファッション', 'レディース'],
            'タンブラー' => ['キッチン'],
            'コーヒーミル' => ['キッチン'],
            'メイクセット' => ['レディース', 'コスメ'],
        ];

        foreach ($data as $productName => $categories) {
            $product = Product::where('name', $productName)->first();
            $categoryIds = Category::whereIn('category_name', $categories)->pluck('id');

            if ($product) {
                $product->categories()->attach($categoryIds);
            }
        }
    }
}
