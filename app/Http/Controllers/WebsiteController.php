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
use App\Models\AdminAboutJitoWebsite;
use App\Models\AdminJitoStats;
use App\Models\JeapWebsite;
use App\Models\BoardOfDirectors;
use App\Models\ZoneChairmen;
use App\Mail\ContactFormMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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
        $items = AdminAboutJitoWebsite::where('status', true)
            ->orderBy('display_order')
            ->get();
        $stats = AdminJitoStats::where('status', true)
            ->orderBy('display_order')
            ->get();
        $zoneChairmen = ZoneChairmen::where('status', true)
            ->orderBy('display_order', 'asc')
            ->get();

        return view('website.aboutJito', compact('items', 'stats', 'zoneChairmen'));
    }

    /**
     * Return JITO About data as JSON (title, description, image, stats)
     */
    public function aboutJitoData()
    {
        $items = AdminAboutJitoWebsite::where('status', true)
            ->orderBy('display_order')
            ->get();
        $stats = AdminJitoStats::where('status', true)
            ->orderBy('display_order')
            ->get();

        return response()->json([
            'items' => $items,
            'stats' => $stats,
        ]);
    }
    public function aboutJeap()
    {
        $jeapItems = JeapWebsite::where('status', true)
            ->orderBy('display_order')
            ->get();
        return view('website.aboutJeap', compact('jeapItems'));
    }
    public function boardOfDirectors()
    {
        $items = BoardOfDirectors::where('status', true)
            ->orderBy('display_order', 'asc')
            ->get();
        return view('website.boardOfDirectors', compact('items'));
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
        $items = ZoneChairmen::where('status', true)
            ->orderBy('display_order', 'asc')
            ->get();
        return view('website.zoneChairmen', compact('items'));
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
        $faqs = \App\Models\AdminFaq::where('is_active', true)->orderBy('sort_order', 'asc')->get();
        return view('website.faqs', compact('faqs'));
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
        $contactItems = \App\Models\AdminContact::where('is_active', true)->orderBy('id', 'desc')->get();
        return view('website.contact', compact('contactItems'));
    }
    
    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
        ]);

        // Save to database
        ContactEnquiry::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'subject' => $request->subject,
            'message' => $request->message,
        ]);

        // Get the contact email from .env
        $contactEmail = env('CONTACT_EMAIL', 'vaishnavibgaik2003@gmail.com');

        // Send email to the contact email address
        Mail::to($contactEmail)->send(new ContactFormMail(
            $request->name,
            $request->email,
            $request->phone,
            $request->subject,
            $request->message
        ));

        return redirect()->route('contact')->with('success', 'Thank you for contacting us! We will get back to you soon.');
    }
}
