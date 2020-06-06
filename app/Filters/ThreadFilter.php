<?php

namespace App\Filters;

use Illuminate\Foundation\Auth\User;

class ThreadFilter extends Filters
{
    protected $filters = ['by','popular','unanswered'];

    public function by($username)
    {
        $user = User::where('name' , $username)->firstOrFail();
        return $this->builder->where('user_id',$user->id);
    }

    public function popular($builder)
    {
        $this->builder->getQuery()->orders =[];
        return $this->builder->orderBy('replies_count' , 'desc');
    }
    
    public function unanswered()
    {
        return $this->builder->where('replies_count' , 0);
    }
}