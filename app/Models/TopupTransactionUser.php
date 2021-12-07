<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;;
use Illuminate\Support\Str;

class TopupTransactionUser extends Model
{
    use HasFactory;

    protected $table = 'topup_transaction_user';
    protected $fillable = [
        'transaction_id',
        'admin_bank_id',
        'user_id',
        'amount_topup',
        'total_topup',
        'dollar_amount',
        'status',
        'approved_date',
        'bank_sleep',
    ];

    protected $appends = ['status_badge','image'];

    protected static function boot()
    {
        parent::boot(); //
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid()->toString();
        });
    }

    public function getImageAttribute()
    {
        return asset('user-topup/'.$this->bank_sleep);
    }
    
    public function getStatusBadgeAttribute() 
    {
        if ($this->status == TOPUP_PENDING) {
            $status = 'Pending';
        } else if ($this->status == TOPUP_APPROVED) {
            $status = 'Approved';
        } else if ($this->status == TOPUP_REJECTED) {
            $status = 'Rejected';
        }

        return $status;
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function AdminBank()
    {
        return $this->belongsTo(AdminBank::class, 'admin_bank_id', 'id');
    }
}
