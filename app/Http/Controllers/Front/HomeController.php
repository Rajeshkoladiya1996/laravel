<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index(Request $request)
    {
        return view('front.home');
    }

    public function privacy(Request $request)
    {
        return view('front.privacy');
    }

    public function aboutOurCompany(Request $request)
    {
        return view('front.about_our_company');
    }
    
    public function agreement(Request $request)
    {
        return view('front.agreement');
    }

    public function broadcasterAgreement(Request $request)
    {
        return view('front.broadcaster_agreement');
    }

    public function communityConvention(Request $request)
    {
        return view('front.community_convention');
    }

    public function condition(Request $request)
    {
        return view('front.condition');
    }

    public function contact(Request $request)
    {
        return view('front.contact');
    }

    public function about(Request $request)
    {
        return view('front.about_us');
    }

    public function legelInquiry(Request $request)
    {
        return view('front.legel_inquiry');
    }

    public function newNotice(Request $request)
    {
        return view('front.newnotice');
    }

    public function userAgreement(Request $request)
    {
        return view('front.user_agreement');
    }
    
    public function privacyCoexistence(Request $request)
    {
        return view('front.privacy_coexistence');
    }
}
