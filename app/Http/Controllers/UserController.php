<?php

namespace App\Http\Controllers;


use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Loan_category;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    public function index()
    {
        $user_id = Auth::id();
        $existingLoan = Loan_category::where('user_id', $user_id)->latest()->first();
        if ($existingLoan) {
            return redirect()->route('user.step1');
        }
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


    // public function step1store(Request $request)
    // {
    //     //  dd($request->all());
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
    //         'financial_asset_for' => 'required|in:graduation,post_graduation',
    //         'aadhar_card_number' => 'required|string|max:12',
    //         'pan_card' => 'required|string|max:10',
    //         'phone' => 'required|string|max:15',
    //         'email' => 'required|email|max:255',
    //         'alternate_phone' => 'nullable|string|max:15',
    //         'alternate_email' => 'nullable|email|max:255',
    //         'address' => 'required|string|max:500',
    //         'city' => 'required|string|max:100',
    //         'district' => 'required|string|max:100',
    //         'state' => 'required|string|max:100',
    //         'chapter' => 'required|string|max:100',
    //         'pin_code' => 'required|string|max:10',
    //         'nationality' => 'required|in:indian,foreigner',
    //         'd_o_b' => 'required|date_format:d-m-Y',
    //         'birth_place' => 'required|string|max:100',
    //         'gender' => 'required|in:male,female,Male,Female',
    //         'age' => 'required|integer|min:18',
    //         'marital_status' => 'required|in:married,unmarried',
    //         'religion' => 'required|string|max:50',
    //         'sub_cast' => 'required|string|max:50',
    //         'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
    //         'specially_abled' => 'required|in:yes,no',
    //     ]);

    //     $user = User::find(Auth::user()->id);

    //     // Handle image upload
    //     // if ($request->hasFile('image')) {
    //     //     $imageName = time() . '.' . $request->image->extension();
    //     //     $request->image->move(public_path('images'), $imageName);
    //     //     $user->image = 'images/' . $imageName;
    //     // }

    //     if ($request->hasFile('image')) {
    //         $imageName = time() . '.' . $request->image->extension();
    //         $request->image->move('images', $imageName);
    //         $data['image'] = 'images/' . $imageName;
    //     }



    //     $data = [
    //         'name' => $request->name,
    //         'financial_asset_type' => $request->financial_asset_type,
    //         'financial_asset_for' => $request->financial_asset_for,
    //         'aadhar_card_number' => $request->aadhar_card_number,
    //         'pan_card' => $request->pan_card,
    //         'phone' => $request->phone,
    //         'email' => $request->email,
    //         'alternate_phone' => $request->alternate_phone,
    //         'alternate_email' => $request->alternate_email,
    //         'current_address' => $request->address,
    //         'city' => $request->city,
    //         'district' => $request->district,
    //         'state' => $request->state,
    //         'chapter' => $request->chapter,
    //         'pin_code' => $request->pin_code,
    //         'nationality' => $request->nationality,
    //         'd_o_b' => $request->d_o_b,
    //         'birth_place' => $request->birth_place,
    //         'gender' => $request->gender,
    //         'age' => $request->age,
    //         'marital_status' => $request->marital_status,
    //         'religion' => $request->religion,
    //         'sub_cast' => $request->sub_cast,
    //         'blood_group' => $request->blood_group,
    //         'specially_abled' => $request->specially_abled,
    //     ];

    //     if ($request->hasFile('image')) {
    //         $data['image'] =  time() . '.' . $request->image->extension();
    //         $request->image->move('images', $data['image']);
    //     }

    //     $user->update($data);

    //     // For now, since step2 not implemented, redirect back with success
    //     return redirect()->route('user.step2')->with('success', 'Personal details saved successfully!');
    // }


    public function step1store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'financial_asset_type' => 'required|in:domestic,foreign_finance_assistant',
            'financial_asset_for' => 'required|in:graduation,post_graduation',
            'aadhar_card_number' => 'required|string|max:12',
            'pan_card' => 'required|string|max:10',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'alternate_phone' => 'nullable|string|max:15',
            'alternate_email' => 'nullable|email|max:255',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'district' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'chapter' => 'required|string|max:100',
            'pin_code' => 'required|string|max:10',
            'nationality' => 'required|in:indian,foreigner',
            'd_o_b' => 'required|date_format:d-m-Y',
            'birth_place' => 'required|string|max:100',
            'gender' => 'required',
            'age' => 'required|integer|min:18',
            'marital_status' => 'required|in:married,unmarried',
            'religion' => 'required|string|max:50',
            'sub_cast' => 'required|string|max:50',
            'blood_group' => 'required|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'specially_abled' => 'required|in:yes,no',
        ]);

        $user = User::find(Auth::user()->id);

        $data = [
            'name' => $request->name,
            'financial_asset_type' => $request->financial_asset_type,
            'financial_asset_for' => $request->financial_asset_for,
            'aadhar_card_number' => $request->aadhar_card_number,
            'pan_card' => $request->pan_card,
            'phone' => $request->phone,
            'email' => $request->email,
            'alternate_phone' => $request->alternate_phone,
            'alternate_email' => $request->alternate_email,
            'current_address' => $request->address,
            'city' => $request->city,
            'district' => $request->district,
            'state' => $request->state,
            'chapter' => $request->chapter,
            'pin_code' => $request->pin_code,
            'nationality' => $request->nationality,
            'd_o_b' => Carbon::createFromFormat('d-m-Y', $request->d_o_b)->format('Y-m-d'),
            'birth_place' => $request->birth_place,
            'gender' => $request->gender,
            'age' => $request->age,
            'marital_status' => $request->marital_status,
            'religion' => $request->religion,
            'sub_cast' => $request->sub_cast,
            'blood_group' => $request->blood_group,
            'specially_abled' => $request->specially_abled,
        ];

        // Handle image upload (only once)
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $data['image'] = 'images/' . $imageName;
        }

        $user->update($data);

        return redirect()->route('user.step2')->with('success', 'Personal details saved successfully!');
    }




    public function step2(Request $request)
    {
        $user_id = Auth::id();
        $type = Loan_category::where('user_id', $user_id)->latest()->first()->type;
        return view('user.step2', compact('type'));
    }


    public function step2store(Request $request)
    {
        dd($request->all());
        // Implement validation and storage logic for step 2 here

        // For now, just redirect back with success
        return redirect()->route('user.home')->with('success', 'Step 2 details saved successfully!');
    }
}
