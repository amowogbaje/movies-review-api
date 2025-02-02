<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\User;

class NewUserRegisteredNotification extends Notification
{
    use Queueable;

    protected $user; 

    public function __construct(User $user)
    {
        $this->user = $user; 
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('New User Registration')
            ->line('A new user has registered:')
            ->line('Name: ' . $this->user->name)
            ->line('Email: ' . $this->user->email);
            // ->action('Approve User', url("api/v1/admin/users/{$this->user->id}/approve"));
    }
}
