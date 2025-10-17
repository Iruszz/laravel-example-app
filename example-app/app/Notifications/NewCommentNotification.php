<?php

namespace App\Notifications;

use App\Models\Comment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Log;

class NewCommentNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public Comment $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        Log::info("Sending NewCommentNotification to user {$notifiable->id}");
        
        return (new MailMessage)
            ->subject('New comment on your ticket #' . $this->comment->ticket_id)
            ->greeting('Hello ' . $notifiable->name . ',')
            ->line('You have received a new comment on your ticket:')
            ->line('“' . $this->comment->comment . '”')
            ->line('From: ' . $this->comment->user->name)
            ->action('View Ticket', url('/tickets/' . $this->comment->ticket_id))
            ->line('Thank you for using our support system!');
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'ticket_id' => $this->comment->ticket_id,
            'comment_id' => $this->comment->id,
            'message' => 'New comment on your ticket from ' . $this->comment->user->name,
        ];
    }
}
