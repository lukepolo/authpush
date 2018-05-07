<?php

namespace App\Events;

use App\Models\Account;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ApprovedRequest implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $code;

    private $account;
    private $application;

    /**
     * Create a new event instance.
     *
     * @param Account $account
     */
    public function __construct(Account $account)
    {
        $this->account = $account;
        $this->application = $account->application;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        $this->code = \Google2FA::getCurrentOtp($this->account->secret);
        $email = strtolower($this->account->label);
        return new Channel("{$this->application->id}-$email");
    }
}
