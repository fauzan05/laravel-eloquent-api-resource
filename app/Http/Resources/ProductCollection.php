<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public $additional = [
        "author" => "Fauzan Nur Hidayat"
    ];
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "data" => ProductResource::collection($this->collection),
        ];
    }

    public function withResponse(Request $request, \Illuminate\Http\JsonResponse $response):void
    {
        $response->header("haha","satu,dua,tiga");
    }
}
