@component('profiles.activities.activity')
    @slot('heading')
        <i class="fa fa-reply" style="color: blue"></i>
        Replied To Thread
        "<a href="{{ $activity->subject->thread->path() }}">{{ $activity->subject->thread->title }}</a>"
    @endslot
    @slot('body')
        {{ strip_tags($activity->subject->body) }}
    @endslot
@endcomponent