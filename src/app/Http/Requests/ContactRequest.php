<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContactRequest extends FormRequest
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
            /*'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'gender' => ['required',],
            'email' => ['required', 'string', 'email', 'max:255'],
            'postcode' => ['required', 'string', 'regex:/^\d{3}-\d{4}$/'],
            'address' => ['required', 'string', 'max:255'],
            'building_name' => ['nullable', 'max:255'],
            'opinion' => ['required', 'string', 'max:255'],
        */];
    }

    public function messages()
    {
        return [
            /*'first_name.required' => '名字を入力してください',
            'first_name.string' => '名字は文字列で入力してください',
            'last_name.required' => '名前を入力してください',
            'last_name.string' => '名前は文字列で入力してください',
            'email.required' => 'メールアドレスを入力してください',
            'email.email' => '有効なメールアドレス形式を入力してください',
            'postcode.required' => '郵便番号を入力してください',
            'postcode.regex' => '郵便番号は数字とハイフンの8桁で入力してください',
            'address.required' => '住所を入力してください',
            'address.string' => '住所は文字列で入力してください',
            'opinion.required' => 'お問い合わせ内容を入力してください',
            'max' => [
                'string' => ':attributeは:max文字以内でご入力ください',],
          */
        ];
    }
}
