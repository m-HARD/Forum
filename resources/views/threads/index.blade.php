@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <span class="float-left" style="font-size: 18px;">Forum Threads</span>
                    <span class="float-right"><a href="/threads/create" class="btn btn-outline-primary btn-sm">Create Thread</a></span>
                </div>
            </div>
                    @forelse ($threads as $thread)
                        <div class="card" style="margin-top: 10px">
                            <div class="card-header">
                                <span style="font-size: 18px">
                                    <span>
                                            <a href="{{ $thread->path() }}">
                                        @if(auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                                            <strong>
                                        {{ $thread->title }}
                                            </strong>
                                        @else
                                            {{ $thread->title }}
                                        @endif
                                            </a>
                                    </span>

                                    <span class="float-right" style="font-size: 16px;" >
                                        {{ $thread->replies_count }}
                                        <i class="fa fa-comments-o" aria-hidden="true"></i>
                                        @include('layouts.threadrightdropdown')
                                    </span>

                                    <span style="font-size: 12px">
                                        <br>
                                        Posted By : <a href="{{ route('profile.show',$thread->creator->name) }}">{{ $thread->creator->name }}</a>
                                    </span>
                                </span>
                            </div>

                            <div class="card-body">
                                {{ $thread->body }}

                                <div style="margin-bottom: 6px; margin-top: 40px">
                                    <div class="row" style="margin-bottom: -9px">

                                        <a href="#" class="col-md-2 offset-1 btn btn-outline-primary btn-sm"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i> Like</a>
                                        <a href="{{ $thread->path() }}" class="col-md-2 offset-2 btn btn-outline-primary btn-sm"><i class="fa fa-comments" aria-hidden="true"></i> Comments</a>
                                        <a href="#" class="col-md-2 offset-2 btn btn-outline-primary btn-sm"><i class="fa fa-share" aria-hidden="true"></i> Share</a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @empty
                        <br>
                        <p class="text-center" style="color: white">
                            No Threads At This Time.
                        </p>
                    @endforelse


        </div>
    </div>
</div>
@endsection
