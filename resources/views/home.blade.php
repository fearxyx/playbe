@extends('layouts.app')
@section('title')
        <title>Paybe.cz</title>
@endsection
@section('content')
<div class="container-fluid v-midle " id="midle">
    <div class="col-md-12 text-center">
        @include('partials.messagePlatba')
        <h2>
            Nahrávejte videa anonymně až do 10 GB! Po zpracování můžete sdílet s ostatnímy.
        </h2>
        <h3>
            Nahrajte, přehrajte, stáhněte, sdílejte.
        </h3>

            <div class="col-md-12 clearfix">
                <a data-toggle="modal" data-target="#upload-modal" id="uploadCategory">
                    {{ HTML::image('img/upload.png', 'logo', ["title" => "upload","class" => "upload-img"], config('app.http'))}}
                </a>
            </div>
        @guest
            <div class="col-md-12 clearfix buttons-cont">
                <div style="margin: 60px 0;" class="col-md-6 left-cont">
                <a data-toggle="modal" data-target="#upload-modal" id="uploadCategory"  class="upload">NAHRRÁT ANONYMNĚ</a>
                </div>
                <div style="margin: 60px 0;" class="col-md-6 right-cont">
                <a class="reg" href="/register">ZAREGISTROVAT SE</a>
            </div>
            </div>
        @else
            <div class="col-md-12 clearfix buttons-cont">
                <a data-toggle="modal" data-target="#upload-modal" id="uploadCategory"  class="upload">NAHRRÁT</a>
            </div>
        @endguest
    </div>
</div>
    @include('partials.upload')
@endsection
