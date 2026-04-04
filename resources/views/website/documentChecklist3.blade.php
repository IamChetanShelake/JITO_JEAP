@extends('website.layout.main')
@section('content')
    
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container page-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="heading-line">
                        <!-- <div class="accent-bar"></div> -->
                        <div class="headline">
                            <h1><span class="yellow">DOCUMENTS</span> <span class="purple">CHECKLIST</span></h1>
                        </div>
                    </div>
                    <div class="my-3"
                        style="display: flex;justify-content:space-between; align-items: center; flex-direction: row; gap: 15px;">
                        <span
                            style="font-size: 32px;color: #5B5B5B; font-weight: 400; font-family: 'Times New Roman', Times, serif; margin: 0;">
                            Required Documents for Application
                        </span>
                    </div>

                    <div class="pills">
                        <div class="pill">
                            <a href="{{ route('documentchecklist') }}">
                                Under 1 Lakh
                            </a>
                        </div>
                        <div class="pill ">
                            <a href="{{ route('documentchecklist1') }}">
                                Domestic Documents(Graduation)
                            </a>
                        </div>
                        <div class="pill ">
                            <a href="{{ route('documentchecklist2') }}">
                                Domestic Documents(Post Graduation)
                            </a>
                        </div>
                        <div class="pill active">
                            <a href="{{ route('documentchecklist3') }}">
                                Foreign Documents (Post Graduation)
                            </a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="lists-wrap">
                        <div class="left-col" style="flex:1;min-width:260px">
                            <div class="doc-list">
                                <ol
                                    style="list-style-type: decimal !important; list-style-position: outside !important; margin-left: 20px; padding-left: 0;">
                                    <li>SSC Marksheet *</li>
                                    <li>HSC / Diploma Marksheet *</li>
                                    <li>Graduation Marksheet (Only for Post Graduation Applicant)  *</li>
                                    <li>College - Fees Structure  *</li>
                                    <li>Pancard - Applicant  *</li>
                                    <li>Aadhaar card - Applicant  *</li>
                                    <li>Jain Sangh Certificate of Applicant (If you have already then do send that Jain Sangh Certificate or take format from website in Document section and fill the same along with Sangh Stamp & Signature of Head Authority person compulsory)  *</li>
                                   
                                    <li>Recommendation of JITO Member (Take format from website in Document section and fill the same along with Jito member signature and UID number compulsory)  *</li>
                                    

                                </ol>
                            </div>
                        </div>

                        <div class="right-col" style="flex:1;min-width:260px">
                            <div class="doc-list">
                                <ol start="9"
                                    style="list-style-type: decimal !important; list-style-position: outside !important; margin-left: 20px; padding-left: 0;">
                                    <li>Recommendation of JITO Member (Take format from website in Document section and fill the same along with Jito member signature and UID number compulsory)  *</li>
                                    <li>Electricity Bill Latest  *</li>
                                    <li>Aadhar card - Father / Mother / Guardian  *</li>
                                    <li>Pancard - Father / Mother / Guardian  *</li>
                                    <li>Form no.16 for Salary Income of Father of last 6 months (If getting Salary) / Salary Slip issued by organisation  (In which Father is working) *</li>
                                    <li>Bank Statement of Father Last 1 year (If not bank statement then send Passbook copy of last 1 year)  *</li>
                                    
                                    <li>Others</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
