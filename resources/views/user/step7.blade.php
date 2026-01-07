 @extends('user.layout.master')
 @section('step')
     <button class="btn btn-purple me-2" style="background-color: #393185; color: white;">Step 7 of
         7</button>
 @endsection
 @section('content')
     <!-- Main Content -->
     <div class="col-lg-9 main-content">
         <div class="container-fluid">
             <div class="row">
                 <div class="col-12">
                     <form method="POST" action="{{ route('user.step7.store') }}" enctype="multipart/form-data">
                         @csrf
                         <div class="card form-card">
                             <div class="card-body">

                                 <div class="step-card">
                                     <div class="card-icon">
                                         <i class="bi bi-eye"></i>
                                     </div>
                                     <div>
                                         <h3 class="card-title">Review & Submit </h3>
                                         <p class="card-subtitle">Please read and accept the terms before submitting your
                                             review.</p>
                                     </div>
                                 </div>





                                 <div class="row">
                                     {{-- <div class="col-md-12"> --}}
                                     <div style="margin-top: 20px;padding:0 20px;">
                                         <h4 style="font-size: 16px;font-weight:600;color:#353535;">Terms and Conditions
                                         </h4>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                            1) A needy and deserving Jain student.
                                         </p>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                             2) Age between 18 and 30 years.
                                         </p>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                             3) Minimum eligibility criteria require an overall academic score of 60% [10th, 12th & Graduation (Only for Post Graduation)]
                                         </p>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                            4) Domestic students: For Undergraduate (UG) or Postgraduate (PG) courses in India.(Only UGC/AICTE/NAAC accredited courses or universities)
                                         </p>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                             5) Foreign students: For Postgraduate (PG) courses, applications only from the Universities approved by our management, top 25 globally (QS rankings) are eligible and our listed in JEAP Website.</br>For more details, visit: [Foreign University List](https://jitojeap.in/foreign/)
                                         </p>
                                         {{-- <p style="margin-bottom: 14px;color:#494C4E;">
                                             I commit to maintaining satisfactory academic performance and will provide
                                             my
                                             academic reports to JITO as and when requested.
                                         </p>
                                         <p style="margin-bottom: 14px;color:#494C4E;">
                                             I agree to participate in JITO community service activities and contribute
                                             to
                                             the Jain community as per my capabilities.
                                         </p> --}}
                                     </div>

                                     <!-- Preview Section -->
                                     <div style="margin-top: 32px;padding:0 20px;">
                                         <h4 style="font-size: 16px;font-weight:600;color:#353535;">Preview
                                         </h4>
                                         <div class="row" style="margin-top: 16px;color:#393185;">
                                             <div class="col-4 col-md-2" style="text-align: center; ">
                                                 <a href="{{ route('user.step1') }}"
                                                     style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         1
                                                     </div>
                                                     <span class="mt-4">Personal Details</span>
                                                 </a>
                                             </div>
                                             <div class="col-4 col-md-2" style="text-align: center; color:#393185;">
                                                 <a href="{{ route('user.step2') }}"
                                                     style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         2
                                                     </div>
                                                     <span>Family Details</span>
                                                 </a>
                                             </div>
                                             <div class="col-4 col-md-2" style="text-align: center; color:#393185;">
                                                 <a href="{{ route('user.step3') }}"
                                                     style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         3
                                                     </div>
                                                     <span>Education Details</span>
                                                 </a>
                                             </div>
                                             <div class="col-4 col-md-2" style="text-align: center; color:#393185;">
                                                 <a href="{{ route('user.step4') }}"
                                                     style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         4
                                                     </div>
                                                     <span>Funding Details</span>
                                                 </a>
                                             </div>
                                             <div class="col-4 col-md-2" style="text-align: center; color:#393185;">
                                                 <a href="" style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         5
                                                     </div>
                                                     <span>Guarantor Details</span>
                                                 </a>
                                             </div>
                                             <div class="col-4 col-md-2" style="text-align: center; color:#393185;">
                                                 <a href="" style="text-decoration: none; color: inherit;">
                                                     <div
                                                         style="width: 60px; height: 60px; border: 3px solid #393185; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 8px; transition: background-color 0.3s;font-size:24px;margin-bottom:20px;">
                                                         6
                                                     </div>
                                                     <span>Documents Upload</span>
                                                 </a>
                                             </div>
                                         </div>
                                     </div>

                                     <!-- Declaration Checkboxes -->
                                     <div style="margin-top: 32px;padding:0 20px;">
                                         <h4 style="font-size: 18px;font-weight:600;color:#353535;">I Hereby declare That:
                                         </h4>
                                         <div style="margin-top: 16px;">
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration1" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 The details in this form are true and correct to the best of my knowledge.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration2" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 I give my consent to my son / daughter / ward for going to for further studies.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 If my Financial Assistance Application is approved, I agree to abide by the terms and conditions of the   JITO-JEAP –Domestic/Foreign Education Financial Assistance Application.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 In case of any change in the above information, I will inform the Institution immediately in writing within three days.
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 I also undertake to keep the office bearers/Trustees informed of my correct address and that of my Parents/Guarantors and recommenders from time to time.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                  I will send my second stage documents duly completed.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 The amount of Financial Assistance will be utilized for education purpose only.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                  I /we agree that JEAP may reject our Financial Assistance application without giving any reasons thereof and that JEAP shall not be held responsible/liable in any manner whatsoever to us for rejection or any delay in notifying us of such rejection including any costs, losses, damages, or expenses or consequences caused by such rejection of financial assistance application.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 I have read all FAQs mentioned on website and accepting the same.
                                             </label>
                                             <label style="display: block; margin-bottom: 12px; font-weight: normal;">
                                                 <input type="checkbox" name="declaration3" required
                                                     style="margin-right: 8px;border-color:#393185; width:18px;height:18px;background:#988DFF1F;">
                                                 I have read all the instructions properly and agree to submit the required documents as per the policy and timelines.
                                             </label>
                                         </div>
                                     </div>

                                     <!-- Ready to Submit Card -->
                                     <div
                                         style="background-color: #FEF6E0; border-radius: 14px; padding: 24px; margin-top: 32px;border:1px solid #FBBA00;">
                                         <h5 style="color: red; margin-bottom: 12px;">Ready to Submit?</h5>
                                         <p style="color: red; margin-bottom: 15px;">
                                             Once you submit this application, you will receive a confirmation email with
                                             your application reference number. Our team will review your application and
                                             contact you within 7-10 business days.
                                         </p>
                                         <p style="color: red; margin-bottom: 0;">
                                             If you do not receive a response within 5 working days, please contact us at support.jitojeap@jito.org
                                         </p>
                                     </div>

                                 </div>
                             </div>




                             {{-- </div> --}}
                         </div>
                         <div class="d-flex justify-content-between mt-4 mb-4">
                             <button type="button" class="btn " style="background:#988DFF1F;color:gray;"><svg
                                     xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none"
                                     stroke="gray" stroke-width="2" viewBox="0 0 24 24">
                                     <path d="M15 18l-6-6 6-6" />
                                 </svg>

                                 Previous</button>
                             <button type="submit" class="btn"
                                 style="background:#F0FDF4;color:#009846;border:1px solid #009846"><i class="bi bi-check-lg"
                                     style="color: green; font-size: 24px;"></i>

                                 Submit Application

                             </button>
                         </div>
                     </form>
                 </div>
             </div>
         </div>
     </div>
 @endsection
