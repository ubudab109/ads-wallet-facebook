<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $table = 'chat';

    protected $fillable = [
        'user_id',
        'to_user_id',
        'messages',
        'image',
        'read_at',
    ];

    protected $appends = ['chat_time'];

    public function getChatTimeAttribute()
    {
        return date_format($this->created_at, "H:i:s");
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userFrom()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function userTo()
    {
        return $this->belongsTo(User::class, 'to_user_id', 'id');
    }
}
