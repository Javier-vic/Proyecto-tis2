<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class criticalSupply extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($supply)
    {
        $this->supply = $supply;
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
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    // public function toMail($notifiable)
    // {
    //     return (new MailMessage)
    //                 ->line('The introduction to the notification.')
    //                 ->action('Notification Action', url('/'))
    //                 ->line('Thank you for using our application!');
    // }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function toArray($notifiable)
    // {
    //     return [
        //         'data'=>'ejemplo notificacion'
        //     ];
        // }
        
    public function toDatabase($notifiable){
        return [
            'name_supply' => $this->supply->name_supply,
            'quantity' => $this->supply->quantity,
            'critical_quantity' => $this->supply->critical_quantity,
        ];
    }
}
