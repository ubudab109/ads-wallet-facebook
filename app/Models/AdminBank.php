<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminBank extends Model
{
    use HasFactory;

    protected $table = 'admin_bank';
    protected $fillable = [
        'bank_name',
        'bank_number',
        'account_holder_bank',
    ];

    public function TopupUser()
    {
        return $this->hasMany(TopupTransactionUser::class, 'admin_bank_id', 'id');
    }
}
