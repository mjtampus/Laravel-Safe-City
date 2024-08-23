<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ReportSubmitted extends Notification
{
    use Queueable;
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function toDatabase($notifiable)
    {
        return [
        'type' => 'report',
        'content' => 'Your accident report has been submitted successfully.',
        'action_url' => url('/dashboard/report/' . $this->data['report_id']),
        'report_id' => $this->data['report_id'], // Make sure to include the report_id
        ];
    }

    // Add the 'via' method
    public function via($notifiable)
    {
        return ['database'];
    }
}

