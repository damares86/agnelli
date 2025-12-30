<div class="page-title">
    <div class="row">
        <div class="col-12 col-md-6 order-md-1 order-last">
            <h3><?= $allLunaSettings_header ?></h3>
        </div>
        <div class="col-12 col-md-6 order-md-2 order-first">
            <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="index.php"><?= $common_dashboard ?></a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">
                        <?= $allLunaSettings_header ?>
                    </li>
                </ol>
            </nav>
        </div>
    </div>
</div>
<br>
<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?= $settings_all_title ?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngLuna.php" method="POST" enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <?php
                                    $luna->table = 'luna_settings';
                                    $luna->name = 'users';
                                    $stmt = $luna->showAllWhere('id', ['name']);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                        $checked = '';
                                        if ($row['value'] == 1) {
                                            $checked = 'checked';
                                        }
                                    ?>
                                        <div class="col-md-3 mt-2">
                                            <label><?= $allLunaSettings_auth ?></label>
                                        </div>
                                        <div class="col-md-9 mt-2">
                                            <div class="form-group">
                                                <div class="form-check form-switch px-5">
                                                    <input class="form-check-input delete" style="width:3em" type="checkbox" name="users" id="flexSwitchCheckDefault" <?= $checked ?>>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    $luna->table = 'luna_settings';
                                    $luna->name = 'luna_lang';
                                    $stmt = $luna->showAllWhere('id', ['name']);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <div class="col-md-3 border-top my-3 pt-3">
                                            <label><?= $settings_all_lang ?> </label>
                                        </div>
                                        <div class="col-md-9 border-top my-3 pt-3">
                                            <div class="form-group">
                                                <div class="position-relative">
                                                    <fieldset class="form-group">
                                                        <select class="form-select" id="lang" name="luna_lang">
                                                            <?php

                                                            $scan = scandir('locale/');
                                                            $exclude = array('..', '.', '.gitkeep');
                                                            $selected = "";
                                                            foreach ($scan as $folder) {
                                                                if (!in_array($folder, $exclude)) {

                                                                    if ($folder == $row['value']) {
                                                                        $selected = "selected";
                                                                    }

                                                            ?>

                                                                    <option value="<?= $folder ?>" <?= $selected ?>><?= $folder ?></option>

                                                            <?php
                                                                    $selected = "";
                                                                }
                                                            }
                                                            ?>
                                                        </select>
                                                    </fieldset>
                                                </div>
                                            </div>
                                        </div>
                                    <?php
                                    }

                                    $luna->table = 'luna_settings';
                                    $luna->name = 'noreply';
                                    $stmt = $luna->showAllWhere('id', ['name']);
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        extract($row);
                                    ?>
                                        <div class="col-md-3 border-top my-3 pt-3">
                                            <label><?= $settings_all_noreply ?> <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-md-9 border-top my-3 pt-3">
                                            <div class="form-group has-icon-left">
                                                <div class="form-check mandatory">
                                                    <div class="position-relative">
                                                        <input type="email" class="form-control" placeholder="Email" id="first-name-icon" name="noreply" data-parsley-required="true" value="<?= $row['value'] ?>" />
                                                        <div class="form-control-icon">
                                                            <i class="bi bi-envelope"></i>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <?php
                                    }
                                    ?>

                                    <input type="hidden" name="operation" value="settings">
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary me-1 mb-1 shadow">
                                            <?= $common_submit ?>
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