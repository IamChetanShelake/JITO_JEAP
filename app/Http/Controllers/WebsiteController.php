<?php

namespace App\Http\Controllers;

use App\Models\KeyInstruction;
use App\Models\User;
use App\Models\Image;
use App\Models\Chapter;
use App\Models\Category;
use App\Models\Upcoming;
use App\Models\Completed;
use App\Models\PowerTeam;
use App\Models\UserBought;
use App\Helpers\AppHelpers;
use App\Models\ContactEnquiry;
use App\Models\RomChapterLeader;
use App\Models\EmpoweringDream;
use App\Models\WorkingCommittee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebsiteController extends Controller
{
    public function index()
    {
        $empoweringDreams = EmpoweringDream::where('status', true)->orderBy('order', 'asc')->get();
        $keyInstructions = KeyInstruction::where('is_active', true)->orderBy('display_order', 'asc')->get();
        $workingCommittee = WorkingCommittee::where('status', true)->orderBy('display_order', 'asc')->get();
        return view('website.home', compact('empoweringDreams', 'keyInstructions', 'workingCommittee'));
    }
    public function aboutJito()
    {
        return view('website.aboutJito');
    }
    public function aboutJeap()
    {
        return view('website.aboutJeap');
    }
    public function boardOfDirectors()
    {
        return view('website.boardOfDirectors');
    }
    public function documentchecklist()
    {
        return view('website.documentChecklist');
    }
    public function documentchecklist1()
    {
        return view('website.documentChecklist1');
    }
    public function documentchecklist2()
    {
        return view('website.documentChecklist2');
    }
    public function documentchecklist3()
    {
        return view('website.documentChecklist3');
    }
    public function gallery()
    {
        return view('website.gallery');
    }

    
    public function zoneChairmen()
    {
        return view('website.zoneChairmen');
    }
    public function testimonialSuccessStories()
    {
        return view('website.testimonialSuccessStories');
    }

    
    public function howtoapply()
    {
        return view('website.howtoapply');
    }
    public function faqs()
    {
        return view('website.faqs');
    }

    public function beDonor()
    {
        return view('website.beDonor');
    }
    public function ourDonors()
    {
        return view('website.ourDonors');
    }

    public function domestic()
    {
        return view('website.domestic');
    }
    public function foreign()
    {
        return view('website.foreign');
    }

    
    public function industrial()
    {
        return view('website.industrial');
    }
   




    
    public function contact()
    {
        return view('website.contact');
    }
    



    
}
