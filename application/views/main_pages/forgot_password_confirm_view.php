<main class="container" id="contents">
  <div class="row">
    <div class="col-xs-1 col-sm-2">
    </div>
    <div id="main-div" class="row col-xs-10 col-sm-8 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Forgot Password</h3>
      <?php if($valid_code):?>
        <?php echo form_open("site/forgot_password_confirm/".$code,"class='form-horizontal'"); ?>
            <div class="form-group <?php if(form_error("fpassword") != ''){ echo 'has-error'; }?>">
              <?php echo form_label("Password: ","fpassword", array("class" => "control-label col-sm-3"));?>
              <div class="col-sm-9">
                <?php echo form_password("fpassword",set_value("fpassword"),"class='form-control' id='fpassword' placehodler='Your new password.' title='Type in your new password'");?>
                <span class="error"><?php echo form_error("fpassword");?></span>
              </div>
            </div>
            <div class="form-group <?php if(form_error("fpassword_conf") != ''){ echo 'has-error'; }?>">
              <?php echo form_label("Confirm Password: ","fpassword_conf", array("class" => "control-label col-sm-3"));?>
              <div class="col-sm-9">
                <?php echo form_password("fpassword_conf",set_value("fpassword_conf"),"class='form-control' id='fpassword_conf' placehodler='Retype your new password.' title='Retype your new password.'");?>
                <span class="error"><?php echo form_error("fpassword_conf");?></span>
              </div>
            </div>
          <div class="form-group">
            <div class="col-xs-2">
            </div>
            <div class="col-xs-4">
              <?php echo form_submit("reset-pass-button","Reset Password",'class="btn btn-primary btn-block"'); ?>
            </div>
            <div class="col-xs-4">
              <a href=<?php echo site_url().'/site/login/'?>>
                <button type="button" class="btn btn-primary btn-block">Back</button>
              </a>
            </div>
            <div class="col-xs-2">
            </div>
          </div>
          <div class="col-sm-2">
          </div>
        <?php echo form_close();?>
      <?php else: ?>
        <div class="confirmation-messages-front-page text-center">This email is already invalid. Please reset your password again.</div>
      <?php endif;?>
    </div>
    <div class="col-sm-2">
    </div>
  </div>
</main>
