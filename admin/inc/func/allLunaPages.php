<?php

// get the product data
$prod_id = filter_input(INPUT_GET, 'prod');

$luna->table = 'luna_products';
$luna->id = $prod_id;
$stmt1 = $luna->showAllWhere('id', ['id']);
$row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
extract($row1);

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?= $row1['name'] ?> - <?= $allLunaPages_title ?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active">
            <a href="index.php?p=allLunaProducts"><?= $allLunaProducts_title ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?= $allLunaPages_title ?>
          </li>
        </ol>
      </nav>
    </div>
  </div>
</div>
<br>


<!-- Basic Tables start -->
<section class="section">
  <div class="card shadow">
    <div class="card-header">
      <h4 class="d-inline"><?= $row1['name'] ?></h4> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?= $allLunaPages_add_page ?></a>
    </div>
    <div class="card-body">


      <div class='wrapper'>
        <div id="alert-placeholder"></div>
        <div id='parent-block' class='container-pages p-3'>
          <?php

          $parent_div_arr = [];
          $child_div_arr = [];
          $paragraph_div_arr = [];

          if (!file_exists('inc/luna_pages/pages_' . $prod_id . '.json') && !file_exists('inc/luna_pages_bck/pages_' . $prod_id . '.json')) {
          ?>
            <span class="text-white"><?= $allLunaPages_no_page ?></span>
            <?php
          } else {
            if (file_exists('inc/luna_pages/pages_' . $prod_id . '.json')) {

              $pages_json = file_get_contents('inc/luna_pages/pages_' . $prod_id . '.json');
              $pages_data = json_decode($pages_json, true);
            } else {

              $pages_json = file_get_contents('inc/luna_pages_bck/pages_' . $prod_id . '.json');
              $pages_data = json_decode($pages_json, true);
            }

            foreach ($pages_data['parent'] as $parent) {

              $luna->table = 'luna_pages_' . $prod_id;
              $luna->id = $parent;
              $stmt = $luna->showAllWhere('id', ['id']);

              $row = $stmt->fetch(PDO::FETCH_ASSOC);
              extract($row);
              $parent_div_arr[] = $row['id'];
            ?>
              <div id="<?= $row['id'] ?>" class='container-pages parent_item px-5 rounded m-2'> <!-- p_1 deve essere l'id della pagina-->
                <b><?= $row['title'] ?></b>
                <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#child_<?= $row['id'] ?>" role="button" aria-expanded="false" aria-controls="child_<?= $row['id'] ?>">
                  <i class="bi bi-chevron-down"></i>
                </a>
                &nbsp; | &nbsp;
                <?= $allLunaPages_operations ?> : &nbsp;
                <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&idToMod=<?= $row['id'] ?>" class="btn btn-sm icon icon-left btn-warning shadow"> <i class="bi bi-pencil-square"></i></a>
                &nbsp;
                <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>" class="btn btn-sm icon icon-left btn-success shadow"><i class="bi bi-plus-circle"></i></a>
                &nbsp;
                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><i class="bi bi-trash"></i>
                </a>
                <!--Danger theme Modal -->
                <div class="modal fade text-left" id="danger<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-danger">
                        <h5 class="modal-title white" id="myModalLabel120">
                          <?= $common_modal_title_sure ?>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                        </button>
                      </div>
                      <div class="modal-body">
                        <?= $allLunaPages_modal_body ?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                        </button>
                        <span class="d-none d-sm-block"><a href="core/mngLuna.php?idPageToDel=<?= $row['id'] ?>&prod=<?= $prod_id ?>&type=parent" class="btn btn-danger ml-1">
                            <?= $common_modal_confirm ?>
                          </a></span>
                      </div>
                    </div>
                  </div>
                </div>
                <?php
                // check se esistono dei child

                foreach ($pages_data['child'] as $child) {

                  if ($child['parent_id'] == $parent) {
                ?>

                    <div id="child_<?= $row['id'] ?>" class='collapse container-pages child_block p-2 rounded m-2'> <!-- 1 deve essere l'id della pagina-->

                      <?php
                      foreach ($child['id'] as $item) {

                        $luna->table = 'luna_pages_' . $prod_id;
                        $luna->id = $item;
                        $stmt1 = $luna->showAllWhere('id', ['id']);


                        $row1 = $stmt1->fetch(PDO::FETCH_ASSOC);
                        extract($row1);
                        $child_div_arr[] = $row1['id'];
                      ?>
                        <div id="<?= $row1['id'] ?>" class="child_item rounded m-2">

                          <b> <?= $row1['title'] ?></b>
                          &nbsp; | &nbsp; <?= $allLunaPages_operations ?>: &nbsp;
                          <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#paragraph_<?= $row1['id'] ?>" role="button" aria-expanded="false" aria-controls="paragraph_<?= $row1['id'] ?>">
                            <i class="bi bi-chevron-down"></i>
                          </a> &nbsp;
                          <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&idToMod=<?= $row1['id'] ?>" class="btn icon icon-left btn-sm btn-warning shadow"> <i class="bi bi-pencil-square"></i></a>
                          &nbsp;
                          <a href="index.php?p=addLunaPage&prod=<?= $prod_id ?>&parent=<?= $row['id'] ?>&child=<?= $row1['id'] ?>" class="btn btn-sm icon icon-left btn-success shadow"><i class="bi bi-plus-circle"></i></a>
                          &nbsp;
                          <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row1['id'] ?>"><i class="bi bi-trash"></i>
                          </a>
                          <!--Danger theme Modal -->
                          <div class="modal fade text-left" id="danger<?= $row1['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                              <div class="modal-content">
                                <div class="modal-header bg-danger">
                                  <h5 class="modal-title white" id="myModalLabel120">
                                    <?= $common_modal_title_sure ?>
                                  </h5>
                                  <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                    <i data-feather="x"></i>
                                  </button>
                                </div>
                                <div class="modal-body">
                                  <?= $allLunaPages_modal_body ?>
                                </div>
                                <div class="modal-footer">
                                  <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                    <i class="bx bx-x d-block d-sm-none"></i>
                                    <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                  </button>
                                  <span class="d-none d-sm-block"><a href="core/mngLuna.php?idPageToDel=<?= $row1['id'] ?>&prod=<?= $prod_id ?>&parent_id=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                                      <?= $common_modal_confirm ?>
                                    </a></span>
                                </div>
                              </div>
                            </div>
                          </div>
                          <?php

                          foreach ($pages_data['paragraph'] as $par) {

                            if ($par['child_id'] == $row1['id']) {
                          ?>


                              <div id="paragraph_<?= $row1['id'] ?>" class='collapse container-pages paragraph_block p-2 rounded m-2'><!-- 1 deve essere l'id della pagina child a cui appartengono i paragrafi-->
                                <?php

                                foreach ($par['id'] as $par_id) {
                                  $luna->table = 'luna_pages_' . $prod_id;
                                  $luna->id = $par_id;
                                  $stmt2 = $luna->showAllWhere('id', ['id']);

                                  $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                                  extract($row2);
                                  $paragraph_div_arr[] = $row1['id'];
                                ?>
                                  <div id="<?= $row2['id'] ?>" class="paragraph_item rounded m-2 p-2">
                                    <b><?= $row2['title'] ?></b>
                                    &nbsp; | &nbsp; <?= $allLunaPages_operations ?>: &nbsp;
                                    <a class="btn icon btn-sm btn-info mx-2 shadow" data-bs-toggle="collapse" href="#paragraph_<?= $row1['id'] ?>" role="button" aria-expanded="false" aria-controls="paragraph_<?= $row1['id'] ?>">
                                      <i class="bi bi-chevron-down"></i>
                                    </a> &nbsp;
                                    <a href="index.php?p=editLunaPage&prod=<?= $prod_id ?>&idToMod=<?= $row2['id'] ?>" class="btn icon icon-left btn-sm btn-warning shadow"> <i class="bi bi-pencil-square"></i></a>
                                    &nbsp;
                                    <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row2['id'] ?>"><i class="bi bi-trash"></i>
                                    </a>
                                    <!--Danger theme Modal -->
                                    <div class="modal fade text-left" id="danger<?= $row2['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                                      <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                                        <div class="modal-content">
                                          <div class="modal-header bg-danger">
                                            <h5 class="modal-title white" id="myModalLabel120">
                                              <?= $common_modal_title_sure ?>
                                            </h5>
                                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                              <i data-feather="x"></i>
                                            </button>
                                          </div>
                                          <div class="modal-body">
                                            <?= $allLunaPages_modal_body ?>
                                          </div>
                                          <div class="modal-footer">
                                            <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                                              <i class="bx bx-x d-block d-sm-none"></i>
                                              <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                                            </button>
                                            <span class="d-none d-sm-block"><a href="core/mngLuna.php?idPageToDel=<?= $row2['id'] ?>&prod=<?= $prod_id ?>&child_id=<?= $row1['id'] ?>" class="btn btn-danger ml-1">
                                                <?= $common_modal_confirm ?>
                                              </a></span>
                                          </div>
                                        </div>
                                      </div>
                                    </div>

                                  </div>
                                <?php
                                }
                                ?>

                              </div>
                          <?php
                            }
                          }
                          ?>
                        </div>
                      <?php
                      }
                      ?>
                      <!-- fine child -->
                    </div>
                <?php
                  }
                }
                ?>
                <!-- fine div pagine -->
              </div>

          <?php
            }
          }
          ?>
        </div>
      </div>
    </div>
    <button id="save" class="btn btn-success m-3 w-25">Save</button>

  </div>
