<?php

namespace Modules\Proposals\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class ProposalResource extends JsonResource {

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request
     * @return array
     */
    public function toArray($request) {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => date('Y-m-d H:i:s', strtotime($this->created_at)),
            'cities' => [
                'name' => $this->city_name,
                'id' => $this->city_id
            ],
            'counties' => [
                'name' =>$this->county_name,
                'id' => $this->county_id
            ],
            'users' => [
                'name' => $this->user_name,
            ],
            'competitionItem' =>  [
                'name' => $this->name,
                'distance' => $this->distance
            ]

        ];
    }
}
