<!-- Section Pre Footer-->
<section class="section section-lg" style="background-color:#EBEBEB;">
    <div class="container" style=" margin-bottom: -70px;">
        <div class="row row-30">
            <div class=" col-lg-4 align-self-center"><a class="brand" href="{{ route('index') }}"><img
                        class="brand-logo-light" src="{{ asset('jitojeaplogo.png') }}"
                        srcset="{{ asset('jitojeaplogo.png') }}" alt="Voelas" style="width:200px; margin-top:-100px"></a>
                <p style="font-size: 18px; font-family:'Poppins';font-weight:600;">JITO Education Assistance Program</p>
                <p style="text-align: justify;">We empower deserving and meritorious students to pursue higher education
                    in top institutions across
                    India and abroad with financial assistance and essential support.</p>
            </div>
            <div class="col-lg-2 col-sm-6 ">
                <h5 style="font-size: 18px; font-family:'Poppins';font-weight:600;text-transform:none;color: #2D2D2D;">
                    <span>Quick Links
                    </span>
                </h5>
                <ul style="list-style: none; padding: 0; margin-top: 20px;">
                    <li style="margin-bottom: 15px;">
                        <div id="footer-about-toggle"
                            style="font-weight: 600; color: #2D2D2D; font-family: Arial; font-size: 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                            <span style="font-size: 14px; color: #2D2D2D;">▶ &nbsp;&nbsp; About</span>
                            <span style="font-size: 12px; color: #666;"></span>
                            </span>
                        </div>
                        <ul id="footer-about-dropdown" style="list-style: none; padding: 0; margin: 0; display: none;">
                            <li style="margin-bottom: 5px;"><a href="{{ route('jito') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">JITO</a>
                            </li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('jeap') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">JEAP</a>
                            </li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('boardOfDirectors') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Board
                                    of Directors</a></li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('zoneChairmen') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Zone
                                    Chairmen</a></li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('testimonial&Success') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Our
                                    Testimonials</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <div id="footer-application-toggle"
                            style="font-weight: 600; color: #2D2D2D; font-family: Arial; font-size: 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                            {{-- <span>Application</span> --}}
                            <span style="font-size: 14px; color: #2D2D2D;">▶ &nbsp;&nbsp; Application</span>
                            <span style="font-size: 12px; color: #666;"></span>
                        </div>
                        <ul id="footer-application-dropdown"
                            style="list-style: none; padding: 0; margin: 0; display: none;">
                            <li style="margin-bottom: 5px;"><a href="{{ route('documentchecklist1') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">DOCUMENTS</a>
                            </li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('howtoapply') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">How
                                    to apply</a></li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('faqs') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">FAQ's</a>
                            </li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <div id="footer-donor-toggle"
                            style="font-weight: 600; color: #2D2D2D; font-family: Arial; font-size: 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                            {{-- <span>Donor</span> --}}
                            <span style="font-size: 14px; color: #2D2D2D;">▶ &nbsp;&nbsp; Donor</span>
                            <span style="font-size: 12px; color: #666;"></span>
                        </div>
                        <ul id="footer-donor-dropdown" style="list-style: none; padding: 0; margin: 0; display: none;">
                            <li style="margin-bottom: 5px;"><a href="{{ route('beDonor') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">BE
                                    A DONOR</a></li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('ourDonors') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Our
                                    Donors</a></li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 15px;">
                        <div id="footer-university-toggle"
                            style="font-weight: 600; color: #2D2D2D; font-family: Arial; font-size: 16px; cursor: pointer; display: flex; justify-content: space-between; align-items: center;">
                            {{-- <span>University</span> --}}
                            <span style="font-size: 14px; color: #2D2D2D;">▶ &nbsp;&nbsp; University</span>
                            <span style="font-size: 12px; color: #666;"></span>
                        </div>
                        <ul id="footer-university-dropdown"
                            style="list-style: none; padding: 0; margin: 0; display: none;">
                            <li style="margin-bottom: 5px;"><a href="{{ route('domestic') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Domestic</a>
                            </li>
                            <li style="margin-bottom: 5px;"><a href="{{ route('foreign') }}"
                                    style="color: #666; text-decoration: none; font-family: Arial; font-size: 14px;">Foreign</a>
                            </li>
                        </ul>
                    </li>
                    <li style="margin-bottom: 10px;"><a href="{{ route('gallery') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Gallery</a>
                    </li>
                    <li style="margin-bottom: 10px;"><a href="{{ route('contact') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Contact</a>
                    </li>
                    <li style="margin-bottom: 10px;"><a href="{{ route('privacy.policy') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Privacy Policy</a>
                    </li>
                    <li style="margin-bottom: 10px;"><a href="{{ route('terms.conditions') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Terms & Conditions</a>
                    </li>
                </ul>

            </div>
            <div class="col-lg-2 col-sm-6 ">
                <h5 style="font-size: 18px; font-family:'Poppins';font-weight:600;text-transform:none;color: #2D2D2D;">
                    <span>Legal
                    </span>
                </h5>
                <ul style="list-style: none; padding: 0; margin-top: 20px;">

                    <li style="margin-bottom: 10px;"><a href="{{ route('gallery') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Gallery</a>
                    </li>
                    <li style="margin-bottom: 10px;"><a href="{{ route('contact') }}"
                            style="color: #2D2D2D; text-decoration: none; font-family: Arial; font-size: 14px; font-weight: 600;">▶
                            &nbsp;&nbsp; Contact</a>
                    </li>
                </ul>

            </div>
            {{-- <div class="col-lg-2 col-sm-6 ">
                <h5 style="font-family: Times New Roman !important"><span class="big font-weight-sbold">Rom
                        detail</span></h5>
                <div>
                    <p
                        style="margin-top:20px; margin-bottom:20px;font-family: Arial;color: #2D2D2D;font-size: 18px;font-weight: 400;">
                        <span> </span>
                    </p>
                    <p class="event-detail-address big "
                        style="font-family: Arial;color: #2D2D2D;font-size: 18px;font-weight: 400;text-align:justify;margin-top:35px;">
                        JITO is a global network of Jain business leaders promoting ethical entrepreneurship and
                        economic growth.
                    </p><a class="event-detail-link"
                        style="font-family: Arial;color: #2D2D2D;font-size: 16px;font-weight:400;">View map
                        location</a>
                </div>
            </div> --}}
            <div class="col-sm-6 col-lg-4 ">
                <h5 style="font-family: Times New Roman"><span class="big font-weight-sbold">Social Updates</span>
                </h5>
                <div class="event-detail">
                    <p class="event-detail-address big"
                        style="font-family:Arial;color:#2D2D2D;font-size:18px;font-weight: 400; margin-top:-20px">JITO HOUSE, Plot No.
                        A-56, Road No. 1, MIDC MAROL, Near International by Tunga Hotel, Mulgaon, Andheri
                        (East), Mumbai - 400 093.<br>
                        Contact:+91 86559 88411<br>
                        Email:support.jitojeap@jito.org
                    </p>
                    <ul class="list-inline list-inline-xs">
                        <li data-wow-delay=".2s"><a class="icon icon-rect icon-xs icon-white fa-instagram"
                                href="https://www.instagram.com/jito_rom_zone?igsh=MW12M2F3end5c2liNA=="
                                target="blank" data-triangle=".icon-rect-overlay">
                                <div class="icon-rect-overlay"></div>
                            </a></li>

                        <li data-wow-delay=".65s"><a class="icon icon-rect icon-xs icon-white fa-youtube-play"
                                href="https://youtube.com/@jitoromzone3554?si=95bNmKyQ1wvaxi0V" target="blank"
                                data-triangle=".icon-rect-overlay">
                                <div class="icon-rect-overlay"></div>
                            </a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Divider-->
