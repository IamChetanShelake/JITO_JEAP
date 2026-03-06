@extends('website.layout.main')
@section('content')

    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container page-wrap">
            <div class="row">
                <div class="col-12">
                    <div class="heading-line">
                        <div class="accent-bar"></div>
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
                        <div class="pill ">
                            <a href="{{ route('documentchecklist1') }}">
                                Domestic Documents(Graduation)
                            </a>
                        </div>
                        <div class="pill active">
                            <a href="{{ route('documentchecklist2') }}">
                                Domestic Documents(Post Graduation)
                            </a>
                        </div>
                        <div class="pill">
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
                                    <li>SSC Marksheet</li>
                                    <li>HSC / Diploma Marksheet</li>
                                    <li>Graduation Marksheet</li>
                                    <li>Fee Structure</li>
                                    <li>Student Main Bank account details and statement for last 6 months/ 1 year.</li>
                                    <li>Aadhaar card - Applicant</li>
                                    <li>Pancard - Applicant <span class="green-dot  align-items-center" title="verified"><i
                                                class="bi bi-arrow-down"></i></span></li>
                                    <li>Proof of Funds Arranged/ Taken/ Approved other than JITO JEAP</li>
                                    <li>Student handwritten Stating reason for choosing course and Institutes.</li>
                                    <li>Jain Sangh Certificate (Format attached)<span class="green-dot  align-items-center"
                                            title="verified"><i class="bi bi-arrow-down"></i></span></li>
                                    <li>Recommendation of JITO Member (Format attached) <span
                                            class="green-dot  align-items-center" title="verified"><i
                                                class="bi bi-arrow-down"></i></span></li>
                                    <li>Aadhar card - Father</li>
                                    <li>Pancard - Father</li>
                                </ol>
                            </div>
                        </div>

                        <div class="right-col" style="flex:1;min-width:260px">
                            <div class="doc-list">
                                <ol start="13"
                                    style="list-style-type: decimal !important; list-style-position: outside !important; margin-left: 20px; padding-left: 0;">
                                    <li>Electricity Bill Latest</li>
                                    <li>ITR Acknowledgement of Father of last 2 Years</li>
                                    <li>ITR Computation of Income along with Profit and Loss & Balance sheet of Father of
                                        last 2
                                        years</li>
                                    <li>ITR Computation of Income along with Form no.16 for Salary Income of Father of last
                                        2
                                        years</li>
                                    <li>Bank Statement of Father of Last 2 years</li>
                                    <li>Bank Statement of Mother of Last 2 years</li>
                                    <li>Aadhar card - Guarantor 1 (Name, Address, Income bracket, Mobile no., Email-id)</li>
                                    <li>Pancard - Guarantor 1</li>
                                    <li>Aadhar card - Guarantor 2 (Name, Address, Income bracket, Mobile no., Email-id)</li>
                                    <li>Pancard - Guarantor 2</li>
                                    <li>Others documents (If any achievements)</li>
                                    <li>Extra Curricular</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
@endsection
