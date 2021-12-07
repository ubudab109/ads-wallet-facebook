<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserBank extends Model
{
    use HasFactory;

    protected $table = 'bank_user';
    protected $fillable = [
        'user_id',
        'bank_name',
        'bank_number',
        'account_holder_bank',
    ];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function RefundUser()
    {
        return $this->hasMany(RefundUsers::class, 'bank_user_id','id');
    }
}
