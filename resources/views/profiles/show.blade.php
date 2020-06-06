@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">
                        <h4>
                            <img src="{{asset("storage/" . $profile_user->avatar())}}" alt="musab" width="25" height="25" style="border-radius: 50%">
                            {{ $profile_user->name }} ...
                            <span class="float-right">{{ $profile_user->created_at->diffForHumans() }}</span>
                        </h4>
                    </div>

                    <div class="card-body">
                        {{--  {{ $profile_user->password }} --}}

                        @can('update' , $profile_user)
                            <form method="POST" action="{{ route('avatar',$profile_user) }}" enctype="multipart/form-data">
                                {{ csrf_field() }}
                                <input type="file" name="avatar">
                                <button type="submit" class="btn btn-primary">Add Avatar</button>
                            </form>
                        @endcan
                    </div>
                </div>


                <br><br><br><br><br>

                <div class="card">
                    <div class="card-header">
                        <span class="float-left" style="font-size: 18px;">{{ $profile_user->name }} History</span>
                    </div>
                </div>
                        @forelse ($activities as $date => $activity)
                            <h3 class="text-center" style="margin-top: 40px">{{ $date }}</h3>
                            @foreach($activity as $record)
                                @if(view()->exists("profiles.activities.{$record->type}"))
                                    @include("profiles.activities.{$record->type}",['activity' => $record])
                                @endif
                            @endforeach
                        @empty
                            <br>
                            <p class="text-center">
                                There is no activty for this user yet.
                            </p>
                        @endforelse

            </div>




        </div>
    </div>
@endsection
