<?php

namespace App\Http\Requests\exhibitions;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'description' => ['required', 'max:255'],
            'image' => ['required', 'mimes:jpg,png'],
            'category_ids' => 'required',
            'condition_id' => 'required',
            'price' => ['required', 'integer', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名を入力してください',
            'description.required' => '商品説明を入力してください',
            'description.max' => '255文字以内で入力してください',
            'image.required' => '商品画像を登録してください',
            'image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'category_ids.required' => 'カテゴリーを選択してください',
            'condition_id.required' =>'コンデイションを選択してください',
            'price.required' => '金額を入力してください',
            'price.integer' => '数値で入力してください',
            'price.min' => '0円以上の金額を入力してください',
        ];
    }
}
