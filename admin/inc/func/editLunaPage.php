<?php

$summernote = true;

$prod_id = filter_input(INPUT_GET,'prod') ;
$luna->table = 'luna_products';
$luna->id = $prod_id ;
$prod_stmt = $luna->showAllWhere('id',['id']);
$prod_row = $prod_stmt->fetch(PDO::FETCH_ASSOC) ;
extract($prod_row) ;

// get the product data
$page_id = filter_input(INPUT_GET, 'idToMod');
$luna->table = 'luna_pages_'.$prod_id;

$parent_id = '' ;
$child_id = '' ;

$idToMod = $page_id ;

$luna->id = $page_id;
$stmt = $luna->showAllWhere('id', ['id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);

?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$editLunaPages_product?>: <u><?= $prod_row['name'] ?></u></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$editLunaPages_edit?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header">
                    <div class="card-title">
                        <h5><?=$editLunaPages_edit_title?>: <?= $row['title'] ?></h5>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngLuna.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label><?=$editLunaPages_title?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="first-name-icon" name="title" data-parsley-required="true" value="<?= $row['title'] ?>"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pb-3 mt-2">

                                        <textarea class="tiny" name="content"><?= $row['content'] ?></textarea>

                                    </div>



                                    <input type="hidden" name="operation" value="editPage">
                                    <input type="hidden" name="idToMod" value="<?=$idToMod?>">
                                    <!-- <input type="hidden" name="type" value="<?= $type ?>"> -->
                                    <input type="hidden" name="product_id" value="<?= $prod_id ?>">
                                    <?php
                                    if ($parent_id) {
                                        // è una child
                                    ?>
                                        <input type="hidden" name="parent_id" value="<?= $parent_id ?>">
                                    <?php
                                    }

                                    if ($child_id) {
                                        // è un paragrafo
                                    ?>
                                        <input type="hidden" name="child_id" value="<?= $child_id ?>">
                                    <?php
                                    }
                                    ?>


                                    <!-- <input type="hidden" name="origin" value="addLunaPage&"> -->

                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
                                        </button>
                                        <button type="reset" class="btn btn-light-secondary me-1 mb-1 shadow">
                                            <?= $common_reset ?>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
</section>