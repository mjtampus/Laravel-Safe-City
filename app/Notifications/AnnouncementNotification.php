<?php

namespace App\Notifications;

use App\Models\Announcement;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class AnnouncementNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage([
            'content' => $this->content,
        ]);
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'content' => $this->getMessage(),
            'type' => 'announcement',
        ];
    }

    public function getMessage()
    {
        // Customize your announcement message format here
        return "Announcement: {$this->content}";
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}