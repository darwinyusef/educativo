<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'uuid' => $this->uuid,
            'name' => $this->name,
            'lastname' => $this->lastname,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'displayName' => $this->displayName,
            'slug' => $this->slug,
            'nicname' => $this->nicname,
            'about' => $this->about,
            'town' => $this->town,
            'especialParam' => $this->especialParam,
            'html' => $this->html,
            'language' => $this->language,
            'status' => $this->status
        ];
    }
}
