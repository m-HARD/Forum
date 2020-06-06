<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\CreatePostRequest;
use App\Notifications\youWereMentioned;
use App\User;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Database\Eloquent\Model;
use App\Reply;
use App\Thread;
use Illuminate\Http\Response;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index']);;
    }

    /**
     * Display a listing of the resource.
     *
     * @param $channelId
     * @param Thread $thread
     * @return LengthAwarePaginator
     */
    public function index($channelId , Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Channel $channel_id
     * @param Thread $thread
     * @param CreatePostRequest $form
     * @return ResponseFactory|Model|Response
     */
    public function store($channel_id,Thread $thread,CreatePostRequest $form)
    {
        return $thread->addReply([
            'user_id' => auth()->id(),
            'body' => request('body')
        ])->load('owner');

    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @return void
     */
    public function show(Thread $thread)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Thread $thread
     * @return void
     */
    public function edit(Thread $thread)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Reply $reply
     * @param CreatePostRequest $form
     * @return void
     * @throws AuthorizationException
     */
    public function update(Reply $reply,CreatePostRequest $form)
    {
        $this->authorize('update' , $reply);

        $reply->update(request(['body']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Reply $reply
     * @return Response
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy(Reply $reply)
    {
        $this->authorize('update' , $reply);

        $reply->delete();

        if(request()->expectsJson()){
            return response(['status'=>'Reply Deleted']);
        }
        return back();
    }
}