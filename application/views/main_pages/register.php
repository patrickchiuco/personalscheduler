<main class="container" id="contents">
    <?php //echo validation_errors("<div class='error'>","</div>");?>
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Registration</h3>
      <?php echo form_open("site/register","");?>
          <div class="form-group <?php if(form_error('email') != ''){echo 'has-error'; }?>">
            <?php echo form_label("Email: ","email",array("class" => "control-label")); ?>
            <?php echo form_input("email",set_value("email"),"id='email' class='form-control' placeholder='Enter your email.' title='Please enter a valid email address'");?>
            <span class="error"><?php echo form_error("email");?></span>
          </div>
          <div class="form-group <?php if(form_error('password') != ''){echo 'has-error'; }?>">
            <?php echo form_label("Password: ","password",array("class" => "control-label")); ?>
            <?php echo form_password("password",set_value("password"),"id='password' class='form-control' placeholder='Enter a password.' title='Minimum lenght is 8'");?>
            <span class="error"><?php echo form_error("password");?></span>
          </div>
          <div class="form-group <?php if(form_error('con_password') != ''){echo 'has-error'; }?>">
            <?php echo form_label("Confirm Password: ","con_password",array("class" => "control-label")); ?>
            <?php echo form_password("con_password",set_value("con_password"),"id='con_password' class='form-control' placeholder='Confirm the typed password.' title='Minimum lenght is 8'");?>
            <span class="error"><?php echo form_error("con_password");?></span>
          </div>
          <div class="form-group <?php if(form_error('fname') != ''){echo 'has-error'; }?>">
            <?php echo form_label("First name:","fname",array("class" => "control-label")); ?>
            <?php echo form_input("fname",set_value("fname"),'id="fname" class="form-control" placeholder="Enter your first name." title="Your first name" ');?>
            <span class="error"><?php echo form_error("fname");?></span>
          </div>
          <div class="form-group <?php if(form_error('lname') != ''){echo 'has-error'; }?>">
            <?php echo form_label("Last name:","lname",array("class" => "control-label")); ?>
            <?php echo form_input("lname",set_value("lname"),' id="lname" class="form-control" placeholder="Enter your last name." title="Your last name" ');?>
            <span class="error"><?php echo form_error("lname");?></span>
          </div>
          <div class="form-group">
            <?php echo form_label("Email notification: ","email_notif", array("class" => "control-label"));?>
            <label class="checkbox-inline control-label" for="email_notif_yes" title="Check yes if you want your events mailed to you.">
                <?php echo form_radio("email_notif","Yes",($wants_email == 1) ? 1 : 0,'id="email_notif_yes" title="Check yes if you want your events mailed to you." ');?> Yes
            </label>
            <label class="checkbox-inline control-label" for="email_notif_no" title="Check no if you don't want your events sent to you.">
              <?php echo form_radio("email_notif","No",($wants_email == 1) ? 0 : 1,'id="email_notif_no" title="Check no if you don\'t want your events sent to you." ');?> No
            </label>
          </div>
          <div class="form-group">
            <div class="text-center">
              <div class="col-xs-4">
              </div>
              <div class="col-xs-4">
                <?php echo form_submit("register-button","Register",'class="btn btn-primary btn-block"'); ?>
              </div>
              </div>
              <div class="col-xs-4">
              </div>
            </div>
          </div>
        </form>
    </div>
    <div class="col-xs-1 col-md-3">
    </div>
    </div>
    <div class="row">
      <div class="col-xs-1 col-md-5">
      </div>
      <div class="col-xs-10 col-md-2 other-link">
        <a href="<?php echo site_url().'/site/login';?>" class="text-center">Back to the login page.</a>
      </div>
      <div class="col-xs-1 col-md-5">
      </div>
    </div>
</main>
