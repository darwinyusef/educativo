<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MultimediaResource extends JsonResource
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
            'file' => $this->file,
            'url' => $this->url,
            'description' => $this->description,
            'type_file' => $this->type_file,
            'file_location' => $this->file_location,
            'selecction' => $this->selecction,
            'storage' => $this->storage,
            'language' => $this->language,
            'status' => $this->status,
        ];
    }
}
