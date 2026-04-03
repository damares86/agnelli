<!-- Footer Nav -->
<div class="footer-nav-area" id="footerNav">
  <div class="container px-0">
    <!-- Footer Content -->
    <div class="footer-nav position-relative">
      <ul class="h-100 d-flex align-items-center justify-content-between ps-0">
        <li class="active">
          <a href="home.html">
            <i class="ti ti-home"></i>
            <span>Home</span>
          </a>
        </li>

        <li>
          <a href="rubrica.php">
            <i class="ti ti-address-book"></i>
            <span>Rubrica</span>
          </a>
        </li>

        <!--   <li>
            <a href="elements.html">
              <i class="ti ti-heart"></i>
              <span>Elements</span>
            </a>
          </li> -->
        <?php
        if ($_SESSION['role_id'] < 4) {
        ?>
          <li>
            <a href="admin">
              <i class="ti ti-settings"></i>
              <span>Admin area</span>
            </a>
          </li>
        <?php
        }
        ?>
      </ul>
    </div>
  </div>
</div>