<!DOCTYPE html>
<html class="wide" lang="en">

<head>
    <title>Jito Rom Zone</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="{{ asset('website/images/BNI_Logo.png') }}" type="image/x-icon">
    <link rel="stylesheet" type="text/css"
        href="https://fonts.googleapis.com/css?family=Barlow%7CBarlow+Condensed:300,400,500,600,700,900">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="stylesheet" href="{{ asset('website/css/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/fonts.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font/css/materialdesignicons.min.css" rel="stylesheet">






</head>


<body>
    <div style="display: flex; justify-content: space-between; align-items: center; padding: 20px 40px; background-color: white; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">

  <!-- Left: Logo -->
  <div style="display: flex; align-items: center;">
    <img src="{{ asset('website/images/ie8-panel/ROM ZONE LOGO_C2C 1.png') }}" alt="ROM ZONE Logo" style="height: 60px; margin-right: 10px;">
    <div style="font-size: 24px; font-weight: bold; color: green; letter-spacing: 1px;">ROM ZONE</div>
  </div>

  <!-- Center: Navigation Links -->
  <div style="display: flex; gap: 20px; align-items: center; font-family: Arial, sans-serif; font-size: 16px; font-weight: 400;">
    <a href="#" style="text-decoration: none; color: #333;">HOME</a>
    <span style="color: #999;">|</span>
    <a href="#" style="text-decoration: none; color: #333;">EVENT AGENDA</a>
    <span style="color: #999;">|</span>
    <a href="#" style="text-decoration: none; color: #333;">ROM DIRECTORY</a>
    <span style="color: #999;">|</span>
    <a href="#" style="text-decoration: none; color: #333;">CHAPTERS</a>
    <span style="color: #999;">|</span>
    <a href="#" style="text-decoration: none; color: #333;">CONTACTS</a>
  </div>

  <!-- Right: Login/Register Buttons -->
  <div style="display: flex; gap: 15px;">
    <a href="{{ route('login') }}" style=" border: 1px solid #888; padding: 6px 20px; border-radius: 6px; font-weight: 500; text-decoration: none; color: #333;">Login</a>
    <a href="{{ route('register') }}" style="background-color: #008c44; padding: 6px 20px; border-radius: 6px; font-weight: 500; text-decoration: none; color: white; box-shadow: 2px 2px 6px rgba(0,0,0,0.2);">REGISTER</a>
  </div>

</div>



<section >
    <!-- Image -->
    <div style="position: relative;margin-top:200px; ">
        <img src="{{ asset('website/images/ie8-panel/jito_team.png') }}" alt="JITO Team"
            style="width: 100%; height: auto; display: block;" />
    </div>

    <!-- Box Container -->


    <div id="cardContainer"
        style="position: absolute; bottom: -150px; left: 50%; transform: translateX(-50%); display: flex; justify-content: center; gap: 100px; z-index: 10; flex-wrap: nowrap; width: auto;">

        <!-- Card 1 -->
        <a href="{{ route('upcoming.event') }}" style="text-decoration: none;">
            <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
                onmouseover="this.style.backgroundColor='#393186'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
                onmouseout="this.style.backgroundColor='#fff'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">

                <div class="material-symbols-rounded icon" style="font-size: 32px; color: #000;">event_upcoming</div>
                <div class="label" style="font-weight: bold; font-size: 16px; color: #000;">UPCOMING EVENTS</div>
            </div>
        </a>


        <!-- Card 2 -->
        <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
            onmouseover="this.style.backgroundColor='#009746'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
            onmouseout="this.style.backgroundColor='#fff'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
            <span class="material-symbols-rounded icon" style="font-size: 32px; color: #000;">event_available</span>
            <div class="label" style="font-weight: bold; font-size: 16px; color: #000;">COMPLETED EVENTS</div>
        </div>

        <!-- Card 3 -->
        <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
            onmouseover="this.style.backgroundColor='#FFD800'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
            onmouseout="this.style.backgroundColor='#fff'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
            <i class="ri-user-voice-fill icon" style="font-size: 32px; color: #000;"></i>
            <div class="label" style="font-weight: bold; font-size: 16px; color: #000;">VOICE OF JITO</div>
        </div>

        <!-- Card 4 -->
        <div style="background-color: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 8px 20px rgba(0,0,0,0.2); width: 200px; transition: 0.3s ease; cursor: pointer; text-align: center;"
            onmouseover="this.style.backgroundColor='#E31E25'; this.querySelector('.icon').style.color='#fff'; this.querySelector('.label').style.color='#fff';"
            onmouseout="this.style.backgroundColor='#fff'; this.querySelector('.icon').style.color='#000'; this.querySelector('.label').style.color='#000';">
            <i class="mdi mdi-eye icon" style="font-size: 32px; color: #000;"></i>
            <div class="label" style="font-weight: bold; font-size: 16px; color: #000;">JITO AT GLANCE</div>
        </div>
        </div>

        <script>
        function updateCardLayout() {
            const container = document.getElementById('cardContainer');
            if (window.innerWidth < 768) {
            container.style.position = 'static';
            container.style.transform = 'none';
            container.style.flexDirection = 'column';
            container.style.alignItems = 'center';
            container.style.gap = '20px';
            } else {
            container.style.position = 'absolute';
            container.style.bottom = '-150px';
            container.style.left = '50%';
            container.style.transform = 'translateX(-50%)';
            container.style.flexDirection = 'row';
            container.style.gap = '100px';
            }
        }

        window.addEventListener('resize', updateCardLayout);
        window.addEventListener('load', updateCardLayout);
        </script>
    </div>



