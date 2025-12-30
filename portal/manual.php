<?php
require "inc/header.php";

if (!filter_input(INPUT_GET, 'prod')) {
  header('Location: index.php');
  exit;
}
$prod_id = filter_input(INPUT_GET, 'prod');

if (filter_input(INPUT_GET, 'page')) {
  $page_id = filter_input(INPUT_GET, 'page');
} else {
  $pages_json = file_get_contents('../admin/inc/luna_pages/pages_' . $prod_id . '.json');
  $pages_data = json_decode($pages_json, true);
  $page_id = $pages_data['parent'][0];
}

$check_parent = filter_input(INPUT_GET,'parent') ? filter_input(INPUT_GET,'parent') : 0;

$manager = false ;
if($_SESSION['internal']){
  $manager = true ;
}

?>

<body>
  <script>
    $(document).ready(function() {
      $('#versionSelect').change(function() {
        var selectedValue = $(this).val();
        window.location.href = 'manual.php?prod=' + selectedValue;
      });
    });
  </script>
  <?php


  $luna->table = 'luna_products';
  $luna->id = $prod_id;
  $stmt4 = $luna->showAllWhere('id', ['id']);

  while ($row4 = $stmt4->fetch(PDO::FETCH_ASSOC)) {
    extract($row4);
  ?>
    <script src="../admin/assets/js/initTheme.js"></script>
    <div id="app">

      <?php
      include "inc/sidebar.php";
      ?>

      <div id="main">

        <div class="content-wrapper container">

          <div class="page-heading">

            <h4 class="d-inline"><?= $luna_manual_title ?> <?= $row4['name'] ?> (v. <?= $row4['version'] ?>)</h4> &nbsp;
            <?php
            $luna->table = 'luna_products';
            $luna->name = $row4['name'];
            $check_versions = $luna->showAllWhere('id', ['name']);

            $versions_arr = [];
            while ($versions_row = $check_versions->fetch(PDO::FETCH_ASSOC)) {
              extract($versions_row);
              $versions_arr[] = $versions_row['id'];
            }

            if (count($versions_arr) > 1) {
            ?>
              <?= $luna_manual_version ?>: <fieldset class="form-group d-inline">
                <select class="form-select" id="versionSelect">
                  <?php
                  foreach ($versions_arr as $ver) {
                    $selected = '';
                    $luna->table = 'luna_products';
                    $luna->id = $ver;
                    $stmt = $luna->showAllWhere('id', ['id']);
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    extract($row);
                    if ($row['id'] == $prod_id) {
                      $selected = 'selected';
                    }
                  ?>
                    <option value="<?= $row['id'] ?>" <?= $selected ?>><?= $row['version'] ?></option>
                  <?php
                  }
                  ?>
                </select>
              </fieldset>
            <?php
            }
            ?>
          </div>
          <div class="page-content">

            <section class="row">

              <div class="col-12">
                <div class="card shadow">
                  <?php

                  $paragraph_exist = false;

                  $luna->table = 'luna_pages_' . $prod_id;
                  $luna->id = $page_id;
                  $page_stmt = $luna->showAllWhere('id', ['id']);
                  $page_row = $page_stmt->fetch(PDO::FETCH_ASSOC);
                  extract($page_row);

                  ?>
                  <div class="card-header manual">
                    <h5 class="d-inline"><?= $page_row['title'] ?></h5>
                    
                    <?php
                    $account->id = $page_row['last_editor'];
                    $editor_stmt = $account->showAllWhere('id', ['id']);
                    $editor_row = $editor_stmt->fetch(PDO::FETCH_ASSOC);
                    extract($editor_row);

                    $editDate = $page_row['last_edit_time'];

                    if($manager){
                    ?>
                        <div class="buttons d-inline">&nbsp;
                            <a href="../admin/index.php?p=editLunaPage&prod=<?=$prod_id?>&idToMod=<?=$page_id?>" class="btn icon btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        </div>
                    <?php
                    }
                    ?>
                        <span class="edited">(<?= $luna_manual_editor ?> <b><?= $editor_row['username'] ?></b> <?= $luna_manual_on ?> <?= $editDate ?>)</span>

                  </div>
                  <div class="card-content p-4">
                    <?php
                    $label = 'hasParagraph_' . $page_row['id'];
                    if (isset($$label)) {
                    ?>
                      <div class="row">
                        <div class="col-4 p-2 bg-info rounded m-3">
                          <ul>
                            <?php

                            $par_array = [];
                            $paragraph_exist = false;
                            foreach ($pages_data['paragraph'] as $paragraph) {
                              if ($paragraph['child_id'] == $page_id) {

                                foreach ($paragraph['id'] as $par_id) {

                                  $luna->table = 'luna_pages_' . $prod_id;
                                  $luna->id = $par_id;
                                  $par_stmt = $luna->showAllWhere('id', ['id']);
                                  $par_row = $par_stmt->fetch(PDO::FETCH_ASSOC);
                                  extract($par_row);
                                  $par_array[] = $par_row['id'];
                                  $paragraph_exist = true;
                            ?>
                                  <li><a href="#par_<?= $par_id ?>"><?= $par_row['title'] ?></a></li>
                            <?php
                                }
                              }
                            }
                            ?>
                          </ul>

                        </div>

                      </div>
                    <?php
                    }
                    ?>
                    <p> <?= $page_row['content'] ?></p>

                   
                    <?php
                    if ($paragraph_exist) {

                      foreach ($par_array as $par) {

                        $luna->table = 'luna_pages_' . $prod_id;
                        $luna->id = $par;
                        $par_stmt1 = $luna->showAllWhere('id', ['id']);
                        $par_row1 = $par_stmt1->fetch(PDO::FETCH_ASSOC);
                        extract($par_row1);
                        $editDate = $par_row1['last_edit_time'];

                        $account->id = $par_row1['last_editor'];
                        $par_stmt2 = $account->showAllWhere('id', ['id']);
                        $par_row2 = $par_stmt2->fetch(PDO::FETCH_ASSOC);
                        extract($par_row2);

                        ?>
                        <h6 class='d-inline mt-5' id="par_<?=$par_row1['id']?>"><?= $par_row1['title'] ?></h6>
                        <?php
                        if($manager){
                        ?>
                        <div class="buttons d-inline">&nbsp;
                            <a href="../admin/index.php?p=editLunaPage&prod=<?=$prod_id?>&idToMod=<?=$par_row1['id']?>" class="btn icon btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                        </div>
                        <?php
                        }
                        ?>
                        <span class="edited">(<?= $luna_manual_editor ?> <b><?= $par_row2['username'] ?></b> <?= $luna_manual_on ?> <?= $editDate ?>)</span>
                        <p><?= $par_row1['content'] ?></p>
                        

                    <?php
                      }
                    }

                    ?>
                  </div>

                </div>
              </div>

            </section>
          <?php
        }
          ?>

          </div>
        </div>

        <?php
        include "inc/footer.php";
        ?>