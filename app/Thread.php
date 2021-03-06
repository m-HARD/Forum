<?php

namespace App;

use App\Providers\ThreadReceivedNewReply;
use Exception;
use Illuminate\Database\Eloquent\Model;


/**
 * @property mixed channel
 * @property mixed id
 * @property mixed subscriptions
 * @property mixed updated_at
 */
class Thread extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    protected $appends = ['isSubscribedTo'];

    protected static function boot()
    {
        parent::boot();
        
        static::deleting(function ($thread){
           $thread->replies->each->delete();
        });
    }

    public function path()
    {
        return "/threads/{$this->channel->slug}/{$this->id}";
    }

    public function replies()
    {
        return $this->hasMany(Reply::class)->withCount('favorites')->with('owner')->latest();
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function channel()
    {
        return $this->belongsTo(Channel::class);
    }

    /**
     * @param $reply
     * @return Model
     */
    public function addReply($reply)
    {
        $reply = $this->replies()->create($reply);

        event(new ThreadReceivedNewReply($reply));

        return $reply;
    }

    /**
     * @param $query
     * @param $filters
     * @return mixed
     */
    public function scopeFilter($query , $filters)
    {
        return $filters->apply($query);
    }

    public function subscribe($userId = null){
        $this->subscriptions()->create([
            'user_id' => $userId ?: auth()->id()
        ]);
    }

    public function unsubscribe($userId = null){
        $this->subscriptions()->where('user_id' , $userId ?: auth()->id())->delete();
    }

    public function subscriptions(){
        return $this->hasMany(ThreadSubscripition::class);
    }
    
    public function getIsSubscribedToAttribute(){
        return $this->subscriptions()->where('user_id' , auth()->id())->exists();
    }

    /**
     * @param $user
     * @return bool
     * @throws Exception
     */
    public function hasUpdatesFor($user){

        $key = $user->visitedThreadCacheKey($this);
        return $this->updated_at > cache($key);
    }
}

