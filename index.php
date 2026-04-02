<?php
require 'inc/header.php';
require 'inc/sidebar.php';
?>

<div class="page-content-wrapper">

  <div>


    <div class="pt-3"></div>

    <div class="container">
      <a href="rubrica.php">
        <div class="card service-card bg-danger bg-gradient mb-3">
          <div class="card-body">
            <div class="d-flex gap-3 align-items-center justify-content-between">
              <div class="service-text">
                <h5>Rubrica</h5>
                <!--<p class="mb-0">The write less, do more with JavaScript Library.</p>-->
              </div>
              <div class="service-img">
                <img src="assets/img/rubrica.png" alt="">
              </div>
            </div>
          </div>
        </div>
      </a>

      <a href="portal/manual.php?prod=1">
        <div class="card service-card bg-info bg-gradient mb-3">
          <div class="card-body">
            <div class="d-flex gap-3 align-items-center justify-content-between">
              <div class="service-text">
                <h5>Guida</h5>
              </div>
              <div class="service-img">
                <img src="assets/img/white-question-mark.svg" alt="">
              </div>
            </div>
          </div>
        </div>
      </a>

      <div class="pb-3"></div>
    </div>

    <?php
    require 'inc/nav.php';
    require 'inc/footer.php';
    ?>