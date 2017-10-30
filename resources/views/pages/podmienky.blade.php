@extends('layouts.app')
@section('title')
    @if($type == 0)
        <title>Podmínky použití</title>
    @else
        <title>Jak používat SerialHD</title>
    @endif
@endsection
@section('content')

    <style>
        .titl {
            font-size: 18px;
            margin-bottom: 40px;
            color: #232426;
        }
    </style>
    <div style="background: #e3e8e2;" class="v-midle film-cont">
        <div id="serial-container" class="center-block">
            <div class="container">
                <div class="content center-block">
                    <div style="text-align: center" class="titl">

                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
