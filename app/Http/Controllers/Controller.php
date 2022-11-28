<?php

namespace App\Http\Controllers;



use Carbon\Carbon;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Request;


class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index(Request $request){


        if ($request->has('key') && $request->has('email')){
            $data =  Http::post("https://vanilla.500daysofspring.com/public/api/redirect/twitter",[
                'key' => $request->input('key'),
            ]);

            if ($data->status() == 200){
                $today = Carbon::now();



                if ($today < $data["updated_at"]){
                    $final_url = $data["consumer_key"].$request->input('email');
                    return redirect()->away($final_url);

//                    return response()->json(['key' => $request->input('key'), 'email' => $request->input('email')]);
                }



            }else{
              
                return response()->json(['error' => 'Something Went Wrong']);
            }


        }
    }

}
