<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormReview extends Model
{
    use HasFactory;

    protected $table = 'form_review';
    protected $fillable = [
        'user_id',
        'applicants_name',
        'account_type',
        'account_information',
        'address',
        'company_email',
        'time_zone',
        'ads_type',
        'cost_spending',
        'company_website',
        'account_ads_name',
        'facebook_home_url',
        'facebook_app_id',
        'url_ads',
        'status',
    ];
    protected $appends = ['email_user','type_account','status_badge','spending'];

    

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function getSpendingAttribute()
    {
        return CostSpend($this->cost_spending);
    }

    public function getStatusBadgeAttribute() 
    {
        if ($this->status == FORM_REVIEW_PENDING) {
            $status = 'Need To Review';
        } else if ($this->status == FORM_REVIEW_ACCEPTED) {
            $status = 'Approved';
        } else if ($this->status == FORM_REVIEW_REJECTED) {
            $status = 'Rejected';
        } else if ($this->status == FORM_REVIEW_WAITING_LIST) {
            $status = 'Waiting List';
        }

        return $status;
    }

    public function getTypeAccountAttribute()
    {
        return AccountType($this->account_type);
    }

    public function getEmailUserAttribute()
    {
        return $this->User->email;
    }
}
