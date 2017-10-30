@extends('layouts.app')
@section('title')
    <title>Paybe.cz - Mojevidea</title>
@endsection
@section('content')
    <div class="container-fluid" id="midle">
        <div class="col-md-12">
            <h1 class="text-center white">Moje videa</h1>
        <div class="col-xs-12 videos">
            @if(Auth::user()->uploads->first())
                @foreach(Auth::user()->uploads as $video)
                    <div class="col-xs-4">
                        <div class="col-xs-8">{{ $video->hash }}</div>
                        @if($video->embed == NULL)
                            <div class="col-xs-3 wait text-center" >Zpracovává se...</div>
                        @else
                            <div class="col-xs-2"><a href="/video/{{$video->hash}}" class="btn btn-primary">Pozrieť</a></div>
                            <div class="col-xs-2"><a href="/video/delete/{{$video->id}}" class="btn btn-danger">Zmazat</a></div>
                        @endif
                    </div>
                @endforeach
            @else
                <h3  class="text-center">Nemáte zatím nahrané žádná videa</h3>
            @endif
        </div>
        </div>
    </div>
    @include('partials.upload')
@endsection
