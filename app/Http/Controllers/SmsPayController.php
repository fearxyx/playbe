<?php

namespace App\Http\Controllers;

use App\Sms;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class SmsPayController extends Controller
{
    public function GetPaySms(Request $request)
    {
        $price = $request->price;
        $kode = $this->getKode($price);

        $tvKey = Auth::user()->random_key;

        $sms = new Sms();
        $sms->user_id = Auth::user()->id;
        $sms->kode = $kode;
        $sms->key = "PM PLAYBE 463403";
        $sms->save();

        return view('pages.smsPlatba')->with(["tvKey" => $tvKey, "price" => $price, 'kode' => $kode]);

    }

    public function GetSmsGenerate($price = null ,Request $request)
    {
        if($price){

        }

        return redirect()->back();

    }
    public function getCheckSms(Request $request)
    {

        $response = "Dekujeme za zaslani SMS.";

        return response($response, 200)
            ->header('Content-Type', 'text/plain')
            ->header('Content-length:', strlen($response));

        date_default_timezone_set('Europe/Budapest');
        $add = Carbon::now()->addDay(7);

        $sms = $request->sms;
        $phone = $request->phone;
        $price = $request->shortcode;

        $check = Sms::where('key', 'LIKE','%'. $sms. '%')->where('kode',$price)->first();
        if($check){
            $user = User::where('id',$check->user_id)->first();
            $user->premium = $add;
            $user->save();
            $response = "Dekujeme za zaslani SMS.";
            $len = strlen($response);
            return view("pages.test");
        }

        return response('Spatne nakonfigurovana SMS brana. Prosim zkontrolujte URL adresu skriptu, ktery prijima SMS', 404);


    }
    public function getKode ($price)
    {
        switch ($price) {
            case 3:
                $kode = 9033303;
                break;
            case 6:
                $kode = 9033306;
                break;
            case 9:
                $kode = 9033309;
                break;
            case 10:
                $kode = 9033310;
                break;
            case 20:
                $kode = 9033320;
                break;
            case 30:
                $kode = 9033330;
                break;
            case 50:
                $kode = 9033350;
                break;
            case 79:
                $kode = 9033379;
                break;
            case 99:
                $kode = 9033399;
                break;
            default:
                $kode = 9033320;
        }
        return $kode;
    }
}
