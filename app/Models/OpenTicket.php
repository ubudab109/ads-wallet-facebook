<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpenTicket extends Model
{
    use HasFactory;

    protected $table = 'open_ticket';
    protected $fillable = [
        'ticket_id',
        'user_id',
        'title',
        'content',
        'status',
        'priority'
    ];

    protected $appends = ['status_badge','priority_badge'];

    public function getStatusBadgeAttribute()
    {
        if ($this->status == STATUS_TICKET_PENDING) {
            $status = 'Pending';
        } else if ($this->status == STATUS_TICKET_IN_PROGRESS) {
            $status = 'In Progress';
        } else if ($this->status == STATUS_TICKET_FINISHED) {
            $status = 'Finished';
        }

        return $status;
    }

    public function getPriorityBadgeAttribute()
    {
        if ($this->priority == TICKET_PRIORITY_LOW) {
            $priority = 'Low';
        } else if ($this->priority == TICKET_PRIORITY_MEDIUM) {
            $priority = 'Medium';
        } else if ($this->priority == TICKET_PRIORITY_HIGH) {
            $priority = 'High';
        }

        return $priority;
    }

    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
