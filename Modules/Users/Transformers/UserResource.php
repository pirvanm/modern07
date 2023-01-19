<?php

namespace Modules\Users\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource {

    public function toArray($request)
    {
        return [
          'id' => $this->id,
          'name' => $this->name,
          'email' => $this->email,
          'roles' => [
              'display_name' => $this->roles_display_name,
              'id' => $this->roles_id,
          ] ,
          'created_at' => $this->created_at,
        ];
    }

}
