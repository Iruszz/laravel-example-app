<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCommentNotification extends Notification
{
    use Queueable;

    protected $comment;

    /**
     * Create a new notification instance.
     */
    public function __construct($comment)
    {
        $this->comment = $comment;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $ticket = $this->comment->ticket;
        $user = $this->comment->user;

        $url = url("/tickets/{$ticket->id}#comment-{$this->comment->id}");
        
        return (new MailMessage)
            ->subject("New Comment on Ticket #{$ticket->id}")
            ->greeting("Hello {$notifiable->name},")
            ->line("{$user->name} added a new comment on ticket \"{$ticket->title}\":")
            ->line("\"{$this->comment->comment}\"")
            ->action('View Ticket', $url)
            ->line('Thank you for using our support system!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'ticket_id' => $this->comment->ticket_id,
            'comment_id' => $this->comment->id,
            'comment_comment' => $this->comment->comment,
        ];
    }
}
