<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Support\Str;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'balance',
        'status',
        'form_status',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $appends = [
        'form_review_status',
        'status_user',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot(); //
        self::creating(function ($model) {
            $model->uuid = (string) Str::uuid()->toString();
        });
    }

    public function getFormReviewStatusAttribute()
    {
        return FormReviewStatus($this->form_status);
    }

    public function getStatusUserAttribute()
    {
        return UserStatus($this->status);
    }

    public function TopupTransaction()
    {
        return $this->hasMany(TopupTransactionUser::class, 'user_id', 'id');
    }

    public function FormReview()
    {
        return $this->hasOne(FormReview::class, 'user_id', 'id');
    }

    public function HistoryBalanceUser()
    {
        return $this->hasMany(HistoryBalance::class, 'user_id', 'id');
    }

    public function Notification()
    {
        return $this->hasMany(Notification::class, 'user_id', 'id');
    }

    public function VerificationEmail()
    {
        return $this->hasMany(UserVerification::class, 'user_id', 'id');
    }

    public function Chat()
    {
        return $this->hasMany(Chat::class, 'user_id', 'id');
    }

    public function FirstChat()
    {
        return $this->hasOne(Chat::class, 'user_id', 'id');
    }

    public function FromChat()
    {
        return $this->hasMany(Chat::class, 'to_user_id', 'id');
    }

    public function Refund()
    {
        return $this->hasMany(RefundUsers::class, 'user_id', 'id');
    }

    public function UserBank()
    {
        return $this->hasMany(UserBank::class, 'user_id', 'id');
    }

    public function Ticket()
    {
        return $this->hasMany(OpenTicket::class, 'user_id', 'id');
    }
}