</section>




<!-- Responsive CSS -->
<style>
    @media (max-width: 768px) {
        .card-container {
            flex-wrap: wrap !important;
        }
    }
</style>





<style>
    @media (max-width: 768px) {
        /* Center image container on mobile */
        .about-img-container {
            display: flex !important;
            justify-content: center !important;
        }

        .about-img-container img {
            margin: 0 auto !important;
            display: block !important;
            width: 100% !important;
            max-width: 300px !important;
            transform: none !important;
        }

        /* Reduce gap on smaller screens */
        .text-image-wrapper {
            gap: 30px !important;
        }
    }
</style>

<section style="padding: 60px 0; background: #ffffff;">
    <div class="container" style="display: flex; flex-direction: column; gap: 30px;">

        <!-- About Us Section -->
        <div class="text-image-wrapper"
            style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 75px;">

            <!-- Text -->
            <div style="flex: 1 1 50%; max-width: 700px;">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2
                        style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">About</span> <span style="color: #393186;">Us</span>
                    </h2>
                </div>
                <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #5B5B5B;">
                    Jain International Trade Organisation (JITO) is a global body that unites a vibrant community of Jain
                    industrialists, entrepreneurs, business leaders, and professionals. With a strong foundation in Jain
                    values, JITO serves as a collaborative platform to encourage ethical business practices,
                    entrepreneurship, and inclusive economic growth.
                    <br><br>
                    Committed to the principles of unity, integrity, and service, JITO envisions a future where the Jain
                    community leads with purpose and responsibility. Through its various initiatives in education,
                    mentorship, trade facilitation, and community welfare, JITO supports the development of future leaders
                    and changemakers.
                </p>
            </div>

            <!-- Image -->
            <div class="about-img-container" style="position: relative; flex: 1 1 45%; max-width: 500px;">
                <div
                    style="background-color: #FFD800; width: 80%; height: 100%; position: absolute; top: -20px; right: 15px; z-index: 1; border-radius: 10px;">
                </div>
                <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}"
                    alt="About Us Image"
                    style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">
            </div>
        </div>

        <!-- Vision & Mission Section -->
        <div class="text-image-wrapper"
            style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 75px;">

            <!-- Text -->
            <div style="flex: 1 1 50%; max-width: 700px;">
                <div style="display: flex; align-items: center; flex-direction: row; gap: 15px;">
                    <div style="width: 3px; height: 40px; background-color: #E31E25;"></div>
                    <h2
                        style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
                        <span style="color: #FFD800;">Our</span> <span style="color: #393186;">VISSION &
                            MISSION</span>
                    </h2>
                </div>
                <p style="font-size: 16px; line-height: 1.6; margin-top: 20px; font-family: Arial; color: #5B5B5B;">
                    To become a world-class organization that not only drives economic prosperity but also serves as a
                    catalyst for social transformation. JITO envisions a future where Jain values inspire ethical
                    leadership, compassion, and collective growth.
                    <br><br>
                    Our ultimate goal is to help build a world that is free from violence, poverty, and disease—a world
                    where humanity thrives with dignity, peace, and purpose.
                    <br><br>
                    Together, we aspire to create a legacy of purpose-driven progress that benefits both community and
                    humanity.
                </p>
            </div>

            <!-- Image -->
            <div class="about-img-container" style="position: relative; flex: 1 1 45%; max-width: 500px;">
                <div
                    style="background-color: #393186; width: 80%; height: 100%; position: absolute; top: -20px; right: 15px; z-index: 1; border-radius: 10px;">
                </div>
                <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}"
                    alt="Vision Image"
                    style="width: 80%; border-radius: 10px; position: relative; z-index: 2; display: block; margin: auto; transform: translateX(10px);">
            </div>
        </div>

    </div>
