<?php

$luna->table = 'luna_products';
$stmt = $luna->showAll('id');

?>
<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$allLunaProducts_title?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?= $common_dashboard ?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
          <?=$allLunaProducts_title?>
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
    <div class="card-header"><?=$allLunaProducts_title?> &nbsp; &nbsp; &nbsp;
      <a href="index.php?p=addLunaProduct" class="btn icon icon-left btn-success shadow"><i data-feather="plus-circle"></i> <?=$allLunaProducts_add?></a>
    </div>
    <div class="card-body">
      <table class="table" id="table">
        <thead>
          <tr>
            <th><?=$allLunaProducts_name?></th>
            <th><?=$allLunaProducts_version?></th>
            <th><?= $common_actions ?></th>
          </tr>
        </thead>
        <tbody>

          <?php
          while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
          ?>
            <tr>
              <td><?= $row['name'] ?></td>
              <td><?= $row['version'] ?></td>
              <td>
                <a href="index.php?p=allLunaPages&prod=<?= $row['id'] ?>" class="btn icon btn-primary shadow"><?=$allLunaProducts_manage_pages?> <i class="bi bi-book"></i></a>
                &nbsp; &nbsp;
                <a href="index.php?p=editLunaProduct&idToMod=<?= $row['id'] ?>" class="btn icon btn-warning shadow"><?=$allLunaProducts_edit?> <i class="bi bi-pencil-square"></i></a>
                &nbsp; &nbsp;
                <a href="#" class="btn icon btn-info shadow" data-bs-toggle="modal" data-bs-target="#clone<?= $row['id'] ?>"><?=$allLunaProducts_clone?> <i class="bi bi-plus-circle"></i></a>
                &nbsp; &nbsp;
                <a href="#" class="btn icon btn-danger shadow" data-bs-toggle="modal" data-bs-target="#danger<?= $row['id'] ?>"><?=$allLunaProducts_delete?> <i class="bi bi-trash"></i>
                </a>

                <!--Clone theme Modal -->
                <div class="modal fade text-left" id="clone<?= $row['id'] ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel120" aria-hidden="true">
                  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                      <div class="modal-header bg-info">
                        <h5 class="modal-title white" id="myModalLabel120">
                          <?=$allLunaProducts_clone_title?>
                        </h5>
                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                          <i data-feather="x"></i>
                        </button>
                      </div>
                      <div class="modal-body">
                        <form class="form form-horizontal" action="core/mngLuna.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                  <div class="col-md-3">
                                        <label><?=$allLunaProducts_clone_new_name?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="" id="name" name="name" data-parsley-required="true" value="<?= $row['name'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 mb-3">
                                      <span style="font-size:0.9em"><i><?=$allLunaProducts_clone_desc?></i></span>
                                    </div>
                                    <div class="col-md-3">
                                        <label><?=$allLunaProducts_clone_new_version?><span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="" id="version" name="version" data-parsley-required="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="operation" value="clone">
                                    <input type="hidden" name="origin" value="allLunaProducts">
                                    <input type="hidden" name="idToClone" value="<?= $row['id'] ?>">

                                    <div class="col-12 d-flex justify-content-end">
                                      <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow" data-bs-dismiss="modal" >
                                          <?= $common_modal_cancel ?>
                                      </button>
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        
                      </div>
                      <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                        </button>
                        <span class="d-none d-sm-block"><a href="core/mngLuna.php?idToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                            <?= $common_modal_confirm ?>
                          </a></span> 
                      </div>-->
                    </div>
                  </div>
                </div>

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
                        <?=$allLunaProducts_modal_body?>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                          <i class="bx bx-x d-block d-sm-none"></i>
                          <span class="d-none d-sm-block"><?= $common_modal_cancel ?></span>
                        </button>
                        <span class="d-none d-sm-block"><a href="core/mngLuna.php?idProdToDel=<?= $row['id'] ?>" class="btn btn-danger ml-1">
                            <?= $common_modal_confirm ?>
                          </a></span>
                      </div>
                    </div>
                  </div>
                </div>
              </td>
            </tr>




          <?php
          }
          ?>



        </tbody>
      </table>
    </div>
  </div>
</section>