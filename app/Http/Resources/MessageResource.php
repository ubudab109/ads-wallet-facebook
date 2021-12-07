<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class MessageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $count = Chat::where([
            ['user_id', $this->user_id],
            ['to_user_id', $this->to_user_id],
        ])->whereNull('read_at')->count();


        return [
            'id' => $this->users->id,
            'name' => $this->users->name,
            'from_id' => $this->user_id,
            'to_user_id' => $this->to_user_id,
            'messages' => $this->messages != '' || $this->messages != null ? $this->messages : '',
            'image' => $this->image != null ? $this->image : null,
            'created_at' => $this->created_at,
            'count' => $count
        ];
    }
}
