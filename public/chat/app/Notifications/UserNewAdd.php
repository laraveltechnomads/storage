<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNewAdd extends Notification
{
    use Queueable;
    protected $user;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($user)
    {
        $this->user_id = $user->id;
        $this->user_name = $user->name;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
        // return ['mail'];        
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        
        // $title = 'User Created';
        // $icon = logo_pic_path('');
        // $image = '';
        // $message = $user->name . ' : User created.';
        // $linkurl= route("admin.users.show", [$user->id]);
        // pushNotificationToAdmin($title, $message, $icon, $image,$linkurl);

        return [
            //
        ];
    }

    public function toDatabase($notifiable)
    {
        return [
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'type' => 'new'
        ];
    }    
}
