<?php

$luna->id = filter_input(INPUT_GET,"idToMod");
$luna->table = 'luna_users';
$stmt1 = $luna->showAllWhere('id',['id']);

    while($row1 = $stmt1->fetch(PDO::FETCH_ASSOC))
    {
        extract($row1);

    
?>

<div class="page-title">
  <div class="row">
    <div class="col-12 col-md-6 order-md-1 order-last">
      <h3><?=$editLunaUser_header?></h3>
    </div>
    <div class="col-12 col-md-6 order-md-2 order-first">
      <nav
        aria-label="breadcrumb"
        class="breadcrumb-header float-start float-lg-end"
      >
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="index.php"><?=$common_dashboard?></a>
          </li>
          <li class="breadcrumb-item active" aria-current="page">
            <?=$editLunaUser_header?>
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
                <h4 class="card-title"><?=$editLunaUser_title?>: <u><?=$row1['username']?></u></h4>
                </div>
                <div class="card-content">
                <div class="card-body">
                    <form class="form form-horizontal" action="core/mngLuna.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                    <div class="form-body">
                        <div class="row">
                        <div class="col-md-3">
                            <label><?=$common_name?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$common_name?>"
                                        id="first-name"
                                        name="name"
                                        data-parsley-required="true"
                                        value="<?=$row1['name']?>"
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$common_username?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group has-icon-left">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="text"
                                        class="form-control"
                                        placeholder="<?=$common_username?>"
                                        name="username"
                                        data-parsley-required="true"
                                        value="<?=$row1['username']?>"                                        
                                        />
                                        <div class="form-control-icon">
                                        <i class="bi bi-person"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$common_email?><span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                            <div class="form-group">
                                <div class="form-check mandatory">
                                    <div class="position-relative">
                                        <input
                                        type="email"
                                        class="form-control"
                                        placeholder="Email"
                                        name="email"
                                        data-parsley-required="true"
                                        value="<?=$row1['email']?>"

                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label><?=$editLunaUser_auth?> <span class="text-danger">*</span></label>
                        </div>
                        <div class="col-md-9">
                         <div class="form-group">
                                <select
                                class="choices form-select multiple-remove"
                                multiple="multiple" name="permissions[]"
                                >
                                <?php
                                    $permissions = explode(',',$row1['permissions']) ;
                                    $luna->table = 'luna_products' ;
                                    $stmt = $luna->showAll('id') ; 
                                    
                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC))
                                    {
                                        $selected='';
                                        extract($row);

                                        if(in_array($row['id'],$permissions)){
                                            $selected = 'selected';
                                        }
                                ?>

                                    <option value="<?=$row['id']?>" <?=$selected?>><?=$row['name']?> (v.<?=$row['version']?>)</option>

                                <?php
                                    }
                                
                                ?>

                                </select>
                            </div>
                        </div>

                        
                        
                        <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                        <input type="hidden" name="operation" value="editUser">
                        <input type="hidden" name="origin" value="editLunaUser">
                      
                        <div class="col-12 mt-2 d-flex justify-content-end">
                            <button
                            type="submit"
                            class="btn btn-primary me-1 mb-1 shadow"
                            >
                            <?=$common_submit?>
                            </button>
                            <button
                            type="reset"
                            class="btn btn-light-secondary me-1 mb-1 shadow"
                            >
                            <?=$common_reset?>
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
                    <h4 class="card-title"><?=$common_info?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="row">
        <div class="col-md-8 col-12">
            <div class="card shadow">
                <div class="card-header">
                    <h4 class="card-title"><?=$editLunaUser_psw_title?></h4>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form form-horizontal" action="core/mngLuna.php" method="POST"  enctype="multipart/form-data" data-parsley-validate>
                            <div class="form-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <label><?=$common_password?> <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="form-group has-icon-left">
                                            <div class="form-check mandatory">
                                                <div class="position-relative">
                                                    <input
                                                    type="password"
                                                    class="form-control"
                                                    placeholder="Password"
                                                    name="password"
                                                    data-parsley-required="true"
                                                    />
                                                    <div class="form-control-icon">
                                                    <i class="bi bi-lock"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input type="hidden" name="operation" value="password">
                                    <input type="hidden" name="idToMod" value="<?=$row1['id']?>">
                                    <input type="hidden" name="origin" value="editLunaUser">
                                    <?php
                                    }
                                    ?>
                            
                                    <div class="col-12 d-flex justify-content-end">
                                        <button
                                            type="submit"
                                            class="btn btn-primary me-1 mb-1 shadow"
                                            >
                                            <?=$common_submit?>
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