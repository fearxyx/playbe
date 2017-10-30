<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    /**
     * @param Request $request
     * @return $this|\Illuminate\Http\RedirectResponse
     */
    public function upload(Request $request)
    {
        //nastavenia
        set_time_limit(0);
        ini_set('max_execution_time', 0);
        ini_set("memory_limit",-1);
        ini_set('post_max_size', '97280M');

        //Session na otvorenie modalu pri chybe
        Session::flash('video', '');

        //Validate
        $this->validate($request, [
            'videoFile' => 'required|max:9961472',
            'titleFile' => 'max:2048',
            'podmienki' => 'required',
        ]);
        //Ked je nahrany video subor spustime dalej
        if($request->hasFile('videoFile')) {

            $vidExt = $request->videoFile->getClientOriginalExtension();
            $fullName = $request->videoFile->getClientOriginalName();
            $name = str_slug(strtolower(explode('.',$fullName)[0]));

            //Skontrolujeme video subor
            if($vidExt != 'mkv' && $vidExt != 'flv' && $vidExt != 'mp4' && $vidExt != 'mpeg' && $vidExt != 'ts' && $vidExt != 'avi' && $vidExt != 'divx'){
                return redirect()->back()->withErrors(['videoFile' =>'Litujeme, ale tento formát nepodporujeme. Povolené formáty: mkv,flv,mp4,mpeg,divx,ts,avi']);
            }

            //Ked je prihlaseni tak stiahneme z db mail
            if(Auth::user()){
                $email = Auth::user()->email;
            }else{
                $email = $request->email;
            }
            $path = "$email/$name";

            //Ked existuje file tak posleme error
            $exists = Storage::disk('public')->exists($path."/$name.$vidExt");
            if($exists){
                return redirect()->back()->withErrors(['videoFile' =>'Litujeme, ale tento video už existuje']);
            }

            //Skontrolujeme titulky ci existuje
            $vtt = $request->file('titleFile');
            if ($request->hasFile('titleFile')){
                $vttExt = $request->titleFile->getClientOriginalExtension();
                //Kontrola suboru titulky
                if($vttExt == 'srt' || $vttExt == 'vtt' || $vttExt == 'sub'){
                    Storage::disk('public')->putFileAs($path, $vtt, "$name.$vttExt");
                }else{
                    return redirect()->back()->withErrors(['titleFile' =>'Litujeme, ale tento formát nepodporujeme. Povolené formáty: srt, vtt, sub.']);
                }

            }

            //Ulozime video
            $video = $request->file('videoFile');
            Storage::disk('public')->putFileAs($path, $video,$video->getClientOriginalName());

            //Ked je user prihlaseny ulozime do db pod user id -m
            if(Auth::user()){
                $upload= New Upload();
                $upload->user_id = Auth::user()->id;
                $upload->email = $email;
                $upload->hash = md5("storage/video/".$path."/$name.$vidExt");
                $upload->path = "storage/video/".$path."/"."$name.$vidExt";
                $upload->save();
            }else{
                $upload= New Upload();
                $upload->email = $email;
                $upload->hash = md5("storage/video/".$path."/"."$name.$vidExt");
                $upload->path = "storage/video/".$path."/"."$name.$vidExt";
                $upload->save();
            }

            Session::forget('errors');
            Session::flash('success', 'Úspěšně nahráno, děkujeme');

        }else{
            return redirect()->back()->withErrors('Musíte nejdřív vybrat soubor co chcete nahrát!');
        }
        return redirect()->back();


    }
}
