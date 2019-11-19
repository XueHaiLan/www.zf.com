<?php

namespace App\Http\Requests;
use Validator;
use Illuminate\Foundation\Http\FormRequest;

class FangAttrRequest extends FormRequest
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

    //自定义验证规则
    public function fieldName()
    {
        Validator::extend('fieldname', function ($attribute, $value, $parameters, $validator) {
            $pid=request()->get('pid')==0 ? false : true;
            $reg='/\w+/';
            return $pid || preg_match($reg,$value);
        });
    }

    public function messages()
    {
        return [
            'field_name.fieldname'=>'选择顶级属性一定要填写对应的字段'
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $this->fieldName();
        return [
            'name'=>'required',
            'field_name'=>'fieldname'
        ];
    }
}
