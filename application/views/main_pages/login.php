<main class="container" id="contents">
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Login</h3>
      <?php echo form_open("site/login","class='form-horizontal'"); ?>
        <div class="form-group <?php if((isset($err_src) && ($err_src == 'e' || $err_src == 'em')) || form_error('email') != ''){echo 'has-error'; }?>">
          <?php echo form_label("Email: ","email",array("class" => "control-label col-xs-3 col-md-3")); ?>
          <div class="col-xs-9 col-md-9">
            <?php echo form_input("email",set_value("email"),"class='form-control' id='email' placeholder='Enter your email.' title='The email you used to log in to the site.' "); ?>
            <span class="error"><?php echo form_error("email");?></span>
            <span class="error"><?php if((isset($err_src) && ($err_src == 'e'))){ echo $errors; }?></span>
          </div>
        </div>
        <div class="form-group <?php if((isset($err_src) && ($err_src == 'm' || $err_src == 'em')) || form_error('password') != ''){echo 'has-error'; }?>">
          <?php echo form_label("Password: ","password",array("class" => "control-label col-xs-3 col-md-3")); ?>
          <div class='col-xs-9 col-md-9'>
            <?php echo form_password("password",set_value("password"),"class='form-control' id='password' placeholder='Enter your password.' title='Your password.' "); ?>
            <span class="error"><?php echo form_error("password"); ?></span>
            <span class="error"><?php if((isset($err_src) && ($err_src == 'em'))){ echo $errors; }?></span>
          </div>
        </div>
        <div class="form-group">
          <div class="col-xs-4">
          </div>
          <div class="col-xs-5">
            <?php echo form_submit("login-button","Login",'class="btn btn-primary btn-block"'); ?>
          </div>
          <div class="col-xs-3">
          </div>
        </div>
        </form>
    </div>
  </div>
  <div class="row">
    <div class="col-xs-2 col-md-4">
    </div>
    <div class="col-xs-4 col-md-2 other-link">
      <div class="text-left"><a href="<?php echo site_url().'/site/register/';?>" class="text-center">Create a new account</a></div>
    </div>
    <div class="col-xs-4 col-md-2 other-link">
      <div class="text-right"><a href="<?php echo site_url().'/site/forgot_password'?>">Forgot Password</a></div>
    </div>
    <div class="col-xs-2 col-md-4">
    </div>
  </div>
</main>
