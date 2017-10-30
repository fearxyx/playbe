<?php

namespace App\Http\Controllers;

use App\Payment;
use App\Premium;
use App\src\TpReturnedPayment;
use App\Zaplaceno;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\src\helpers\TpDivMerchantHelper;
use App\src\TpMerchantConfig;
use App\src\TpPayment;
use Illuminate\Support\Facades\Session;

class PremiumController extends Controller
{
    public function index()
    {
        date_default_timezone_set('Europe/Budapest');
        $subscription = false;
        $premiumDatas = Premium::all();
        $user = Auth::user();
        $premiumDatum = $user->premium;
        $premium = "";
        $active = "Neaktivní";
        if($premiumDatum > Carbon::now()){
            $active = "aktivní do";
            $premium = Carbon::parse($premiumDatum)->format('d.m.Y H:i:s');
        }
        if( $user->subscription != null){
            $active = "aktivní do";
            $premium = 'nekonecno';
            $subscription = true;
        }

        return view('pages.premium')->with([
            'active' => $active,
            'premium' => $premium,
            'key' => $user->random_key,
            'premiumDatas' => $premiumDatas,
            'subscription' => $subscription
        ]);

    }
    public function getPayments($price)
    {
        $email = Auth::user()->email;
        $id = Auth::user()->id;
        $key = Auth::user()->random_key;
        $p = new TpPayment(new TpMerchantConfig());
        $p->setValue($price);
        $p->setCustomerEmail($email);
        $p->setDescription("Platba za PREMIUM účet");
        $p->setMerchantData($id);
        $p->setBackToEshopUrl('https://playbe.cz');
        $p->setMerchantSpecificSymbol($key);
        $p->setCustomerData($key);
        $p->setReturnUrl("https://playbe.cz/platba/vmrcfgbmpfppmdk/check");
        $hlp = new TpDivMerchantHelper($p);
        $data = $hlp->render();


        return response()->json([
            'data' => $data,
        ]);
    }
    public function paymentsCheck(Request $request)
    {
        $p = new TpReturnedPayment(new TpMerchantConfig());
        $method = $request->method();

        if($p->verifySignature()){
        // platba je platná – obsahuje všechny nezbytné údaje a podpis je platný
            $user_id = $p->getMerchantData();
            $hash = $p->getSignature();
            $price = number_format($p->getValue());
            if($p->getStatus() == TpReturnedPayment::STATUS_OK){
                // platba je zaplacena, můžeme si ji uložit jako zaplacenou a dále zpracovat (vyřídit objednávku atp.).
                $payment = Payment::where('user_id', $user_id)->where('price', $price)->first();
                //ked existuje platba pridame premium a vymazeme
                if($payment){
                    $payment->delete();
                }
                $zaplaceno = new Zaplaceno();
                $zaplaceno->user_id = $user_id;
                $zaplaceno->price = $price;
                $zaplaceno->platba = 'Prevod';
                $zaplaceno->save();
                $this->addPremium($user_id, $price);
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    Session::flash('success', 'Platba byla ověřená. PREMIUM bylo přidáno.');
                    return redirect()->route('premium');
                }
            } else if($p->getStatus() == TpReturnedPayment::STATUS_UNDERPAID){
                // zákazník zaplatil pouze část platby
                $payment = new Payment;
                $payment->user_id = $user_id;
                $payment->hash = $hash;
                $payment->price = $price;
                $payment->stav = 1;
                $payment->save();
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    Session::flash('success', 'Děkujeme platba proběhla úspěšně, ale ještě čeká na potvrzení od poskytovatele platební brány.');
                    return redirect()->route('premium');
                }
            } else if($p->getStatus() == TpReturnedPayment::STATUS_CARD_DEPOSIT){
                // částka byla zablokována na účtu zákazníka – pouze pro platbu kartou
                $payment = new Payment;
                $payment->user_id = $user_id;
                $payment->hash = $hash;
                $payment->price = $price;
                $payment->stav = 1;
                $payment->save();
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    Session::flash('success', 'Platba byla zablokována. Vyčkejte na přidání PREMIUM.');
                    return redirect()->route('premium');
                }
            } else if($p->getStatus() == TpReturnedPayment::STATUS_CANCELED){
                // zákazník platbu stornoval
                $payment = Payment::where('user_id', $user_id)->where('price', $price)->first();
                if($payment){
                    $payment->delete();
                }
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    return redirect()->route('premium')->with([
                        'error' => "Platba bohužel byla zrušena.",
                    ]);
                }
            } else if($p->getStatus() == TpReturnedPayment::STATUS_ERROR){
                // při zpracování platby došlo k chybě
                $payment = Payment::where('user_id', $user_id)->where('price', $price)->first();
                if($payment){
                    $payment->delete();
                }
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    return redirect()->route('premium')->with([
                        'error' => "Při platbě došlo k chybě, kontaktujte nás prosím na: podpora@playbe.cz",
                    ]);

                }
            } else if($p->getStatus() == TpReturnedPayment::STATUS_WAITING){
                // platba proběhla úspěšně, ale čeká na potvrzení od poskytovatele platební metody. S vyřízením objednávky je nutno počkat na potvrzovací request se statusem TpReturnedPayment:: STATUS_OK, pokud nepřijde, platba nebyla dokončena.
                $payment = new Payment;
                $payment->user_id = $user_id;
                $payment->hash = $hash;
                $payment->price = $price;
                $payment->stav = 1;
                $payment->save();
                if($method == "HEAD"){
                    return response('succes',200);
                }else{
                    Session::flash('success', 'Platba proběhla úspěšně, ale čekáme na potvrzení od poskytovatele platební brány. Jakmile potvrzení proběhne, PREMIUM bude přidané.');
                    return redirect()->route('premium');
                }
            }
        } else {
            // neplatný požadavek – nejde o návrat z brány, došlo k nějaké chybě, parametry byly podvrženy...
            if($method == "HEAD"){
                return response('succes',200);
            }else{
                return redirect()->route('premium')->with([
                    'error' => "Neplatný požadavek\"",
                ]);
            }
        }
        if($method == "HEAD"){
            return response('succes',200);
        }else{
            return redirect()->route('premium')->with([
                'error' => "Někde se stala chyba.",
            ]);
        }
    }
    private function addPremium($user_id, $price)
    {
        $day = 0;
        switch ($price) {
            case 30:
                $day = 7;
                break;
            case 50:
                $day = 30;
                break;
            case 150:
                $day = 90;
                break;
            case 300:
                $day = 180;
                break;
        }
        // Actualni cas
        $actual = Carbon::now();

        $user = User::where('id', $user_id)->first();
        $premium = $user->premium;

        if($premium > $actual){
            //Premium mal uz velmy davno vyprsane
            //pridame cas
            $premium = Carbon::parse($premium);
            $premium = $premium->addDay($day);
        }else{
            //este ma premium. pridame mu cas
            $premium = $actual->addDay($day);
        }
        $user->premium = $premium;
        $user->save();

    }

}
