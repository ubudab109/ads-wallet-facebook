<?php

namespace App\Http\Resources;

use App\Models\Chat;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $to = [
            ['to_user_id', auth()->user()->id],
            ['user_id', $this->id]
        ];
        
        $message = Chat::where([
            ['user_id', auth()->user()->id],
            ['to_user_id', $this->id]
        ])->orWhere($to)->orderBy('created_at','desc')->first();


        $count = Chat::where($to)->whereNull('read_at')->count();
        
        return [
            'id' => $this->id,
            'name' => $this->name,
            'from_id' => $message->user_id ?? '',
            'current_user' => auth()->user()->id,
            'to_user_id' => $message->to_user_id ?? '',
            'messages' => $message->messages ?? '',
            'count' => $count
        ];
    }
}
