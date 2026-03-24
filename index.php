<?php
require 'inc/header.php';
?>

  <!-- Header Area -->
  <div class="header-area" id="headerArea">
    <div class="container">
      <!-- Header Content -->
      <div class="header-content header-style-five position-relative d-flex align-items-center justify-content-between">
        <!-- Logo Wrapper -->
        <div class="logo-wrapper">
          <a href="home.html">
            <img class="logo-light" src="assets/img/core-img/logo.png" alt="">
            <img class="logo-dark" src="assets/img/core-img/logo-dark.png" alt="">
          </a>
        </div>

        <!-- Navbar Toggler -->
        <div class="navbar-toggler" id="affanNavbarToggler" data-bs-toggle="offcanvas" data-bs-target="#affanOffcanvas"
          aria-controls="affanOffcanvas">
          <span class="d-block"></span>
          <span class="d-block"></span>
          <span class="d-block"></span>
        </div>
      </div>
    </div>
  </div>
<?php
require 'inc/menu.php';
?>

  <div class="page-content-wrapper">

    <!-- Welcome Toast -->
    <div class="toast toast-autohide custom-toast-1 home-page-toast shadow" role="alert" aria-live="assertive"
      aria-atomic="true" data-bs-delay="60000" data-bs-autohide="true" id="installWrap">
      <div class="toast-body p-0">
        <div class="toast-text">
          <h6 class="mb-1">Welcome to Affan!</h6>
          <span class="d-block mb-2">Click the <strong class="text-primary">Install Now</strong> button & enjoy it just
            like an
            app.</span>
          <button id="installAffan" class="btn btn-sm btn-warning">Install Now</button>
        </div>
      </div>
      <button class="btn btn-close position-relative p-2" type="button" data-bs-dismiss="toast"
        aria-label="Close"></button>
    </div>

    <!-- Tiny Slider One Wrapper -->
    <div class="tiny-slider-one-wrapper" dir="ltr">
      <div class="tiny-slider-one">
        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/bg-img/31.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Built with Bootstrap 5.3</h3>
                <p class="text-white">Create fast, responsive, and modern mobile experiences.</p>
                <a class="btn btn-creative btn-warning" href="#">Get Started <i class="ti ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/bg-img/33.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Framework-Free Code</h3>
                <p class="text-white">Easy to customize and maintain with vanilla JS.</p>
                <a class="btn btn-creative btn-warning" href="#">Buy Now <i class="ti ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/bg-img/32.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Installable PWA</h3>
                <p class="text-white">Fast, reliable, and accessible directly from your device.</p>
                <a class="btn btn-creative btn-warning" href="#">Buy Now <i class="ti ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/bg-img/33.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Everything You Need</h3>
                <p class="text-white">Build complete websites in days, not months.</p>
                <a class="btn btn-creative btn-warning" href="#">Buy Now <i class="ti ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>

        <!-- Single Hero Slide -->
        <div>
          <div class="single-hero-slide bg-overlay" style="background-image: url('assets/img/bg-img/1.jpg')">
            <div class="h-100 d-flex align-items-center text-center">
              <div class="container">
                <h3 class="text-white mb-1">Dark &amp; RTL Ready</h3>
                <p class="text-white">Switch easily between Dark Mode and RTL layouts.</p>
                <a class="btn btn-creative btn-warning" href="#">Buy Now <i class="ti ti-arrow-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pt-3"></div>

    <div class="container">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-circle-square"></i>
                </div>
                <h6 class="mb-0 fz-14">PWA Support</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-brand-bootstrap"></i>
                </div>
                <h6 class="mb-0 fz-14">Bootstrap 5.3</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-file-type-js"></i>
                </div>
                <h6 class="mb-0 fz-14">Vanilla JavaScript</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card card-bg-img bg-img bg-overlay mb-3" style="background-image: url('assets/img/bg-img/3.jpg')">
        <div class="card-body p-4">
          <h2 class="text-white">Ready to Use Elements</h2>
          <p class="mb-3 text-white">Unlock a collection of over 220 modern design elements. Simply copy and paste to
            enhance your page instantly.</p>
          <a class="btn btn-warning" href="elements.html">Explore Elements <i class="ti ti-arrow-right"></i></a>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-brand-sass"></i>
                </div>
                <h6 class="mb-0 fz-14">SCSS</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-brand-npm"></i>
                </div>
                <h6 class="mb-0 fz-14">npm</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-bulb"></i>
                </div>
                <h6 class="mb-0 fz-14">Gulp 4</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card bg-primary mb-3 bg-img" style="background-image: url('assets/img/core-img/1.png')">
        <div class="card-body p-4">
          <h2 class="text-white">35+ Pre-Built Pages</h2>
          <p class="mb-3 text-white">A collection of 35+ fully designed pages, including Authentication, Chats,
            eCommerce, Blogs, and more—ready to use instantly.</p>
          <a class="btn btn-warning" href="pages.html">Browse All Pages <i class="ti ti-arrow-right"></i></a>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card mb-3">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-sun-moon"></i>
                </div>
                <h6 class="mb-0 fz-14">Dark Mode</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-text-direction-rtl"></i>
                </div>
                <h6 class="mb-0 fz-14">RTL Support</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-code"></i>
                </div>
                <h6 class="mb-0 fz-14">Clean Code</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card bg-secondary mb-3">
        <div class="card-body">
          <h3>Customer Review</h3>

          <div class="testimonial-slide-three-wrapper" dir="ltr">
            <div class="testimonial-slide3 testimonial-style3">

              <!-- Single Testimonial Slide -->
              <div class="single-testimonial-slide">
                <div class="text-content">
                  <div class="d-flex gap-1 mb-2">
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                  </div>
                  <h6 class="mb-2">The code looks clean, and the designs are excellent. I recommend.</h6>
                  <span class="d-block">Mrrickez, Themeforest</span>
                </div>
              </div>

              <!-- Single Testimonial Slide -->
              <div class="single-testimonial-slide">
                <div class="text-content">
                  <div class="d-flex gap-1 mb-2">
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                  </div>
                  <h6 class="mb-2">All complete, <br> great craft.</h6>
                  <span class="d-block">Mazatlumm, Themeforest</span>
                </div>
              </div>

              <!-- Single Testimonial Slide -->
              <div class="single-testimonial-slide">
                <div class="text-content">
                  <div class="d-flex gap-1 mb-2">
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                  </div>
                  <h6 class="mb-2">Awesome template! <br> Excellent support!</h6>
                  <span class="d-block">Vguntars, Themeforest</span>
                </div>
              </div>

              <!-- Single Testimonial Slide -->
              <div class="single-testimonial-slide">
                <div class="text-content">
                  <div class="d-flex gap-1 mb-2">
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                  </div>
                  <h6 class="mb-2">Nice modern design, I love the product.</h6>
                  <span class="d-block">electroMEZ, Themeforest</span>
                </div>
              </div>

              <!-- Single Testimonial Slide -->
              <div class="single-testimonial-slide">
                <div class="text-content">
                  <div class="d-flex gap-1 mb-2">
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                    <i class="ti ti-star-fill text-warning"></i>
                  </div>
                  <h6 class="mb-2">Excquisite pixel perfect design, with an abundance of content, well documented.</h6>
                  <span class="d-block">webpixie, Themeforest</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="container">
      <div class="card">
        <div class="card-body">
          <div class="row g-3">
            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-carambola"></i>
                </div>
                <h6 class="mb-0 fz-14">Top Rated</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-award"></i>
                </div>
                <h6 class="mb-0 fz-14">Elegant Design</h6>
              </div>
            </div>

            <div class="col-4">
              <div class="feature-card mx-auto text-center">
                <div class="card mx-auto bg-gray">
                  <i class="ti ti-flame"></i>
                </div>
                <h6 class="mb-0 fz-14">Innovative & Trendy</h6>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="pb-3"></div>
  </div>

<?php
require 'inc/nav.php';
require 'inc/footer.php';
?>
