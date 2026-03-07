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
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Frequently</span> <span style="color: #393186;">Asked Questions</span>
                    </h2>
                </div>

                <!-- Search Box on Right Side -->
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
            <div class="row">
                <div class="col-12">
                    <div class="row">
                        <div class="faq-list">
                            <div class="accordion faq-accordion" id="faqAccordion">

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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
                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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

                                <div class="accordion-item">
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
        </div>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
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
