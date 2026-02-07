<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\ApplicationWorkflowStatus;

class DonorController extends Controller
{
    public function index(){

    }
    public function step1()
    {
        return view('donor.step1');
    }
    public function step2(){
        return view('donor.step2');
    }
    public function step3(){
        return view('donor.step3');
    }
    public function step4(){
        return view('donor.step4');
    }
    public function step5(){
        return view('donor.step5');
    }
    public function step6(){
        return view('donor.step6');
    }
    public function step7(){
        return view('donor.step7');
    }
    public function step8(){
        return view('donor.step8');
    }
    


    public function storestep1(Request $request) {
    // save step1 data
    return redirect()->route('donor.step2');
}

public function storestep2(Request $request) {
    return redirect()->route('donor.step3');
}

public function storestep3(Request $request) {
    return redirect()->route('donor.step4');
}

public function storestep4(Request $request) {
    return redirect()->route('donor.step5');
}

public function storestep5(Request $request) {
    return redirect()->route('donor.step6');
}

public function storestep6(Request $request) {
    return redirect()->route('donor.step7');
}

public function storestep7(Request $request) {
    return redirect()->route('donor.step7'); // or thank-you page
}

public function storestep8(Request $request) {
    return redirect()->route('donor.step8'); // or thank-you page
}
   
}
