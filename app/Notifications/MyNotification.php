<?php
   
namespace App\Notifications;
   
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Notifications\CustomDbChannel;
   
class MyNotification extends Notification
{
    use Queueable;
  
    public $title;
    public $desc;
    public $movie_id;
    public $tvid;
    public $user_id;
     protected $casts=['user_id'=> 'array'];
    
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($title,$desc,$movie_id,$tvid,$user_id)
    {
        $this->title = $title;
        $this->desc = $desc;
        $this->movie_id = $movie_id;
        $this->tvid = $tvid;
        $this->user_id = $user_id;
    }
   
    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
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
    //                 ->greeting($this->details['greeting'])
    //                 ->line($this->details['body'])
    //                 ->action($this->details['actionText'], $this->details['actionURL'])
    //                 ->line($this->details['thanks']);
    // }
  
    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toDatabase($notifiable)
    {
        return [
        'title' => $this->title,
        'data' => $this->desc,
        'movie_id' => $this->movie_id,
        'tv_id'      => $this->tvid,
        'notifiable_id' => $this->user_id
        ];

    }
    
}