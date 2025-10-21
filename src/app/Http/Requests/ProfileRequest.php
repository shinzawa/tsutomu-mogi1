<?php

namespace App\Http\Requests;

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
            'image' => 'required | mpeg:png,jpeg',
            'name' => 'required | max:20',
            'zipcode' => 'required| regex:/^[0-9]+$/',
            'address' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '画像を入力してください',
            'image.mpeg' => '画像は.jpegか.png形式で入力してください',
            'name.required' => 'ユーザー名を入力してください',
            'name.max' => 'ユーザー名は20文字以内で入力してください',
            'zipcode.required' => '郵便番号を入力してください',
            'zipcode.regex' => '郵便番号はxxx-xxxxの形式で入力してください',
            'address.required' => '住所を入力してください', 
        ];
    }
}
