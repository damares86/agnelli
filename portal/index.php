<?php
require "inc/header.php";

if (!filter_input(INPUT_POST, 'prod'))

?>

<body>
  <script src="../admin/assets/js/initTheme.js"></script>
  <div id="app">

    <div id="main" class="home">

      <div class="content-wrapper container">


        <div class="page-content">

          <?php

        require "../admin/inc/alert.php";

        if (filter_input(INPUT_GET, "p")) {
          include "inc/func/$page.php";
        } else {

          ?>




            <section class="row">

              <div class="col-12">
                <div class="card shadow">
                  <div class="card-header text-center">
                    <h3><?= $luna_home_welcome ?></h3>
                  </div>
                  <div class="card-content home p-5">
                    <?php

                    $luna->table = 'luna_products';
                    $stmt1 = $luna->showAll('id');

                    if ($stmt1->rowCount() > 0) {
                    ?>
                      <p>
                        <?= $luna_home_choose ?>:
                      <ul>
                        <?php

                        while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
                          extract($row1);
                        ?>

                          <li><a href="manual.php?prod=<?= $row1['id'] ?>"><?= $row1['name'] ?> (v. <?= $row1['version'] ?>)</a></li>

                        <?php
                        }
                        ?>
                      </ul>
                      </p>
                    <?php
                    } else {
                    ?>

                      <?=$luna_home_no_manual?>

                    <?php

                    }
                    ?>
                  </div>
                </div>
              </div>

            <?php
          }
            ?>
            </section>

        </div>
      </div>

      <?php
      include "inc/footer.php";
      ?>