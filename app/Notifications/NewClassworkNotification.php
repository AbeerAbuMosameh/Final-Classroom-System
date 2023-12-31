<?php

namespace App\Notifications;

use App\Models\Classwork;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Broadcast;
use function Symfony\Component\Translation\t;

class NewClassworkNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(protected Classwork $classwork)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    //$notifiable user receive notification -- benefit: can change channel according to user preferences

    public function via(object $notifiable): array
    {
        //channels: mail , database , broadcast (pusher), vonage (sms) , slack
        $via = ['mail', 'database', 'broadcast'];
//
//        if($notifiable->receive_mail_notification){
//            $via[] = 'mail';
//        }
        return $via;
    }


    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $classwork = $this->classwork;

        $content = __(' :name posted a new :type: :title', [
            'name' => $classwork->user->name,
            'type' => __($classwork->type->value),
            'title' => $classwork->title,
        ]);
        return (new MailMessage)
            ->subject(__('New :type', [
                'type' => $classwork->type->value,
            ]))
            ->greeting(__('Hi :name', [
                'name' => $notifiable->name,
            ]))
            ->line($content)
            ->action(__('Go to classwork'), route('classrooms.classwork.show', [$classwork->classroom_id, $classwork->id]))
            ->line('Thank you for using our application!');
    }

    public function toDatabase(object $notifiable): DatabaseMessage
    {
        return new DatabaseMessage($this->createMessage());
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->createMessage());
    }


    public function createMessage(): array
    {
        $classwork = $this->classwork;

        $content = __(' :name posted a new :type: :title', [
            'name' => $classwork->user->name,
            'type' => __($classwork->type->value),
            'title' => $classwork->title,
        ]);

        return [
            'title' => __('New :type', [
                'type' => $classwork->type->value,
            ]),
            'body' => $content,
            'image' => '',
            'link' => route('classrooms.classwork.show', [$classwork->classroom_id, $classwork->id]),
            'classwork' => $classwork->id,
        ] ;
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
