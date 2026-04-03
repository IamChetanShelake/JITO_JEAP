@extends('website.layout.main')
@section('content')
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Fonts -->
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;500;700&family=Playfair+Display:wght@600;700&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --purple: #403092;
            --accent: #ffca28;
            --muted: #6c6c6c;
            --border-yellow: rgba(255, 202, 40, 0.12);
            --border-yellow-2: rgba(255, 202, 40, 0.32);
            --plus-green: #0aa04a;
        }

        body {
            font-family: 'Poppins' !important;
            color: #333;
            background: #fff;
            padding: 32px 18px;
        }

        /* Header */
        .faq-top {
            display: flex;
            gap: 24px;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-bottom: 22px;
        }

        .faq-title {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .accent-bar {
            width: 6px;
            height: 44px;
            border-radius: 4px;
            background: linear-gradient(180deg, var(--accent), #ffd54a);
        }

        .title-text {
            font-family: "Playfair Display", serif;
            font-size: 34px;
            line-height: 1;
        }

        .title-text .accent-word {
            color: var(--accent);
            font-weight: 700;
        }

        .title-text .purple-word {
            color: var(--purple);
        }

        /* Translation Toggle Button */
        .translation-toggle {
            display: flex;
            align-items: center;
            gap: 8px;
            background: #f8f9fa;
            border-radius: 25px;
            padding: 4px;
            border: 1px solid #ddd;
        }

        .translation-btn {
            padding: 6px 16px;
            border: none;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
        }

        .translation-btn.active {
            background: #393186;
            color: #fff;
        }

        .translation-btn:not(.active) {
            background: transparent;
            color: #666;
        }

        .translation-btn:hover:not(.active) {
            background: #e9ecef;
        }

        /* Search box (right) */
        .faq-search {
            min-width: 260px;
            max-width: 420px;
            width: 40%;
        }

        .search-input {
            border-radius: 30px;
            border: 2px solid var(--purple);
            padding: 10px 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .search-input input {
            border: 0;
            outline: 0;
            width: 100%;
            font-size: 14px;
        }

        .search-input .search-icon {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            color: var(--purple);
            border: 1px solid rgba(64, 48, 146, 0.12);
        }

        /* Accordion / FAQ */
        .faq-list {
            margin-top: 12px;
        }

        .faq-accordion .accordion-item {
            border: 1px solid var(--border-yellow-2);
            border-radius: 4px;
            margin-bottom: 16px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 1), rgba(255, 255, 255, 1));
            box-shadow: none;
        }


        .faq-accordion .accordion-button {
            padding: 18px 20px;
            font-weight: 500;
            font-family: 'Poppins' !important;
            color: #444;
            background: transparent;
        }

        .faq-accordion .accordion-button:not(.collapsed) {
            color: #222;
            background: transparent;
            box-shadow: none;
        }

        /* plus sign on right */
        /* .faq-accordion .accordion-button::after {
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    width: 24px;
                    height: 24px;
                    border-radius: 4px;
                    background: var(--plus-green);
                    color: #fff;
                    font-weight: 700;
                    content: "+";
                    transform: none;
                } */


        .faq-accordion .accordion-button::after {
            display: flex;
            font-size: 40px;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            border-radius: 4px;
            background: #ffff;
            color: green;
            font-weight: 500;
            content: "+";
            transform: none;
        }

        .faq-accordion .accordion-button:not(.collapsed)::after {
            content: "−";
            color: #E31E25;
        }

        .faq-accordion .accordion-header {
            font-size: 14px;
            font-family: 'Poppins' !important;
            background: #FFFBEE4D;
        }

        /* remove default caret */
        .faq-accordion .accordion-button svg,
        .faq-accordion .accordion-button .bi {
            display: none;
        }

        /* Panel content */
        .faq-accordion .accordion-body {
            padding: 18px 20px 20px;
            color: var(--muted);
            border-top: 1px solid rgba(0, 0, 0, 0.03);
        }

        /* Responsive tweaks */
        @media (max-width: 991px) {
            .faq-top {
                gap: 12px;
            }

            .faq-search {
                width: 100%;
                max-width: 600px;
                order: 2;
            }

            .faq-title {
                order: 1;
                width: 100%;
            }

            .title-text {
                font-size: 28px;
            }

            .search-input {
                width: 100%;
            }
        }

        @media (max-width: 576px) {
            body {
                padding: 18px 12px;
            }

            .title-text {
                font-size: 22px;
            }

            .search-input {
                padding: 8px 12px;
            }

            .faq-accordion .accordion-header .accordion-button {
                padding: 12px;
                font-size: 14px;
                font-family: 'Poppins' !important;
            }

            .faq-accordion .accordion-header {
                font-size: 14px;
                font-family: 'Poppins' !important;
                background: #FFFBEE4D;
            }

            .faq-accordion .accordion-body {
                padding: 12px;
                font-size: 13px;
                font-family: 'Poppins' !important;
            }
        }
    </style>
    <section style="padding: 288px 0 80px 0px; background: #ffffff;">
        <div class="container page-wrap">

            <!-- Header and Search Row -->
            <div style="display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 20px; margin-bottom: 30px;">
                
                <!-- Heading -->
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <!-- <div style="width: 3px; height: 40px; background-color: #E31E25;"></div> -->
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Frequently</span> <span style="color: #393186;">Asked Questions</span>
                    </h2>
                </div>

                <!-- Right Side: Search + Translation Toggle -->
                <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                    <!-- Translation Toggle -->
                    <div class="translation-toggle">
                        <button class="translation-btn active" id="btn-english" onclick="setLanguage('en')">English</button>
                        <button class="translation-btn" id="btn-hindi" onclick="setLanguage('hi')">हिंदी</button>
                    </div>

                    <!-- Search Box -->
                    <div style="flex: 0 0 auto;">
                        <div style="position: relative; width: 280px;">
                            <input type="text" id="faqSearchInput" onkeyup="searchFAQs()" placeholder="Search Here..." 
                                style="width: 100%; padding: 10px 40px 10px 15px; border: 2px solid #393186; border-radius: 25px; font-size: 14px; outline: none; font-family: 'Poppins', sans-serif;">
                            <span style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); color: #393186;">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                    <circle cx="11" cy="11" r="8"></circle>
                                    <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
                                </svg>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="faq-list">
                            <div class="accordion faq-accordion" id="faqAccordion">

                                @if(isset($faqs) && count($faqs) > 0)
                                    @foreach($faqs as $index => $faq)
                                        <div class="accordion-item" data-question-en="{{ $faq->question }}" data-answer-en="{{ htmlspecialchars($faq->answer, ENT_QUOTES, 'UTF-8') }}">
                                            <h2 class="accordion-header" id="faqHeading{{ $index + 1 }}">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#faq{{ $index + 1 }}" aria-expanded="false" aria-controls="faq{{ $index + 1 }}">
                                                    {{ $index + 1 }}. {{ $faq->question }}
                                                </button>
                                            </h2>
                                            <div id="faq{{ $index + 1 }}" class="accordion-collapse collapse" aria-labelledby="faqHeading{{ $index + 1 }}"
                                                data-bs-parent="#faqAccordion">
                                                <div class="accordion-body">
                                                    {!! $faq->answer !!}
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else

                                <div class="accordion-item" data-question-en="1. Who can apply to JITO – JEAP for Financial Assistance?" data-answer-en="<p><strong>Answer:</strong> JITO – JEAP (JITO Juvenile Education Assistance Program) provides financial assistance to students from Jain families who demonstrate genuine financial need and academic potential. Students must be members of JITO (Jain International Trade Organization) or have a family background associated with the Jain community.</p><p>Eligibility criteria include:</p><ul><li>Student must be from a Jain family</li><li>Annual family income should be below the specified threshold</li><li>Student must have secured admission to a recognized educational institution</li><li>Minimum academic performance as per program guidelines</li></ul>">
                                    <h2 class="accordion-header" id="faqHeading1">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                                            1. Who can apply to JITO – JEAP for Financial Assistance?
                                        </button>
                                    </h2>
                                    <div id="faq1" class="accordion-collapse collapse" aria-labelledby="faqHeading1"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> JITO – JEAP (JITO Juvenile Education Assistance Program) provides financial assistance to students from Jain families who demonstrate genuine financial need and academic potential. Students must be members of JITO (Jain International Trade Organization) or have a family background associated with the Jain community.</p>
                                            <p>Eligibility criteria include:</p>
                                            <ul>
                                                <li>Student must be from a Jain family</li>
                                                <li>Annual family income should be below the specified threshold</li>
                                                <li>Student must have secured admission to a recognized educational institution</li>
                                                <li>Minimum academic performance as per program guidelines</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="2. How can a student apply for Financial Assistance through JITO – JEAP?" data-answer-en="<p><strong>Answer:</strong> Students can apply for financial assistance through the following steps:</p><ol><li>Visit the official JITO JEAP website</li><li>Register yourself as a new user</li><li>Fill in the online application form with accurate details</li><li>Upload all required documents</li><li>Submit the application for review</li><li>Track your application status through your dashboard</li></ol><p>For detailed guidance, visit our <a href='#'>Application Process page</a>.</p>">
                                    <h2 class="accordion-header" id="faqHeading2">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                                            2. How can a student apply for Financial Assistance through JITO – JEAP?
                                        </button>
                                    </h2>
                                    <div id="faq2" class="accordion-collapse collapse" aria-labelledby="faqHeading2"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> Students can apply for financial assistance through the following steps:</p>
                                            <ol>
                                                <li>Visit the official JITO JEAP website</li>
                                                <li>Register yourself as a new user</li>
                                                <li>Fill in the online application form with accurate details</li>
                                                <li>Upload all required documents</li>
                                                <li>Submit the application for review</li>
                                                <li>Track your application status through your dashboard</li>
                                            </ol>
                                            <p>For detailed guidance, visit our <a href="#">Application Process page</a>.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="3. Which students are not eligible to take Financial Assistance from JITO – JEAP?" data-answer-en="<p><strong>Answer:</strong> The following students are NOT eligible for JITO – JEAP Financial Assistance:</p><ul><li>Students from non-Jain families</li><li>Students with family annual income above the prescribed limit</li><li>Students already receiving full financial support from other sources</li><li>Students with unsatisfactory academic record</li><li>Applications with incomplete documentation</li><li>Students who have previously defaulted on JEAP loans</li></ul>">
                                    <h2 class="accordion-header" id="faqHeading3">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                                            3. Which students are not eligible to take Financial Assistance from JITO –
                                            JEAP?
                                        </button>
                                    </h2>
                                    <div id="faq3" class="accordion-collapse collapse" aria-labelledby="faqHeading3"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> The following students are NOT eligible for JITO – JEAP Financial Assistance:</p>
                                            <ul>
                                                <li>Students from non-Jain families</li>
                                                <li>Students with family annual income above the prescribed limit</li>
                                                <li>Students already receiving full financial support from other sources</li>
                                                <li>Students with unsatisfactory academic record</li>
                                                <li>Applications with incomplete documentation</li>
                                                <li>Students who have previously defaulted on JEAP loans</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>

                                <!-- repeat / add more items as needed (10 items in your screenshot) -->
                                <div class="accordion-item" data-question-en="4. What documents do students need to provide?" data-answer-en="<p><strong>Answer:</strong> Students need to provide the following documents:</p><ul><li>Passport size photographs</li><li>Aadhar card / Identity proof</li><li>Income certificate (latest)</li><li>Previous year marksheets</li><li>Admission letter from the educational institution</li><li>Fee structure document</li><li>Bank account details</li><li>JITO membership certificate (if applicable)</li><li>Caste certificate (if applicable)</li></ul><p>All documents must be self-attested and uploaded in PDF/JPG format.</p>">
                                    <h2 class="accordion-header" id="faqHeading4">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                                            4. What documents do students need to provide?
                                        </button>
                                    </h2>
                                    <div id="faq4" class="accordion-collapse collapse" aria-labelledby="faqHeading4"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> Students need to provide the following documents:</p>
                                            <ul>
                                                <li>Passport size photographs</li>
                                                <li>Aadhar card / Identity proof</li>
                                                <li>Income certificate (latest)</li>
                                                <li>Previous year marksheets</li>
                                                <li>Admission letter from the educational institution</li>
                                                <li>Fee structure document</li>
                                                <li>Bank account details</li>
                                                <li>JITO membership certificate (if applicable)</li>
                                                <li>Caste certificate (if applicable)</li>
                                            </ul>
                                            <p>All documents must be self-attested and uploaded in PDF/JPG format.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="5. Is JITO – JEAP Financial Assistance interest-free?" data-answer-en="<p><strong>Answer:</strong> Yes, JITO – JEAP provides <strong>interest-free financial assistance</strong> to eligible students. This is one of the key benefits of the program aimed at supporting Jain students in pursuing their educational dreams without the burden of interest-based loans.</p><p>The assistance is provided as a grant or interest-free loan based on the student's need and the program's terms.</p>">
                                    <h2 class="accordion-header" id="faqHeading5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq5" aria-expanded="false" aria-controls="faq5">
                                            5. Is JITO – JEAP Financial Assistance interest-free?
                                        </button>
                                    </h2>
                                    <div id="faq5" class="accordion-collapse collapse" aria-labelledby="faqHeading5"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> Yes, JITO – JEAP provides <strong>interest-free financial assistance</strong> to eligible students. This is one of the key benefits of the program aimed at supporting Jain students in pursuing their educational dreams without the burden of interest-based loans.</p>
                                            <p>The assistance is provided as a grant or interest-free loan based on the student's need and the program's terms.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="6. Do students have to provide collateral security for financial assistance from JITO – JEAP?" data-question-hi="6. क्या छात्रों को JITO - JEAP से वित्तीय सहायता के लिए संपार्श्विक सुरक्षा प्रदान करनी होगी?" data-answer-en="<p><strong>Answer:</strong> No, students <strong>do not need to provide collateral security</strong> for financial assistance from JITO – JEAP. The program is designed to help students based on their academic merit and financial need without requiring any physical collateral or security deposits.</p><p>However, a guarantor may be required in certain cases for verification purposes.</p>" data-answer-hi="<p><strong>उत्तर:</strong> नहीं, छात्रों को JITO - JEAP से वित्तीय सहायता के लिए <strong>संपार्श्विक सुरक्षा प्रदान करने की आवश्यकता नहीं है</strong>। कार्यक्रम को छात्रों को उनकी शैक्षणिक योग्यता और वित्तीय आवश�्कता के आधार पर मदद करने के लिए डिज़ाइन किया गया है, बिना किसी भौतिक संपार्श्विक या सुरक्षा जमा की आवश्यकता के।</p><p>हालांकि, सत्यापन उद्देश्यों के लिए कुछ मामलों में गारंटर की आवश्यकता हो सकती है।</p>">
                                    <h2 class="accordion-header" id="faqHeading6">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#faq6" aria-expanded="false" aria-controls="faq6">
                                            6. Do students have to provide collateral security for financial assistance from
                                            JITO – JEAP?
                                        </button>
                                    </h2>
                                    <div id="faq6" class="accordion-collapse collapse" aria-labelledby="faqHeading6"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> No, students <strong>do not need to provide collateral security</strong> for financial assistance from JITO – JEAP. The program is designed to help students based on their academic merit and financial need without requiring any physical collateral or security deposits.</p>
                                            <p>However, a guarantor may be required in certain cases for verification purposes.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="7. When should I apply for JEAP to ensure timely processing?" data-answer-en="<p><strong>Answer:</strong> We recommend applying for JEAP at least <strong>2-3 months before</strong> your academic session begins. This allows sufficient time for:</p><ul><li>Document verification</li><li>Application review process</li><li>Approval and disbursement</li></ul><p>Early applications are given priority, so it's best to apply as soon as you receive your admission confirmation.</p>">
                                    <h2 class="accordion-header" id="faqHeading7">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq7" aria-expanded="false"
                                            aria-controls="faq7">
                                            7. When should I apply for JEAP to ensure timely processing?
                                        </button>
                                    </h2>
                                    <div id="faq7" class="accordion-collapse collapse" aria-labelledby="faqHeading7"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> We recommend applying for JEAP at least <strong>2-3 months before</strong> your academic session begins. This allows sufficient time for:</p>
                                            <ul>
                                                <li>Document verification</li>
                                                <li>Application review process</li>
                                                <li>Approval and disbursement</li>
                                            </ul>
                                            <p>Early applications are given priority, so it's best to apply as soon as you receive your admission confirmation.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="8. On whose name should the application be created?" data-answer-en="<p><strong>Answer:</strong> The application should be created in the <strong>name of the student</strong> who will be receiving the financial assistance. The student's name on the application must match exactly with their name in academic records and bank accounts.</p><p>Parents or guardians can assist in filling the application, but the primary applicant must be the student themselves.</p>">
                                    <h2 class="accordion-header" id="faqHeading8">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq8" aria-expanded="false"
                                            aria-controls="faq8">
                                            8. On whose name should the application be created?
                                        </button>
                                    </h2>
                                    <div id="faq8" class="accordion-collapse collapse" aria-labelledby="faqHeading8"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> The application should be created in the <strong>name of the student</strong> who will be receiving the financial assistance. The student's name on the application must match exactly with their name in academic records and bank accounts.</p>
                                            <p>Parents or guardians can assist in filling the application, but the primary applicant must be the student themselves.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="9. How long does it take for a JEAP application to be processed and sanctioned?" data-answer-en="<p><strong>Answer:</strong> The processing time for a JEAP application typically ranges from <strong>4 to 8 weeks</strong> from the date of submission. This includes:</p><ul><li>Document verification: 1-2 weeks</li><li>Initial review: 1 week</li><li>Committee approval: 1-2 weeks</li><li>Final disbursement: 1-2 weeks</li></ul><p>Time may vary based on the completeness of application and volume of applications received.</p>">
                                    <h2 class="accordion-header" id="faqHeading9">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq9" aria-expanded="false"
                                            aria-controls="faq9">
                                            9. How long does it take for a JEAP application to be processed and sanctioned?
                                        </button>
                                    </h2>
                                    <div id="faq9" class="accordion-collapse collapse" aria-labelledby="faqHeading9"
                                        data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> The processing time for a JEAP application typically ranges from <strong>4 to 8 weeks</strong> from the date of submission. This includes:</p>
                                            <ul>
                                                <li>Document verification: 1-2 weeks</li>
                                                <li>Initial review: 1 week</li>
                                                <li>Committee approval: 1-2 weeks</li>
                                                <li>Final disbursement: 1-2 weeks</li>
                                            </ul>
                                            <p>Time may vary based on the completeness of application and volume of applications received.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="accordion-item" data-question-en="10. How much maximum financial assistance will be provided by JEAP?" data-answer-en="<p><strong>Answer:</strong> The maximum financial assistance provided by JEAP varies based on several factors:</p><ul><li>For undergraduate courses: Up to ₹2,00,000 per year</li><li>For postgraduate courses: Up to ₹3,00,000 per year</li><li>For professional courses (Medical, Engineering, etc.): Up to ₹5,00,000 per year</li><li>For overseas studies: Up to ₹10,00,000 (case to case basis)</li></ul><p>The actual assistance amount is determined based on merit, need, and available funds.</p>">
                                    <h2 class="accordion-header" id="faqHeading10">
                                        <button class="accordion-button collapsed" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#faq10" aria-expanded="false"
                                            aria-controls="faq10">
                                            10. How much maximum financial assistance will be provided by JEAP?
                                        </button>
                                    </h2>
                                    <div id="faq10" class="accordion-collapse collapse"
                                        aria-labelledby="faqHeading10" data-bs-parent="#faqAccordion">
                                        <div class="accordion-body">
                                            <p><strong>Answer:</strong> The maximum financial assistance provided by JEAP varies based on several factors:</p>
                                            <ul>
                                                <li>For undergraduate courses: Up to ₹2,00,000 per year</li>
                                                <li>For postgraduate courses: Up to ₹3,00,000 per year</li>
                                                <li>For professional courses (Medical, Engineering, etc.): Up to ₹5,00,000 per year</li>
                                                <li>For overseas studies: Up to ₹10,00,000 (case to case basis)</li>
                                            </ul>
                                            <p>The actual assistance amount is determined based on merit, need, and available funds.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                                @endif
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Translation cache storage - separate caches for questions and answers
        let translationCache = {
            questions: {},
            answers: {}
        };
        
        // Maximum retries for failed translations
        const MAX_RETRIES = 3;
        
        // Load cache from localStorage if available
        try {
            const cached = localStorage.getItem('faqTranslationCache');
            if (cached) {
                translationCache = JSON.parse(cached);
            }
        } catch (e) {
            console.log('LocalStorage not available');
        }

        // Save cache to localStorage
        function saveTranslationCache() {
            try {
                localStorage.setItem('faqTranslationCache', JSON.stringify(translationCache));
            } catch (e) {
                console.log('Could not save to localStorage');
            }
        }

        // Translate text using MyMemory API with retry logic
        // contentType: 'question' or 'answer'
        async function translateText(text, sourceLang, targetLang, contentType = 'question') {
            // Create a cache key - use longer text for better uniqueness
            const cacheKey = text.substring(0, 100);
            
            // Check appropriate cache based on content type
            const cacheToUse = contentType === 'answer' ? translationCache.answers : translationCache.questions;
            
            if (targetLang === 'hi') {
                if (cacheToUse[cacheKey]) {
                    return cacheToUse[cacheKey];
                }
            }
            
            // For HTML content, extract text, translate, then re-apply
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = text;
            const plainText = tempDiv.textContent || tempDiv.innerText || text;
            
            // If text is very short or just HTML tags, return as is
            if (plainText.trim().length < 2) {
                return text;
            }

            let lastError = null;
            
            // Retry logic
            for (let retry = 0; retry < MAX_RETRIES; retry++) {
                try {
                    // Add delay between retries to avoid rate limiting
                    if (retry > 0) {
                        await new Promise(resolve => setTimeout(resolve, 1000 * retry));
                    }
                    
                    const encodedText = encodeURIComponent(plainText);
                    const langPair = `${sourceLang}|${targetLang}`;
                    const url = `https://api.mymemory.translated.net/get?q=${encodedText}&langpair=${langPair}`;
                    
                    const response = await fetch(url);
                    const data = await response.json();
                    
                    if (data.responseStatus === 200 && data.responseData) {
                        const translatedText = data.responseData.translatedText;
                        
                        // For HTML content, just return the plain translated text
                        // because replacing HTML can break the structure
                        let result;
                        if (text !== plainText) {
                            // Create new HTML with translated content
                            const resultDiv = document.createElement('div');
                            resultDiv.innerHTML = text;
                            resultDiv.textContent = translatedText;
                            result = resultDiv.innerHTML;
                        } else {
                            result = translatedText;
                        }
                        
                        // Cache the result in appropriate cache
                        if (targetLang === 'hi') {
                            cacheToUse[cacheKey] = result;
                            saveTranslationCache();
                        }
                        
                        return result;
                    } else {
                        lastError = data.responseDetails || 'Translation failed';
                    }
                } catch (error) {
                    lastError = error.message;
                    console.error('Translation attempt ' + (retry + 1) + ' failed:', error);
                }
            }
            
            console.error('All translation attempts failed:', lastError);
            return null;
        }

        // Show loading indicator
        function showTranslationLoading(isLoading) {
            const btnHindi = document.getElementById('btn-hindi');
            if (isLoading) {
                btnHindi.textContent = 'Translating...';
                btnHindi.disabled = true;
            } else {
                btnHindi.textContent = 'हिंदी';
                btnHindi.disabled = false;
            }
        }

        // Show error message
        function showTranslationError(message) {
            alert('Translation Error: ' + message + '. Please try again.');
        }

        // Main translation function - process items sequentially
        async function setLanguage(lang) {
            var btnEnglish = document.getElementById('btn-english');
            var btnHindi = document.getElementById('btn-hindi');
            var searchInput = document.getElementById('faqSearchInput');

            // If switching to Hindi, check if we already have translations
            if (lang === 'hi' && btnHindi.classList.contains('active')) {
                return; // Already in Hindi mode
            }

            // If switching to English, restore immediately
            if (lang === 'en') {
                btnHindi.classList.remove('active');
                btnEnglish.classList.add('active');
                searchInput.placeholder = 'Search Here...';
                
                restoreEnglishContent();
                return;
            }

            // Switching to Hindi - need to translate
            btnEnglish.classList.remove('active');
            btnHindi.classList.add('active');
            searchInput.placeholder = 'यहां खोजें...';

            // Store current open state
            var faqItems = document.querySelectorAll('.accordion-item');
            var openAccordions = [];
            
            faqItems.forEach(function(item, index) {
                var collapseEl = item.querySelector('.accordion-collapse');
                if (collapseEl && collapseEl.classList.contains('show')) {
                    openAccordions.push(index);
                }
            });

            showTranslationLoading(true);

            try {
                // Translate each FAQ item sequentially to avoid rate limiting
                for (let i = 0; i < faqItems.length; i++) {
                    var item = faqItems[i];
                    var questionEn = item.getAttribute('data-question-en');
                    var answerEn = item.getAttribute('data-answer-en');
                    
                    if (!questionEn || !answerEn) continue;
                    
                    // Translate question and answer with proper content type
                    var questionResult = await translateText(questionEn, 'en', 'hi', 'question');
                    var answerResult = await translateText(answerEn, 'en', 'hi', 'answer');
                    
                    // Apply translations immediately
                    var questionBtn = item.querySelector('.accordion-button');
                    var answerDiv = item.querySelector('.accordion-body');
                    
                    if (questionBtn && questionResult) {
                        questionBtn.textContent = questionResult;
                    }
                    if (answerDiv && answerResult) {
                        answerDiv.innerHTML = answerResult;
                    }
                    
                    // Small delay between each item to avoid rate limiting
                    if (i < faqItems.length - 1) {
                        await new Promise(resolve => setTimeout(resolve, 300));
                    }
                }

                // Restore open state after translation
                setTimeout(function() {
                    openAccordions.forEach(function(index) {
                        if (faqItems[index]) {
                            var collapseEl = faqItems[index].querySelector('.accordion-collapse');
                            var buttonEl = faqItems[index].querySelector('.accordion-button');
                            if (collapseEl && !collapseEl.classList.contains('show')) {
                                collapseEl.classList.add('show');
                                if (buttonEl) {
                                    buttonEl.classList.remove('collapsed');
                                    buttonEl.setAttribute('aria-expanded', 'true');
                                }
                            }
                        }
                    });
                }, 100);

                // Re-run search if there's a search term
                if (searchInput && searchInput.value) {
                    searchFAQs();
                }

            } catch (error) {
                console.error('Translation failed:', error);
                showTranslationError('Failed to translate content');
                // Revert to English on error
                btnHindi.classList.remove('active');
                btnEnglish.classList.add('active');
                searchInput.placeholder = 'Search Here...';
                restoreEnglishContent();
            } finally {
                showTranslationLoading(false);
            }
        }

        // Restore English content
        function restoreEnglishContent() {
            var faqItems = document.querySelectorAll('.accordion-item');
            
            faqItems.forEach(function(item) {
                var questionBtn = item.querySelector('.accordion-button');
                var answerDiv = item.querySelector('.accordion-body');
                
                var questionEn = item.getAttribute('data-question-en');
                var answerEn = item.getAttribute('data-answer-en');

                if (questionBtn && questionEn) {
                    questionBtn.textContent = questionEn;
                }
                if (answerDiv && answerEn) {
                    answerDiv.innerHTML = answerEn;
                }
            });

            // Re-run search if there's a search term
            var searchInput = document.getElementById('faqSearchInput');
            if (searchInput && searchInput.value) {
                searchFAQs();
            }
        }

        function searchFAQs() {
            var input = document.getElementById('faqSearchInput');
            var filter = input.value.toLowerCase();
            var faqItems = document.querySelectorAll('.accordion-item');
            
            faqItems.forEach(function(item) {
                var question = item.querySelector('.accordion-button');
                var answer = item.querySelector('.accordion-body');
                var questionText = question ? question.textContent || question.innerText : '';
                var answerText = answer ? answer.textContent || answer.innerText : '';
                
                if (questionText.toLowerCase().indexOf(filter) > -1 || answerText.toLowerCase().indexOf(filter) > -1) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
@endsection
