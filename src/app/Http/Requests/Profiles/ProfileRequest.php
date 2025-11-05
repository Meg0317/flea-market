<?php

namespace App\Http\Requests\Profiles;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'image' => ['nullable', 'image', 'mimes:jpg,png'],
            'name' => ['required', 'max:20'],
            'postcode' => ['required', 'regex:/^\d{3}-\d{4}$/'],
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.mimes' => '拡張子が.jpegもしくは.pngにしてください',
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => 'ユーザー名を20文字以下で入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号をハイフンありの8桁で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
