<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Loan_category;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        return view('user.home');
    }

    public function applyLoan(Request $request, $type)
    {
        $user_id = Auth::id();
        // dd($type, $user_id);
        $loancategory = new Loan_category();
        $loancategory->user_id = $user_id;
        $loancategory->type = $type;
        $loancategory->save();
        return redirect()->route('user.step1', ['type' => $type]);
    }

    public function step1(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step1', compact('type'));
    }
}
