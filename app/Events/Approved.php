<?php

namespace App\Events;

use App\User;
use App\Account;
use App\Application;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class Approved implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $code;

    private $user;
    private $account;
    private $application;

    /**
     * Create a new event instance.
     *
     * @param Application $application
     * @param User $user
     */
    public function __construct(Application $application, User $user)
    {
        $this->user = $user;
        $this->application = $application;

        $this->account = Account::where('application_id', $application->id)
            ->where('user_id', $user->id)
            ->firstOrFail();
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $this->code = \Google2FA::getCurrentOtp($this->account->secret);
        $email = strtolower($this->user->email);
        return new Channel("{$this->application->id}-$email");
    }
}
