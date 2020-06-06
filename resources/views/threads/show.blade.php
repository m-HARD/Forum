@extends('layouts.app')

@section('header')
    <link rel="stylesheet" href="{{ asset('css/vendor/jquery.atwho.min.css') }}">
@endsection

@section('content')
    <thread_show :initial-replies-count="{{ $thread->replies_count }}" inline-template >

        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>
                                <img src="{{asset("storage/" . $thread->creator->avatar())}}" alt="musab" width="25" height="25" style="border-radius: 50%">
                                <a href="{{ route('profile.show',$thread->creator->name) }}">{{ $thread->creator->name }}</a> ... {{ $thread->title }}
                                <span class="float-right" style="font-size: 16px;">
                                    @include('layouts.threadrightdropdown')
                                </span>
                            </h4>
                        </div>

                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>

                    <br><br><br>

                        <replies @removed="repliesCount--" replies-count="{{ $thread->replies_count }}"></replies>

                    {{--@include('threads.replies')--}}
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header"><h4>information about Thread</h4></div>

                        <div class="card-body">
                            <p>This Thread Created By <a href="{{ route('profile.show',$thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                Before {{ $thread->created_at->diffForHumans() }} .
                                @if ($thread->replies_count > 0)
                                    and currently has <span v-text="repliesCount"></span> {{ $thread->replies_count == 1 ? 'comment' : 'comments' }}
                                @else
                                    No comment yet
                                @endif
                            </p>
                            <p>
                                <subscribe-button :active="{{ json_encode($thread->isSubscribedTo) }}"></subscribe-button>
                            </p>
                        </div>
                    </div>
                </div>




            </div>
        </div>
    </thread_show>

@endsection
