<?php


namespace App;


trait Favoritable
{

    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists())
            return $this->favorites()->create($attributes);
    }

    public function isfavorited()
    {
        return $this->favorites()->where('user_id', auth()->id())->exists();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isfavorited();
    }
    
    public function unfavorite()
    {
        $attributes = ['user_id' => auth()->id()];
        $this->favorites()->where($attributes)->get()->each->delete();
    }
}