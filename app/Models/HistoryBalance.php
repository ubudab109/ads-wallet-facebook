<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoryBalance extends Model
{
    use HasFactory;

    protected $table = 'history_balance_control';
    protected $fillable = [
        'user_id',
        'balance_used',
        'desc',
    ];

    protected $appends = [
        'created',
    ];

    public function getCreatedAttribute()
    {
        return date_format($this->created_at, "d/m/Y");
    }
    
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
