@extends('layouts.app')
@section('title')
    <title>Paybe.cz - Premium</title>
@endsection
@section('content')
    <div class="container" id="midle">
        <div style="background: #ffffff" class="col-md-8 col-md-offset-2">
            <h1></h1>
            <div>
                <h2>SMS ZA {{$price}},-KČ</h2>
                <h4>PM PLAYBE {{ $tvKey }} na číslo {{ $kode }}</h4>
            </div>
        </div>
    </div>

@endsection
