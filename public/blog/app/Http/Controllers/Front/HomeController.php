<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\ContactUs;
use App\Models\Newsletter;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    /*    Home page   */
    public function index(Request $request)
    {
        return view('front.home.index');
    }

    /*    Our products page   */
    public function getOurProducts(Request $request)
    {
        return view('front.home.our-products');
    }

    /*   About us page */
    public function getAboutUs(Request $request)
    {
        return view('front.home.about-us');
    }

    /*   Contact us Page  */
    public function getContactUs(Request $request)
    {
        return view('front.home.contact-us');
    }

    /*   Corrugated Box Page  */
    public function getCorrugatedBox(Request $request)
    {
        return view('front.home.corrugated-box');
    }

    /*   Paper Core Page  */
    public function getPaperCore(Request $request)
    {
        return view('front.home.paper-core');
    }

    /*   Angle Boards Page  */
    public function getAngleBoards(Request $request)
    {
        return view('front.home.angle-boards');
    }

    /*   Angle Boards Page  */
    public function getPaperCourier(Request $request)
    {
        return view('front.home.paper-courier');
    }

    

    /*   Contact us form send  */
    public function sendContactUs(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => "required" ,
            'email' => 'required|email',
            'mobile_no' => 'nullable',  
            'message' => 'required',
        ]);

        if ($validator->passes()) {
            try {
                $data = [
                    'name' => $request->name,
                    'email' => $request->email,
                    'mobile_no' => $request->mobile_no,
                    'message' => $request->message,
                    'service' => 'contact-us'
                ];
                ContactUs::create($data);    

                $data['subject'] = 'Contact us';
                $data['subject'] = env('MAIL_FROM_ADDRESS');
                if($data['subject'])
                {
                    // Mail::send('emails.contact-us-mail', $data, function($message)use($data) {
                    //     $message->to($data["email"], $data["email"])
                    //             ->subject($data["subject"]);
                    // });
                }

                return response()->json(['success'=> true]);
            }catch (\Throwable $th) {
                return $th;
            }
        }
        return response()->json(['error'=>$validator->errors()->all()]);
    }

    public function sendNewsletter(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email_address' => 'required|email|unique:newsletters,email_address'
        ]);
        if ($validator->passes()) {
            try {
                $data = [
                    'email_address' => $request->email_address
                ];
                Newsletter::create($data);
                $data['subject'] = 'Newsletter us';
                return response()->json(['success'=> true , 'message' => 'Thank you!']);
                
            }catch (\Throwable $th) {
                // return $th;
                return response()->json(['error'=> false , 'message' => $th]);
            }   
        }
        return response()->json(['error'=>$validator->errors()->all()]); 
    }
}
