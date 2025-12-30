<?php

require "login-header.php" ;

?>
   <div class="row p-3">
    <div class="col-3 d-none d-md-block">&nbsp;</div>

    <div class="col-6">
        <?php

        // require of all alert files
        require "login-alert.php";
        ?>

<?php
                if($op==""){
            ?>
            <h1 class="auth-title"><?=$forgot_title?></h1>
            <p class="auth-subtitle mb-5"><?=$forgot_desc?></p>

            <form action="../admin/core/<?=$mng?>.php" method="POST"  data-parsley-validate>
                <div class="form-group position-relative has-icon-left mb-4">
                    <div class="form-check mandatory">
                        <input type="email" name="email" class="form-control form-control-xl" placeholder="Email"
                                        data-parsley-required="true">
                        <!-- <div class="form-control-icon">
                            <i class="bi bi-envelope"></i>
                        </div> -->
                    </div>
                </div>
				<input type="hidden" name="resetForm" value="resetForm" />

                <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$forgot_button?></button>
            </form>
            <div class="text-center mt-5 text-lg fs-4">
                <p class='text-gray-600'><a href="login.php" class="font-bold"><-- <?=$login_title?></a>
                </p>
            </div> 
           
            <?php
            }else if($op=="reset"){
                $email=filter_input(INPUT_GET, "email");
                $account->email=$email;
                $token=filter_input(INPUT_GET, "token");
                $account->token=$token;
                $curDate=date("Y-m-d H:i:s");
                
                $pswTmp = $account->getPswTmpData();

                if(!$pswTmp['token']){	
                    
            ?>


            
                <a href="login.php"><-- <?=$log_back?></a>				


                <?php	
                }else{
                    $account->getExpDate();
                    $expDate=$account->expDate;
                    if($expDate>=$curDate){
                ?>	

            <h1 class="auth-title"><?=$forgot_choose?></h1>

            <form action="admin/core/<?=$mng?>.php" method="POST"  data-parsley-validate>
              <div class="form-group position-relative has-icon-left mb-4">
                <div class="form-check mandatory">
                    <input
                    type="password"
                    class="form-control form-control-xl"
                    placeholder="Password"
                    name="password"
                    data-parsley-required="true"
                    />
                </div>
                <div class="form-control-icon">
                  <i class="bi bi-shield-lock"></i>
                </div>
              </div>
			<input type="hidden" name="resetMail" value="resetMail" />
			<input type="hidden" name="email" value="<?=$email?>" />

              <button class="btn btn-primary btn-block btn-lg shadow-lg mt-5"><?=$forgot_button?></button>

            </form>

                <?php
                    } else {
                ?>

                    <div class="alert alert-danger">
                        <?=$forgot_token?>
                    </div>
                    <a href="login.php"><-- <?=$log_back?></a>

                <?php
                    }
                }
                
                $account->deleteFromTable('email','password_reset_temp');
            } 
         ?>
 </div>
      <div class="col-3 d-none d-md-block">&nbsp;</div>

    </div>

    
    <?php
    require "login-footer.php";
    ?>
  </body>
</html>