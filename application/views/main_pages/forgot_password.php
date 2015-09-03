<main class="container" id="contents">
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Forgot Password</h3>
      <?php echo form_open("site/forgot_password","class='form-horizontal'"); ?>
        <div class="form-group <?php if(form_error("forgot-password-email") != ''){ echo 'has-error'; } ?>">
          <?php echo form_label("Email: ","email",array("class" => "control-label col-xs-2 col-md-2")); ?>
          <div class="col-xs-10 col-md-10">
            <?php echo form_input("forgot-password-email",set_value("forgot-password-email"),"class='form-control' id='email' placeholder='Enter your email.' title='The email you used to log in to the site.' "); ?>
            <span class="error"><?php echo form_error("forgot-password-email");?></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-2">
          </div>
          <div class="col-xs-4">
            <?php echo form_submit("forgot-password","Forgot Password",'class="btn btn-primary btn-block"'); ?>
          </div>
          <div class="col-xs-4">
            <a href=<?php echo site_url().'/site/login/'?>>
              <button type="button" class="btn btn-primary btn-block">Back</button>
            </a>
          </div>
          <div class="col-xs-2">
          </div>
        </div>
        </form>
    </div>
  </div>
</main>
