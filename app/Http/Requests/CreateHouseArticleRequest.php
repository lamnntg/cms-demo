<?php

namespace App\Http\Requests;

use App\Models\HouseArticle;
use Illuminate\Foundation\Http\FormRequest;

class CreateHouseArticleRequest extends FormRequest
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
            'user_id' => 'required|integer|exists:firebase_users,id',
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'images' => 'nullable|array',
            'type' => 'required|integer|in: ' . implode(',', array_keys(HouseArticle::$types)),
            'price' => 'required|numeric',
            'area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'wcs' => 'nullable|integer',
            'livingrooms' => 'nullable|integer',
            'address' => 'nullable',
            'direction_house' => 'nullable',
            'house_number' => 'nullable|integer',
            'kind' => 'required|integer|in: ' . implode(',', array_keys(HouseArticle::$kinds)),
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
