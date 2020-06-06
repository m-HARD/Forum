@component('profiles.activities.activity')
    @slot('heading')
        <i class="fa fa-plus-circle" style="color: green"></i>
        Published A
        "<a href="{{ $activity->subject->path() }}">{{ $activity->subject->title }}</a>"
    @endslot
    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