</section>





<section
style="margin: 0; font-family: 'Segoe UI', sans-serif; display: flex; flex-direction: row; flex-wrap: wrap; gap: 20px; padding: 20px; box-sizing: border-box; height: auto;">

<!-- Left Side: ROM CHAPTERS -->
<div class="rom-chapters"
    style="flex: 1; min-width: 300px; background: linear-gradient(to right, #FFD700 30%, #2F2477 30%); display: flex; justify-content: center; align-items: center; border-radius: 20px;">
    <div style="width: 90%; border-radius: 20px; padding: 40px 20px; box-sizing: border-box; color: white;">
        <h1
            style="border-left: 4px solid white; padding-left: 10px; font-weight: bold; font-size: 28px; font-family: Times New Roman; color: white;">
            ROM CHAPTERS</h1>

        <!-- Search box -->
        <div
            style="margin: 20px 0; background-color: white; border-radius: 25px; padding: 8px 16px; display: flex; align-items: center;">
            🔍
            <input type="text" id="search" placeholder="Search here"
                style="border: none; outline: none; margin-left: 10px; font-size: 16px; width: 100%;" />
        </div>

        <!-- Scrollable Chapter List -->
        <div id="chapterList"
            style="max-height: 400px; overflow-y: auto; background-color: white; border-radius: 20px; padding: 10px; font-family: Arial; color: #5B5B5B;">
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Ahemednagar</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Akola</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Aurangabad</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Beed</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Chinchwad - Pimpari</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Dhule</div>
            <div style="margin: 10px 0; padding: 10px; background-color: #E6E6E6; border-radius: 20px; text-align: center;">
                Ichalkaranji</div>
        </div>
    </div>
</div>

<!-- Right Side: PROJECTS -->
<div class="projects"
    style="flex: 2; min-width: 300px; background-color: #2F2477; color: white; padding: 40px 20px; display: flex; flex-direction: column; justify-content: flex-start; border-radius: 20px;">
    <h1
        style="border-left: 4px solid white; padding-left: 10px; font-weight: bold; font-size: 28px; font-family: Times New Roman; color: white;  ">
        PROJECTS</h1>

    <div
        style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 30px; font-size: 16px;">
        <div class="project-item">💡 JITO Incubation & Innovation Foundation</div>
        <div class="project-item">💼 JITO Jobs & Internships</div>
        <div class="project-item">💗 JITO Matrimony</div>
        <div class="project-item">💬 JITO Professional Forum</div>
        <div class="project-item">🎓 JITO Administrative Training Foundation</div>
        <div class="project-item">📦 JITO Business Network</div>
        <div class="project-item">🧘‍♂️ JITO Shraman Arogyam</div>
        <div class="project-item">⚾ JITO Sports</div>
        <div class="project-item">🎯 JITO Seva & Minority</div>
        <div class="project-item">💡 JITO Center For Excellence</div>
        <div class="project-item">📘 JITO Jeap</div>
        <div class="project-item">🌍 JITO International</div>
        <div class="project-item">🖥️ JITO IT</div>
        <div class="project-item">📺 JITO Public Relation & Social Media</div>
        <div class="project-item">🧠 JITO Talent</div>
    </div>

    <!-- JavaScript for Search Filter -->
    <script>
        const searchInput = document.getElementById('search');
        const chapterList = document.getElementById('chapterList');
        const chapters = chapterList.querySelectorAll('div');

        searchInput.addEventListener('input', function () {
            const filter = this.value.toLowerCase();
            chapters.forEach(chapter => {
                const text = chapter.textContent.toLowerCase();
                chapter.style.display = text.includes(filter) ? 'block' : 'none';
            });
        });
    </script>