</section>


<script src='script/dragula.js'></script>
<script>
  var blocks_array = [];

  var p = 'parent-block';
  blocks_array.push(p);
  <?php
  foreach ($parent_div_arr as $item) {
  ?>
    var child_<?= $item ?> = 'child_<?= $item ?>';
    blocks_array.push(child_<?= $item ?>);
  <?php
  }
  ?>

  <?php
  foreach ($paragraph_div_arr as $item_paragraph) {
  ?>

    var paragraph_<?= $item_paragraph ?> = 'paragraph_<?= $item_paragraph ?>';
    blocks_array.push(paragraph_<?= $item_paragraph ?>);
  <?php
  }
  ?>
</script>
<script src='script/example.min.js'></script>

<script>
  $("#save").click(function() {
    let orderedItems = [];

    $('#parent-block').find('*').each(function() {
      // Utilizza una regex per verificare se l'ID è numerico
      let id = this.id;
      if (id && /^[0-9]+$/.test(id)) {
        let elementId = this.id;
        let elementLevel = $(this).parents('.container-pages').length;

        if (elementLevel > 1) {
          elementLevel = elementLevel - 1
        }
        orderedItems.push({
          id: elementId,
          livello: elementLevel
        });
      }
    });

    let additionalData = {
      luna_product_id: <?= $prod_id ?>
    };

    let postData = {
      orderedItems: JSON.stringify(orderedItems),
      additionalData: JSON.stringify(additionalData)
    };

    console.log(orderedItems);
    // Funzione per mostrare l'alert di Bootstrap
    function showAlert(message, type) {
      $('#alert-placeholder').html(
        '<div class="alert alert-' + type + ' alert-dismissible fade show" role="alert">' +
        message +
        '<button type="button" class="btn-close" data-dismiss="alert" aria-label="Close">' +
        '<span aria-hidden="true">&times;</span>' +
        '</button>' +
        '</div>'
      );
    }
    // Invia l'array al server utilizzando AJAX

    $.ajax({
      url: 'core/mngLunaOrder.php', // URL della pagina PHP per il salvataggio
      method: 'POST', // Metodo HTTP da utilizzare
      data: postData, // Dati da inviare (convertiti in stringa JSON)
      success: function(response) {
        if (response.success) {
          showAlert(response.message, 'success');
        } else {
          showAlert(response.message, 'danger');
        }
      },
      error: function(xhr, status, error) {
        console.error('Errore AJAX:', error);
        $('.alert-danger').html('Si è verificato un errore durante la richiesta AJAX.').fadeIn();
      }
    });
  });
</script>