<?php

namespace App\Notifications;

use App\Models\Account;
use App\Models\AuthRequest;
use NotificationChannels\Apn\ApnChannel;
use NotificationChannels\Apn\ApnMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class RequestApproval extends Notification implements ShouldBroadcastNow
{
    private $account;
    private $authRequest;

    /**
     * RequestApproval constructor.
     * @param Account $account
     * @param AuthRequest $authRequest
     */
    public function __construct(Account $account, AuthRequest $authRequest)
    {
        $this->account = $account;
        $this->authRequest = $authRequest;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [ApnChannel::class];
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

    public function toApn($notifiable)
    {
        return ApnMessage::create()
            ->badge(1)
            ->title('Requesting Approval')
            ->body('CodePier.test is asking for approval')
            ->custom('label', $this->account->label)
            ->custom('domain', $this->account->application->domain)
            ->custom('requestHash', $this->authRequest->id)
            ->category('APPROVE');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
