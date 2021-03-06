<?php

namespace App\Policies;

use App\Reply;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ReplyPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can update the thread.
     *
     * @param User $user
     * @param Reply $reply
     * @return mixed
     */
    public function update(User $user, Reply $reply)
    {
        return $reply->user_id == $user->id;
    }

    /**
     * @param User $user
     * @return bool
     */
    public function create(User $user){
        if (! $lastReply = $user->fresh()->lastReply) return true;
        return ! $lastReply->wasJustPublished();
    }
}
