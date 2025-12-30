<?php

$summernote = true;

// get the product data
$prod_id = filter_input(INPUT_GET, 'prod');
$luna->table = 'luna_products';
$luna->id = $prod_id;
$stmt = $luna->showAllWhere('id', ['id']);
$row = $stmt->fetch(PDO::FETCH_ASSOC);
extract($row);

$title = $addLunaPages_parent;
// $type = 'parent';

$parent_id = '';
$child_id = '';

if (filter_input(INPUT_GET, 'parent')) {
    $parent_id = filter_input(INPUT_GET, 'parent');
    $title = $addLunaPages_child ;
    // $type = 'child';
}

if (filter_input(INPUT_GET, 'child')) {
    $child_id = filter_input(INPUT_GET, 'child');
    $title = $addLunaPages_paragraph ;
    // $type = 'paragraph';
}

$luna->table = 'luna_pages_'.$prod_id;
$last_stmt = $luna->showAllLimitDesc('id',1);
$last_row = $last_stmt->fetch(PDO::FETCH_ASSOC) ;
if(is_array($last_row)){
    extract($last_row); 
    $last_id = $last_row['id'];
}else{
    $last_id = 0;
}

?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$addLunaPages_product?>: <u><?= $row['name'] ?></u></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?=$addLunaPages_add?> <?= $title ?>
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
                        <h5><?=$addLunaPages_add_title?> <?= $title ?></h5>
                    </div>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngLuna.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-2">
                                        <label><?=$addLunaPages_title?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input type="text" class="form-control" id="first-name-icon" name="title" data-parsley-required="true" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 pb-3 mt-2">

                                        <textarea id="summernote" name="content"></textarea>

                                    </div>



                                    <input type="hidden" name="operation" value="addPage">
                                    <input type="hidden" name="last_id" value="<?=$last_id?>">
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