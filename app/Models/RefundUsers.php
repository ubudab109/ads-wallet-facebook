<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundUsers extends Model
{
    use HasFactory;

    protected $table = 'refund_user';

    protected $fillable = [
        'transaction_id',
        'user_id',
        'bank_user_id',
        'total_refund',
        'dollar_refund',
        'status',
        'bank_sleep_admin',
    ];

    protected $appends = ['status_badge','image'];

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function BankUser()
    {
        return $this->belongsTo(UserBank::class, 'bank_user_id','id');
    }

    public function getImageAttribute()
    {
        if ($this->bank_sleep_admin != null) {
            return asset('user-refund/'.$this->bank_sleep_admin);
        }

        return null;
    }
    
    public function getStatusBadgeAttribute() 
    {
        if ($this->status == REFUND_USER_PENDING) {
            $status = 'Pending';
        } else if ($this->status == REFUND_USER_APPROVED) {
            $status = 'Approved';
        } else if ($this->status == REFUND_USER_REJECTED) {
            $status = 'Rejected';
        }

        return $status;
    }
}
