@extends('layouts.app')
@section('title')
    <title>Paybe.cz - Premium</title>
@endsection
@section('content')
    <div class="container-fluid" id="midle">
        @include('partials.message')
        <div class="col-md-12 text-center">
            <div style="padding-left: 0 !important; " id="ress" class="left premium_up col-md-12"><h1 class="white">Premium {{$active}} <b>{{$premium}}</b></h1><h1 class="white" id="active"></h1></div>
            <div class="col-xs-12 videos">
                <div class="col-md-3 ">
                    <h2 class="premium-nadpis">7 DNÍ</h2>
                    <a title="Jedná se o platbu pomocí telefonu (SMS zpráva), která je vykonána ihned" href="#sms30" role="button" data-toggle="modal"><div class="col-md-12 premium-box sms"><span>SMS 30,-KČ</span></div></a>
                    <a title="Jedná se o platbu bankovním převodem v reálném čase přes platební bránu ThePay" onclick="getPayments(30)" href="#bank" role="button" data-toggle="modal"><div class="col-md-12 premium-box bank"><span>BANKOVNI PŘEVOD 30,-KČ</span></div></a>
                    <a title="edná se o platbu kreditní kartou, která je vykonána ihned" href="#karta30" role="button" data-toggle="modal"><div class="col-md-12 premium-box karta"><span>PLATBA KARTOU 30,-KČ</span></div></a>
                </div>
                <div class="col-md-3 ">
                    <h2 class="premium-nadpis">30 DNÍ</h2>
                    <a title="Jedná se o platbu pomocí telefonu (SMS zpráva), která je vykonána ihned"  href="#sms50" role="button" data-toggle="modal"><div class="col-md-12 premium-box sms"><span>SMS 50,-KČ</span></div></a>
                    <a title="Jedná se o platbu bankovním převodem v reálném čase přes platební bránu ThePay" onclick="getPayments(50)" href="#bank" role="button" data-toggle="modal"><div class="col-md-12 premium-box bank"><span>BANKOVNI PŘEVOD 50,-KČ</span></div></a>
                    <a title="edná se o platbu kreditní kartou, která je vykonána ihned" href="#karta30" role="button" data-toggle="modal"><div class="col-md-12 premium-box karta"><span>PLATBA KARTOU 50,-KČ</span></div></a>
                </div>
                <div class="col-md-3 ">
                    <h2 class="premium-nadpis">90 DNÍ</h2>
                    <a title="edná se o platbu kreditní kartou, která je vykonána ihned" href="#karta30" role="button" data-toggle="modal"><div class="col-md-12 premium-box karta"><span>PLATBA KARTOU 150,-KČ</span></div></a>
                    <a title="Jedná se o platbu bankovním převodem v reálném čase přes platební bránu ThePay" onclick="getPayments(150)" href="#bank" role="button" data-toggle="modal"><div class="col-md-12 premium-box bank"><span>BANKOVNI PŘEVOD 150,-KČ</span></div></a>
                </div>
                <div class="col-md-3 ">
                    <h2 class="premium-nadpis">180 DNÍ</h2>
                    <a title="edná se o platbu kreditní kartou, která je vykonána ihned" href="#karta30" role="button" data-toggle="modal"><div class="col-md-12 premium-box karta"><span>PLATBA KARTOU 300,-KČ</span></div></a>
                    <a title="Jedná se o platbu bankovním převodem v reálném čase přes platební bránu ThePay" onclick="getPayments(300)" href="#bank" role="button" data-toggle="modal"><div class="col-md-12 premium-box bank"><span>BANKOVNI PŘEVOD 300,-KČ</span></div></a>
                </div>
            </div>
        </div>
    </div>
    @include('modals.sms30')
    @include('modals.sms50')
    @include('modals.bank')
    @include('modals.karta30')
@endsection
