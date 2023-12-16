<?php

namespace App\Http\Resources;

use App\Models\FirebaseUser;
use Illuminate\Http\Resources\Json\JsonResource;

class FirebaseUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request = null)
    {
        $data = $this->resource;

        return [
            'id' => $data->id,
            'uid' => $data->uid,
            'email' => $data->email,
            'display_name' => $data->display_name,
            'photo_url' => $data->photo_url,
            'phone_number' => $data->phone_number,
            'role' => $data->role ?? FirebaseUser::ROLE_USER
        ];
    }
}
