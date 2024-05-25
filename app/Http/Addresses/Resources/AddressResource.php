<?php

namespace SAAS\Http\Addresses\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use SAAS\Http\Countries\Resources\CountryResource;
use SAAS\Http\Users\Resources\PrivateUserResource;

class AddressResource extends JsonResource
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
            'name' => $this->name,
            'address_1' => $this->address_1,
            'address_2' => $this->address_2,
            'state' => $this->state,
            'city' => $this->city,
            'postal_code' => $this->postal_code,
            'default' => (bool) $this->default,
            'country' => new CountryResource($this->country),
            'user' => new PrivateUserResource($this->whenLoaded('user')),
        ];
    }
}
