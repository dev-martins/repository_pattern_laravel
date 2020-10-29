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
        if($this->isMethod('post')){
            return [
                'title'         =>  'required|min:3|unique:categories',
                'url'           =>  'required|min:3|unique:categories',
                'description'   =>  'max:2000'
            ];
        }else{
            return [
                'title'         =>  'min:3',
                'url'           =>  'min:3',
                'description'   =>  'max:2000'
            ];
        }
        
    }
}
