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
use App\Models\EmpoweringFutureWebsite;
use App\Models\WorkingCommittee;
use App\Models\AchievementImpact;
use App\Models\PhotoGallery;
use App\Models\OurTestimonial;
use App\Models\SuccessStory;
use App\Models\UniversityWebsite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class WebsiteController extends Controller
{
    public function index()
    {
        $empoweringDreams = EmpoweringDream::on('admin_panel')->where('status', true)->orderBy('order', 'asc')->get();
        $keyInstructions = KeyInstruction::on('admin_panel')->where('is_active', true)->orderBy('display_order', 'asc')->get();
        $workingCommittee = WorkingCommittee::on('admin_panel')->where('status', true)->orderBy('display_order', 'asc')->get();
        $empoweringFutureWebsite = EmpoweringFutureWebsite::on('admin_panel')->where('status', true)->orderBy('order', 'asc')->get();
        $achievementImpacts = AchievementImpact::on('admin_panel')->where('status', true)->orderBy('order', 'asc')->get();
        $photoGalleries = PhotoGallery::on('admin_panel')->where('status', true)->orderBy('order', 'asc')->get();
        $testimonials = OurTestimonial::on('admin_panel')->where('is_active', true)->orderBy('display_order', 'asc')->get();
        $successStories = SuccessStory::on('admin_panel')->where('is_active', true)->orderBy('display_order', 'asc')->get();
        return view('website.home', compact('empoweringDreams', 'keyInstructions', 'workingCommittee', 'empoweringFutureWebsite', 'achievementImpacts', 'photoGalleries', 'testimonials', 'successStories'));
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
        $photoGalleries = PhotoGallery::on('admin_panel')->where('status', true)->orderBy('order', 'asc')->get();
        return view('website.gallery', compact('photoGalleries'));
    }

    
    public function zoneChairmen()
    {
        return view('website.zoneChairmen');
    }
    public function testimonialSuccessStories()
    {
        $testimonials = OurTestimonial::on('admin_panel')->where('is_active', true)->orderBy('display_order', 'asc')->get();
        $successStories = SuccessStory::on('admin_panel')->where('is_active', true)->orderBy('display_order', 'asc')->get();
        return view('website.testimonialSuccessStories', compact('testimonials', 'successStories'));
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
        $universities = UniversityWebsite::where('university_type', 'domestic')
            ->where('status', true)
            ->orderBy('university_name', 'asc')
            ->get();
        return view('website.domestic', compact('universities'));
    }
    public function foreign()
    {
        $universities = UniversityWebsite::where('university_type', 'foreign')
            ->where('status', true)
            ->orderBy('university_name', 'asc')
            ->get();
        return view('website.foreign', compact('universities'));
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
