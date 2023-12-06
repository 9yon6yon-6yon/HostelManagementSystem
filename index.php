<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Page Information -->
        <meta name="author" content="Anderson Anizio">
        <meta name="copyright" content />
        <meta name="description" content="Landing Page Flexbox Template">
        <meta name="keywords" content>
        <title>Landing Page Flexbox Template</title>

        <!-- Page Styles -->
        <link rel="stylesheet" href="./assets/css/styles.css">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Quicksand"
            rel="stylesheet">
        <link rel="stylesheet"
            href="https://use.fontawesome.com/releases/v5.6.3/css/all.css"
            integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/"
            crossorigin="anonymous">
    </head>
    <body>
        <header class="main-header">
            <div class="main-header-bg"
                style="background-image: url(./assets/images/hero.jpg);"></div>
            <div class="main-container main-header-wrapper">
                <div class="main-header-top">
                    <h1 class="logo"><a href="index.php">HMS</a></h1>
                    <nav class="main-menu">
                        <a href="./Authentication/login.php">Login</a>
                        <!-- <a href="#work">Work</a> -->
                        <!-- <a href="#services">Services</a>
                    <a href="#testimonials">Testimonials</a> -->
                    </nav>
                </div>

                <div class="hero">
                    <h2>City University</h2>
                    <h3>Hostel Management System</h3>
                    <a href="./Authentication/login.php" class="btn-primary">Login</a>
                </div>
            </div>
        </header>

        <!-- Work Section -->
        <section id="work" class="work section">
            <div class="main-container">
                <h2 class="section-title">Hostel Views</h2>
                <p class="section-desc"> Male and Female hostels at City
                    University Hall are integral components of campus life,
                    providing students with a supportive and enriching living
                    experience. These hostels contribute significantly to the
                    overall well-being and development of students, fostering a
                    sense of community that lasts beyond their time at the
                    university.</p>
                <hr class="section-divider">

                <div class="gallery">
                    <div class="gallery__row">
                        <div class="gallery__item gallery__item--small"
                            style="background-image: url(./assets/images/gallery-1.jpg)"></div>
                        <div class="gallery__item gallery__item--large"
                            style="background-image: url(./assets/images/gallery-2.jpg)"></div>
                    </div>
                    <div class="gallery__row">
                        <div class="gallery__item gallery__item--large"
                            style="background-image: url(./assets/images/gallery-3.jpg)"></div>
                        <div class="gallery__item gallery__item--small"
                            style="background-image: url(./assets/images/gallery-4.jpg)"></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="services section section-state--odd">
            <div class="main-container">
                <h2 class="section-title">Facilities</h2>
                <p class="section-desc">Aliquip veniam irure est nisi officia ad
                    exercitation. Reprehenderit pariatur enim dolore aliquip non
                    aliquip nulla duis aliqua est cillum sit adipisicing.</p>
                <hr class="section-divider">

                <div class="grid">
                    <div class="grid__item">
                        <i class="fas fa-camera-retro"></i>
                        <h4>In-room Amenities</h4>
                        <p>
                            One Bed per Student shall be offered<br>
                            Study tables & Chair<br>
                            Tube lights & Fan<br>
                            Dustbin in each room<br>
                        </p>
                    </div>
                    <div class="grid__item">
                        <i class="fas fa-camera-retro"></i>
                        <h4>Electricity & Internet</h4>
                        <p>                                    Electricity facility<br>
                            Generator service available <br>
                            Broadband and wifi service
                        </p>
                    </div>
                    <div class="grid__item">
                        <i class="fas fa-camera-retro"></i>
                        <h4>Entertainment</h4>
                        <p>
                            Common Room<br>
                            Indoor games like carrom, chess, table tennis, etc.<br>
                        </p>
                    </div>

                    <div class="grid">
                        <div class="grid__item">
                            <i class="fas fa-camera-retro"></i>
                            <h4>Electricity & Internet</h4>
                            <p>
                                Electricity facility<br>
                                Generator service available (Need Based)
                            </p>
                        </div>

                        <div class="grid__item">
                            <i class="fas fa-briefcase"></i>
                            <h4>Cost-Effective Living Option</h4>
                            <p>Cost-effective compared to other living options<br>
                                Get all services together in the single hall cost<br>                                
                                Long corridor in front of room<br>
                                Separate balcony in each room</p>
                        </div>
                        <div class="grid__item">
                            <i class="fas fa-edit"></i>
                            <h4>Housekeeping</h4>
                            <p>Rooms<br>
                                Washrooms<br>
                                Common areas are cleaned on a daily basis</p>
                        </div>
                    </div>

                    <!--                  
            <h2 class="section-title">Self Help Amenities</h2>
            <ul class="amenities-list">
                <li>Laundry Service</li>
                <li>Filter Water facility to be provided</li>
                <li>Medical facility available with first aid/ provided to sick Residents</li>
                <li>Doctor on call number(s) to be shared with the students</li>
                <li>Dining area</li>
            </ul>
        
            <h2 class="section-title">Cost-Effective Living Option</h2>
            <ul class="amenities-list">
                <li>Cost-effective compared to other living options</li>
                <li>Get all services together in the single hall cost</li>
                <li>Long corridor in front of room</li>
                <li>Separate balcony in each room</li>
            </ul>
        
            <h2 class="section-title">Electricity & Internet</h2>
            <ul class="amenities-list">
                <li>Electricity facility</li>
                <li>Generator service available (Need Based)</li>
                <li>Broadband and wifi service</li>
            </ul>
        
            <h2 class="section-title">Housekeeping</h2>
            <ul class="amenities-list">
                <li>Rooms</li>
                <li>Washrooms</li>
                <li>Common areas are cleaned on a daily basis</li>
            </ul>
        
            <h2 class="section-title">Entertainment</h2>
            <ul class="amenities-list">
                <li>Common Room</li>
                <li>Indoor games like carrom, chess, table tennis, etc.</li>
            </ul> -->
                </div>

            </section>

            <footer>
                <div class="main-container">
                    <div class="social-networks">
                        <a href="#" title="Twitter"><i
                                class="fab fa-twitter-square"></i></a>
                        <a href="https://www.facebook.com/ashik.karimnayon"
                            title="Facebook" target="_blank"><i
                                class="fab fa-facebook-square"></i></a>
                        <a href="https://github.com/AshikKarim" title="GitHub"
                            target="_blank"><i class="fab fa-github-square"></i></a>
                        <a href="https://www.linkedin.com/in/md-ashik-karim-nayon/" title="LinkedIn"><i class="fab fa-linkedin"></i></a>
                    </div>
                    <p>Created by <a href="https://github.com/AshikKarim"
                            title="GitHub Profile" target="_blank">AshikKarim || SaraShahrin</a>
                        From Bangladesh</p>
                    <p>Images courtesy to <a href="https://unsplash.com/">Unsplash</a></p>
                </div>
            </footer>
        </body>
    </html>