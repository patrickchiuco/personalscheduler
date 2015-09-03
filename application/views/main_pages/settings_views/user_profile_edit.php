<main class="content">
  <div class="page-header">
    <h1 class="text-center">User Profile</h1>
  </div>
  <div class="container">
    <?php if(!$db_accessed):?>
    <?php echo form_open("site/user_profile_edit","");?>
        <div class="form-group <?php if(form_error('email') != ''){echo 'has-error'; }?>">
          <?php echo form_label("Email: ","email",array("class" => "control-label")); ?>
          <?php echo form_input("email",isset($email) ? $email : set_value("email"),"id='email' class='form-control' placeholder='Update your email.' title='Place your new email here'");?>
          <span class="error"><?php echo form_error("email");?></span>
        </div>
        <div class="form-group <?php if(form_error('fname') != ''){echo 'has-error'; }?>">
          <?php echo form_label("First name:","fname",array("class" => "control-label")); ?>
          <?php echo form_input("fname", isset($fname) ? $fname : set_value("fname"),'id="fname" class="form-control" placeholder="Enter your first name." title="Your first name" ');?>
          <span class="error"><?php echo form_error("fname");?></span>
        </div>
        <div class="form-group <?php if(form_error('lname') != ''){echo 'has-error'; }?>">
          <?php echo form_label("Last name:","lname",array("class" => "control-label")); ?>
          <?php echo form_input("lname",isset($lname) ? $lname :set_value("lname"),' id="lname" class="form-control" placeholder="Enter your last name." title="Your last name" ');?>
          <span class="error"><?php echo form_error("lname");?></span>
        </div>
        <div class="form-group">
          <?php echo form_label("Email notification: ","email_notif", array("class" => "control-label"));?>
          <label class="checkbox-inline control-label" for="email_notif_yes" title="Check yes if you want your events mailed to you.">
              <?php echo form_radio("email_notif",1,($email_notif == 1) ? 1 : 0,'id="email_notif_yes" title="Turn on for email notifications." ');?> On
          </label>
          <label class="checkbox-inline control-label" for="email_notif_no" title="Check no if you don't want your events sent to you.">
            <?php echo form_radio("email_notif",0,($email_notif == 1) ? 0 : 1,'id="email_notif_no" title="Turn off if you don\'t want to be notified." ');?> Off
          </label>
        </div>
        <div class="form-group">
          <div class="text-center">
            <div class="col-xs-3">
            </div>
            <div class="col-xs-3">
              <?php echo form_submit("register-button","Update",'class="btn btn-primary btn-block"'); ?>
            </div>
            <div class="col-xs-3">
              <a href="<?php echo site_url().'/site/user_page';?>">
                <button type="button" class="btn btn-primary btn-block">Dashboard</button>
              </a>
            </div>
            <div class="col-xs-3">
            </div>
          </div>
        </div>
      <?php echo form_close(); ?>
    <?php else: ?>
      <?php if($updated):?>
        <div class="text-center confirmation-messages">
          Your profile was successfully updated.
        </div>
      <?php else: ?>
        <div class="text-center confirmation-messages">
          Something went wrong with the database. Please contact the admin.
        </div>
      <?php endif; ?>
      <div class="row">
        <div class="col-sm-4">
        </div>
        <div class="col-sm-4">
          <a href="<?php echo site_url().'/site/user_page'?>">
            <button class="btn btn-primary btn-block">Dashboard</button>
          </a>
        </div>
        <div class="col-sm-4">
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>
