<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiuserRequest extends FormRequest
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
            'username'=>'required',
            'password'=>'required',
            'token'=>'required'
        ];
    }
    //失败消息
    public function messages()
    {
        return [
            'token.required'=>'接口token不能为空'
        ];
    }

}
