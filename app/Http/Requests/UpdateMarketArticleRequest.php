<?php

namespace App\Http\Requests;

use App\Models\MarketArticle;
use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketArticleRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'images' => 'nullable|array',
            'price' => 'required|numeric',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hashtags' => 'nullable|array',
            'status' => 'nullable|integer|in: '  . implode(',', array_keys(MarketArticle::$status))
        ];
    }
}
