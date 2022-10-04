<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;

class PostRequest extends FormRequest
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
    public function rules(Request $request)
    {
        $route = $this->route()->getName();
        
        $rule = [
            'title' => 'required|string|max:20',
            'body' => 'required|string|max:50',
            'category_id' => 'required',
        ];

        if ($route === 'posts.store' || ($route === 'posts.update' && $request->file('image'))){
            $rule['image'] = 'required|image|mimes:jpg,png';
        }
        return $rule;
    }
    
    public function attributes()
    {
        return [
            'title'=>'作品名',
            'body'=>'概要',
            'image'=>'写真',
            'category_id'=>'金額',
            'image_path'=>'作品',
        ];
    }
}
