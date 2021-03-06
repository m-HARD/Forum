<?php

namespace App\Providers;

use App\Notifications\youWereMentioned;
use App\Providers\ThreadReceivedNewReply;
use App\User;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class NotifyMentionedUsers
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  ThreadReceivedNewReply  $event
     * @return void
     */
    public function handle(ThreadReceivedNewReply $event)
    {
        collect($event->reply->mentionedUsers())->map(function ($name){
            return User::whereName($name)->first();
        })->filter()->each(function ($user) use ($event){
            $user->notify(new youWereMentioned($event->reply));
        });
    }
}
