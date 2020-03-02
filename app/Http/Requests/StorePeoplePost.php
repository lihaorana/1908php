<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeoplePost extends FormRequest
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
            'username'=>'required|unique:people|max:12|min:2',
               'age' =>'required|integer:|max:3|min:1',
        ];
    }
    public function messages()
    {
        return [
            'username.required'=>'名称必填',
                'username.unique'=>'名称已存在',
                'username.max'=>'名称最大是12位',
                'username.min'=>'名称最小是2位',
                'age.required'=>'年龄必填',
                'age.integer'=>'年龄数据必须是数值',
                'age.max'=>'年龄数据不合法,太大啦呦！',
                'age.min'=>'年龄最小是1岁',
        ];
    }
}
