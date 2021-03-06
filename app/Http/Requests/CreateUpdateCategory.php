<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateUpdateCategory extends FormRequest
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
            'title'         =>  "required|min:3|unique:categories,title,{$this->id},id",
            'url'           =>  "required|min:3|unique:categories,url,{$this->id},id",
            'image'         =>  "required|min:3|unique:categories,image,{$this->id},id",
            'description'   =>  "max:2000"
        ];
    }
}