</div>
</section>

<!-- Mobile Responsive Styles -->
<style>
@media (max-width: 768px) {
    section {
        flex-direction: column !important;
    }

    h1 {
        font-size: 24px !important;
    }

    .rom-chapters,
    .projects {
        width: 100% !important;
        flex: none !important;
        padding: 20px !important;
    }

    .project-item {
        font-size: 14px !important;
    }
}
</style>





    <section style="padding: 40px; font-family: Arial, sans-serif; background: #fff; overflow: hidden;">
        <div  style="text-align: center;">
          <h2 style="font-size: 36px; font-weight: bold; font-family: 'Times New Roman', Times, serif; margin: 0;">
            <span style="color: #FFD800;">Our</span> <span style="color: #393186;">Teams</span>
          </h2>
        </div>
        <div class="row">
            <!-- Slider Wrapper -->
            <div class="slider" style="margin: 30px auto 0 auto; position: relative; width: 1225px; overflow: hidden; text-align: center;">
                <div class="slider-track" style="display: flex; transition: transform 0.8s ease; gap: 30px;">
                    <!-- Each card is 220px + 30px right margin = 250px total width -->
                    <!-- Showing 5 cards at once => 5 x 220px + 4 x 30px gap = 1150px container -->

                    <!-- Card Start (Repeat this block for each team member) -->
                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                    <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                    <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                    </div>
                    <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                    <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>

                    <div class="card" style="min-width: 220px; background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); text-align: center; padding-bottom: 20px;">
                        <img src="{{ asset('website/images/ie8-panel/WhatsApp Image 2025-04-04 at 15.13.07_23e8a8d5 (1).png') }}" alt="Saurav Parakh" style="width: 100%; height: 220px; border-top-left-radius: 15px; border-top-right-radius: 15px; object-fit: cover;">
                        <div style="margin-top: -25px; margin-bottom: 10px;">
                        <img src="https://img.icons8.com/ios-filled/50/6b46c1/conference-call.png" style="width: 50px; background: #f2f0ff; border-radius: 50%; padding: 10px;" />
                        </div>
                        <h3 style="font-size: 14px; font-weight: bold; color: #333; margin-bottom: 5px;">ZONE CONVENOR</h3>
                        <p style="font-size: 14px; color: #555;">Saurav Parakh</p>
                    </div>
                    <!-- Repeat card blocks as needed... -->
                </div>
            </div>
        </div>
    </section>


      <script>
        const track = document.querySelector('.slider-track');
        const cards = document.querySelectorAll('.slider-track .card');
        const cardWidth = cards[0].offsetWidth + 30;
        const cardsPerView = window.innerWidth <= 600 ? 1 : window.innerWidth <= 1024 ? 2 : 5;

        let index = 0;

        // Clone first N cards and append to the end
        for (let i = 0; i < cardsPerView; i++) {
          const clone = cards[i].cloneNode(true);
          track.appendChild(clone);
        }

        function slide() {
          index++;
          track.style.transition = "transform 0.5s ease-in-out";
          track.style.transform = `translateX(-${index * cardWidth}px)`;

          // Reset when reaching the cloned end
          if (index === cards.length) {
            setTimeout(() => {
              track.style.transition = "none";
              track.style.transform = `translateX(0px)`;
              index = 0;
            }, 500); // match the transition duration
          }
        }

        // Manual scroll only - removed auto-scroll
        // To add navigation buttons, implement click handlers here
      </script>


    </body>
</html>
