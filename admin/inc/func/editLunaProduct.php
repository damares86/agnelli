<?php

$idToMod = filter_input(INPUT_GET, "idToMod");
$luna->table = 'luna_products' ;
$luna->id = $idToMod;
$stmt = $luna->showAllWhere('id', ['id']);

?>

<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?=$editLunaProduct_header?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                    <?=$editLunaProduct_header?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>

<?php
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);

?>

    <section class="section">
        <div class="row">
            <div class="col-md-8 col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title"><?=$editLunaProduct_title?>: <?= $row['name'] ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                            <form class="form form-horizontal" action="core/mngLuna.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                                <div class="form-body">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label><?=$editLunaProduct_name?><span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="text" value="<?= $row['name'] ?>" class="form-control" placeholder="" id="first-name" name="name" data-parsley-required="true" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3">
                                            <label><?=$editLunaProduct_version?><span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9">
                                            <div class="form-group">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="text" value="<?= $row['version'] ?>" class="form-control" placeholder="" name="version" data-parsley-required="true" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                }
                                    ?>

                                    <input type="hidden" name="operation" value="editLunaProduct">
                                    <input type="hidden" name="idToMod" value="<?= $idToMod ?>">
                                    <input type="hidden" name="origin" value="editLunaProduct">

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
            <div class="col-md-4 col-12">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="card-title"><?= $common_info ?></h4>
                    </div>
                    <div class="card-content">
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>