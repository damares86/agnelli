<?php
$registry->table = "registry_entry" ;
$registry->id = filter_input(INPUT_GET, "idToMod");
$stmt1 = $registry->showAllWhere('id', ['id']);


$url_tablePage = filter_input(INPUT_GET, 'tablePage');
$url_pageName = filter_input(INPUT_GET, 'pageName');
?>
<div class="page-heading">
    <div class="page-title">
        <div class="row">
            <div class="col-12 col-md-6 order-md-1 order-last">
                <h3 class="d-inline">Modifica contatto</h3>
                <a href="index.php?p=<?=$url_pageName?>&tablePage=<?=$url_tablePage?>&pageName=<?=$url_pageName?>" class="btn icon btn-info shadow mx-3 px-3">
                    <i class="bi bi-arrow-left-circle"></i> &nbsp; <?=$common_back?>
                </a>
            </div>
            <div class="col-12 col-md-6 order-md-2 order-first">
                <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="index.php"><?= $common_dashboard ?></a>
                        </li>
                        <li class="breadcrumb-item active" aria-current="page">
                            Modifica contatto
                        </li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>
    <br>

    <?php
    $id = "";
    $name = "";
    $company = "";
    $email = "";
    $address = "";
    $number = "";
    $registry_category_id = "";
    $notes = "";

    while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)) {
        extract($row1);

        $id = $row1['id'];
        $name = $row1['name'];
        $company = $row1['company'];
        $email = $row1['email'];
        $address = $row1['address'];
        $registry_category_id = $row1['registry_category_id'];
        $notes = $row1['notes'];
   }
   
    ?>

    <section class="section">
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title">Modifica contatto: <b><?= $name ?></b> </h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="core/mngRegistry.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">
                                   <div class="col-md-3">
                                        <label>Nome <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Nome" id="first-name-icon" name="name" data-parsley-required="true" value="<?= $name ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Ditta <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" placeholder="Ditta" name="company" data-parsley-required="true" value="<?= $company ?>" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Indirizzo </label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea name="address"><?= $address?></textarea>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Numero <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="number" class="form-control" placeholder="Numero" name="number" data-parsley-required="true" value="<?= $number ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label><?= $common_email ?> </label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="email" class="form-control" placeholder="Email" name="email" value="<?= $email ?>" />
                                                    <div class="form-control-icon">
                                                        <i class="bi bi-envelope"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <label>Note </label>
                                    </div>
                                    <div class="col-md-9">
                                        <textarea class="tiny" name="notes"><?= $notes ?></textarea>
                                    </div>

                                    <div class="col-md-3 mt-3">
                                        <label>Categoria <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9 mt-3">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="role" name="registry_category_id">
                                                            <option value=""></option>
                                                            <?php
                                                            $registry->table = "registry_category" ;
                                                            $stmt_cat = $registry->showAll('id');
                                                            while ($row_cat = $stmt_cat->fetch(PDO::FETCH_ASSOC)) {
                                                                $checked = "" ;
                                                                if($row_cat['id'] == $registry_category_id){
                                                                    $selected = "selected";
                                                                }
                                                            ?>

                                                                    <option value="<?= $row_cat['id'] ?>" <?= $selected ?>><?= $row_cat['name'] ?></option>

                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <input type="hidden" name="origin" value="addRegistry">
                                        <input type="hidden" name="operation" value="edit">
                                        <input type="hidden" name="idToMod" value="<?= $id ?>">
                                        <input type="hidden" name="origin" value="editRegistry">
                                        <input type="hidden" name="url_tablePage" value="<?= $url_tablePage ?>">
                                        <input type="hidden" name="url_pageName" value="<?= $url_pageName ?>">

                                        <div class="col-12 d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                                <?= $common_update ?>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4 col-12">
                <div class="card shadow">
                    <h4 class="card-title px-4 pt-3"><?= $common_info ?></h4>
                    <div class="card-content px-5 pb-4">
                        <ul>
                            <li><a href="http://dmweblab.com/portal/manual.php?prod=1&page=6" target="_blank"><?= $common_see_guide ?></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </section>
