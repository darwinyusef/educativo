<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class UserCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => $this->collection,
            'countData' => [
                'count' => $this->count(),
                'currentPage' => $this->currentPage(),
                'lastPage' => $this->lastPage(),
                'firstItem' => $this->firstItem(),
                'lastItem' => $this->lastItem(),
                'getOptions' => $this->getOptions(),
                'hasPages' => $this->hasPages(),
                'hasMorePages' => $this->hasMorePages(),
                'getPageName' => $this->getPageName(),

            ],
            'links' => [
                'previousPageUrl' => $this->previousPageUrl(),
                'nextPageUrl' => $this->nextPageUrl(),
                'onFirstPage' => $this->onFirstPage(),
                'perPage' => $this->perPage(),
                'total' => $this->total(),
                'getUrlRange' => $this->getUrlRange( 1, $this->lastPage()),
            ],
        ];
    }
}
