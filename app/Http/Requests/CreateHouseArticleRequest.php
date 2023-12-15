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
            'title' => 'required|string|max:255',
            'content' => 'nullable',
            'images' => 'nullable|array',
            'type' => 'required|integer|in: ' . implode(',', array_keys(HouseArticle::$types)),
            'price' => 'required|numeric',
            'area' => 'nullable|numeric',
            'bedrooms' => 'nullable|integer',
            'wcs' => 'nullable|integer',
            'address' => 'nullable',
            'direction_house' => 'nullable',
            'house_number' => 'nullable|integer',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];
    }
}
