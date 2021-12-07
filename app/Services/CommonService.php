<?php

namespace App\Services;

use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Pusher\Pusher;

class CommonService
{
    public function sendNotifictionToUser($userId, $title, $messages) 
    {
        Log::info('Notification Sending....');
        try {
            Notification::create([
                'user_id'   => $userId,
                'title'     => $title,
                'messages'  => $messages,
            ]);
            $channel = 'usernotification_'.$userId;
            $data['success']    = true;
            $data['user_id']    = $userId;
            $data['title']      = $title;
            $data['messages']   = $messages;
            $config = config('broadcasting.connections.pusher');
            $pusher = new Pusher($config['key'], $config['secret'], $config['app_id'], $config['options']);
            $pusher->trigger($channel, 'receive_notification', $data);
        } catch (\Exception $err) {
            Log::info('send notification exception');
            Log::info($err->getMessage());
        }
    }
}