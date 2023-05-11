<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $mergeToken = ['api/login', 'api/signup', 'api/activate'];

        $data = [
            'id'               => $this->id,
            'name'             => $this->name,
            'email'            => $this->email,
            'token'           => $this->when(in_array(\Request::path(), $mergeToken), function () {
                return $this->token;
            })
        ];

        return $data;
    }
}
