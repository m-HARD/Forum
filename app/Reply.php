<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

/**
 * @property mixed user_id
 * @property mixed created_at
 * @property mixed thread
 * @property mixed id
 */
class Reply extends Model
{
    use RecordsActivity,Favoritable;
    protected $guarded = [];
    protected $appends = ['isfavorited'];

    protected static function boot(){

        parent::boot();        

        static::created(function ($reply){
            $reply->thread->increment('replies_count');
        });

        static::deleted(function ($reply){
            $reply->thread->decrement('replies_count');
        });

        static::deleting(function ($model){
            $model->favorites->each->delete();
        });
    }

   public function owner()
   {
       return $this->belongsTo(User::class,'user_id');
   }

   public function thread()
   {
       return $this->belongsTo(Thread::class);
   }

   public function wasJustPublished(){
        return $this->created_at->gt(Carbon::now()->subMinute());
   }

   public function mentionedUsers(){
       preg_match_all('/\@([^\s\.]+)/',$this->body,$matches);

       return $matches[1];
   }

   public function setBodyAttribute($body){
        $this->attributes['body'] = preg_replace('/@([\w\-]+)/','<a href="/profile/$1">$0</a>',$body);
   }

   public function path()
   {
       return $this->thread->path() . "#reply-" . $this->id ;
   }

}
