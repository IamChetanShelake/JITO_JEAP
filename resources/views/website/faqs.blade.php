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

            <!-- Header -->
            <div style="display: flex; align-items: center; flex-direction: row; gap: 15px; margin-bottom: 30px;">
                <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                    <span style="color: #FFD800;">Frequently</span> <span style="color: #393186;">Asked Questions</span>
                </h2>
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
                                            Answer text goes here. Provide short helpful information here about eligibility.
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
                                            Short procedural steps or a link to the application page.
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
                                            Describe any disqualifications or restrictions here.
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
                                            List the main required documents or link to the documents checklist.
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
                                            Clarify whether assistance is interest-free or on what terms.
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
                                            Short answer about collateral requirements.
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
                                            Recommended timelines and lead time information.
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
                                            Guidance on account/owner name to be used for the application.
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
                                            Typical processing times and factors that influence them.
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
                                            Details on limits/ceilings and how they are determined.
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
@endsection