<div class="divider divider-gray-900 text-center"></div>
<!-- Footer Classic-->
<footer class="section footer-classic context-dark">
    <div class="container">
        <a href="http://techmetsolutions.com/#/">
            <p class="rights" style="font-family:Arial;"span>Copyright&nbsp;</span><span>&copy;&nbsp;</span><span
                    class="copyright-year"></span><span>&nbsp;</span><span>by TechMET Solutions</span>
            </p>
        </a>
    </div>
</footer>
</div>
<div class="snackbars" id="form-output-global"></div>
<div class="block-with-svg-gradients">
    <svg xmlns="http://www.w3.org/2000/svg">
        <defs>
            <lineargradient id="svg-gradient-primary" x1="0%" y1="100%" x2="100%" y2="0%">
                <stop offset="0%" style="stop-color:rgb(130,46,168);stop-opacity:1"></stop>
                <stop offset="100%" style="stop-color:rgb(217,14,144);stop-opacity:1"></stop>
            </lineargradient>
        </defs>
    </svg>
</div>
<script>
    document.getElementById('dropdownToggle').addEventListener('click', function() {
        const dropdown = document.getElementById('Dropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    document.getElementById('donorDropdownToggle').addEventListener('click', function() {
        const dropdown = document.getElementById('donorDropdown');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
    });

    // Footer dropdown functionality
    document.getElementById('footer-about-toggle').addEventListener('click', function() {
        const dropdown = document.getElementById('footer-about-dropdown');
        const arrow = this.querySelector('span:last-child');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        arrow.textContent = dropdown.style.display === 'block' ? '' : '';
    });

    document.getElementById('footer-application-toggle').addEventListener('click', function() {
        const dropdown = document.getElementById('footer-application-dropdown');
        const arrow = this.querySelector('span:last-child');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        arrow.textContent = dropdown.style.display === 'block' ? '' : '';
    });

    document.getElementById('footer-donor-toggle').addEventListener('click', function() {
        const dropdown = document.getElementById('footer-donor-dropdown');
        const arrow = this.querySelector('span:last-child');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        arrow.textContent = dropdown.style.display === 'block' ? '' : '';
    });

    document.getElementById('footer-university-toggle').addEventListener('click', function() {
        const dropdown = document.getElementById('footer-university-dropdown');
        const arrow = this.querySelector('span:last-child');
        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
        arrow.textContent = dropdown.style.display === 'block' ? '' : '';
    });
</script>
<script src="{{ asset('website/js/core.min.js') }}"></script>
<script src="{{ asset('website/js/script.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
