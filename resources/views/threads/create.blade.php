@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-9">
            <div class="card">
                <div class="card-header" style="font-size: 18px;">Create Threads</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('threads.store') }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <div class="label">Channel :</div>
                            <select name="channel_id" id="channel_id" class="form-control" required>
                                    <option value="">Choose One ..</option>
                                @foreach ($channels as $channel)
                                    <option value="{{ $channel->id }}" {{ old('channel_id') == $channel->id ? 'selected' : '' }}>{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="label">Title :</div>
                            <input type="text" class="form-control" name="title" id="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <div class="label">Body :</div>
                            <textarea name="body" class="form-control" id="body" rows="5" required>{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-outline-primary btn-block">Publish</button>
                        </div>

                        @if (count($errors))
                            <div class="alert alert-danger">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection