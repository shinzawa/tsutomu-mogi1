<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitRequest extends FormRequest
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
            'image' => 'required | mimes:png,jpeg',
            'name' =>  'required',
            'description' => 'required | max:255',
            'categories' => 'required',
            'condition' => 'required',
            'price'  => 'required | min:0 | numeric',
        ];
    }
        public function messages()
    {
        return [
            'image.required' => '画像を入力してください',
            'image.mpeg' => '画像は.jpegか.png形式で入力してください',
            'name.required' => '商品名を入力してください',
            'description.required' => '商品詳細を入力してください',
            'description.max' => '商品詳細は255文字以内で入力してください',
            'categories.required' => '商品カテゴリを選択してください',
            'condition.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
            'price.min' => '商品価格は0円以上で入力してください',
            'price.numeric' => '商品価格は数値型で入力してください', 
        ];
    }
}
