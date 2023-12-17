<?php

namespace App\Http\Requests;

use App\Models\HouseArticle;
use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseArticleRequest extends FormRequest
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
            'type' => 'nullable|integer|in: ' . implode(',', array_keys(HouseArticle::$types)),
            'price' => 'nullable|numeric',
            'area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'wcs' => 'nullable|integer',
            'address' => 'nullable',
            'direction_house' => 'nullable',
            'house_number' => 'nullable|integer',
            'images.*' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'hashtags' => 'nullable|array',
            'status' => 'nullable|integer|in: '  . implode(',', array_keys(HouseArticle::$status))
        ];
    }
}
