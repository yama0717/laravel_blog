<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostImageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'image' => [
              'required',
              'file', // ファイルがアップロードされている
              'image', // 画像ファイルである
              'mimes:jpeg,jpg,png', // 形式はjpegかpng
              'dimensions:min_width=10,min_height=10,max_width=1000,max_height=1000', // 50*50 ~ 1000*1000 まで
            ],
        ];
    }
}
