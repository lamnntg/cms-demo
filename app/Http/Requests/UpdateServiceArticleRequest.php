<?php

namespace App\Http\Requests;

use App\Models\ServiceArticle;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceArticleRequest extends FormRequest
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
            'title' => 'nullable|string|max:255',
            'content' => 'nullable',
            'images' => 'nullable|array',
            'remove_images' => 'nullable|array',
            'price' => 'nullable|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images.*' => 'nullable|string',
            'hashtags' => 'nullable|array',
            'status' => 'nullable|integer|in: '  . implode(',', array_keys(ServiceArticle::$status))
        ];
    }
}
