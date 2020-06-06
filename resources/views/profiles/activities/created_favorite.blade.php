@component('profiles.activities.activity')
    @slot('heading')
        <a href="{{ $activity->subject->favorited->path() }}">
            <i class="fa fa-heart" style="color: red"></i>
            Favorite A Reply
        </a>
        {{-- "<a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>" --}}
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent