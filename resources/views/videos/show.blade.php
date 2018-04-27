@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>A Premium Video</h1>

        @include('videos.player')
    </div>
@endsection