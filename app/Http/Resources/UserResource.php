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
            'cardId' => $this->cardId,
            'fullName' => $this->cardId.' '.$this->name.' '.$this->lastname,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'displayName' => $this->displayName,
            'slug' => $this->slug,
            'nickname' => $this->nickname,
            'about' => $this->about,
            'town' => $this->town,
            'especialParam' => $this->especialParam,
            'html' => $this->html,
            'language' => $this->language,
            'status' => $this->status,
            'permission' =>  $this->getPermissionsViaRoles()
        ];

    }
}
