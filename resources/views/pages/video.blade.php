@extends('layouts.app')
@section('title')
    <title>Paybe.cz-video</title>
@endsection
@section('content')
    <div class="container-fluid v-midle" id="midle">
        <div style="margin: 0 auto;">
            {!! $embed !!}
        </div>
    </div>
    @include('partials.upload')
@endsection

