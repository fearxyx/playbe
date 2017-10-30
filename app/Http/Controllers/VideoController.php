<?php

namespace App\Http\Controllers;

use App\Upload;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;



class VideoController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('pages.mojevidea');
    }

    public function destroy($id)
    {
        $upload = Upload::where('id',$id)->first();
        $upload->delete();
        return redirect()->back();
    }
    public function getVideo($id)
    {
        $user_id = Auth::user()->id;
        $video = Upload::where('user_id', $user_id)->where('hash',$id)->first()->embed;
        if(!$video){
            return redirect()->back();
        }

        $provoz = DB::table('provozs')->get();
        $urlIframe = $provoz[1]->text;
        $startIframe = $provoz[2]->text;
        $endIframe = $provoz[3]->text;

        if(substr($video,0,7) == "<script" ){
            $embed = $video;
        }elseif(substr($video,0,7) == "<iframe" ){
            $embed = $video;
        }elseif(substr($video,0,7) == "https:/" ){
            $embed = $startIframe ." src=".$video .$endIframe;
        }else{
            $embed = $startIframe ." src=".$urlIframe.$video. $endIframe;
        }


        return view('pages.video')->with(['video' => $video, 'embed' => $embed]);
    }
}
