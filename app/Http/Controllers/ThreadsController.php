<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilter;
use App\Rules\SpamFree;
use App\User;   
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\Request;
use App\Channel;
use App\Thread;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class ThreadsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth')->except(['index','show']);
    }

    /**
     * Display a listing of the resource.
     * @param Channel $channel
     * @param ThreadFilter $filter
     * @return Response
     */
    public function index(Channel $channel , ThreadFilter $filter)
    {

        $threads = $this->getThreads($channel , $filter);
        
        return view('threads.index' , compact('threads'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('threads.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {

        $this->validate($request,[
            'title' => [new SpamFree , 'required'],
            'body' => [new SpamFree , 'required'],
            'channel_id' => 'required|exists:channels,id'
        ]);

        Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body')
        ]);

        return redirect()->route('threads.index')
            ->with('flash','Your Thread Has Been published');
    }

    /**
     * Display the specified resource.
     *
     * @param Thread $thread
     * @param Channel $channel_id
     * @return Response
     */
    public function show($channel_id,Thread $thread)
    {
        auth()->user()->threadRead($thread);

        return view('threads.show', compact('thread'));
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
     * @param Request $request
     * @param Thread $thread
     * @return void
     */
    public function update(Request $request, Thread $thread)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $channel
     * @param Thread $thread
     * @return Response
     * @throws AuthorizationException
     * @throws Exception
     */
    public function destroy($channel,Thread $thread)
    {
        $this->authorize('update' , $thread);
        $thread->delete();

        return redirect('threads');
    }

    public function getThreads($channel , $filter)
    {
        $threads = Thread::with('channel')->latest()->filter($filter);

        if($channel->exists){
            $threads->where('channel_id',$channel->id);
        }

        return $threads->get();

    }
}
