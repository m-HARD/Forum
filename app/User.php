<?php

namespace App;

use Carbon\Carbon;
use Exception;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @property mixed id
 */
class User extends Authenticatable
{
    use Notifiable;
    protected $guarded = [];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar_path',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function getRouteKeyName()
    {
        return 'name';
    }

    public function threads(){
        return $this->hasMany(Thread::class);
    }

    public function lastReply(){
        return $this->hasOne(Reply::class)->latest();
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    /**
     * @return mixed|string
     */
    public function avatar(){
        return  $this->avatar_path ?:  'avatars/default-avatar2.jpg';
    }

    /**
     * @param $thread
     * @throws Exception
     */
    public function threadRead($thread){

        cache()->forever($this->visitedThreadCacheKey($thread) , Carbon::now());
    }

    /**
     * @param $thread
     * @return string
     */
    public function visitedThreadCacheKey($thread){
        return sprintf("users.%s.visits.%s",$this->id,$thread->id);
    }
}
