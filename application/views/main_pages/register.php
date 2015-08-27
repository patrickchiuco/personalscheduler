<main class="container">
  <h2 class="text-center">Registration Form</h2>
  <?php echo validation_errors("<div class='error'>","</div>");?>
  <?php if(isset($errors)){ echo $errors; }?>
  <div class="row">
  <?php echo form_open("site/register",'class="form-horizontal"');?>
      <div class="form-group">
        <?php echo form_label("Email: ","email",array("class" => "form-label col-xs-2 col-md-1")); ?>
        <div class="col-xs-10 col-md-5">
          <?php echo form_input("email",set_value("email"),"id='email' class='form-control' placeholder='johndoe@domain.com' title='Please enter a valid email address'");?>
        </div>
        <?php echo form_label("Password: ","password",array("class" => "form-label col-xs-2 col-md-1")); ?>
        <div class="col-xs-10 col-md-5">
          <?php echo form_password("password",set_value("password"),"id='password' class='form-control' placeholder='********' title='Minimum lenght is 8'");?>
        </div>
      </div>

      <div class="form-group">
        <?php echo form_label("First name:","fname",array("class" => "form-label col-xs-3 col-md-2")); ?>
        <div class="col-xs-9 col-md-4">
          <?php echo form_input("fname",set_value("fname"),'id="fname" class="form-control" placeholder="John" title="Your first name" ');?>
        </div>
        <?php echo form_label("Middle name:","mname",array("class" => "form-label col-xs-3 col-md-2")); ?>
        <div class="col-xs-9 col-md-4">
          <?php echo form_input("mname",set_value("mname"),'id="mname" class="form-control" placeholder="M." title="Your middle name" ');?>
        </div>
      </div>

      <div class="form-group">
        <?php echo form_label("Last name:","lname",array("class" => "form-label col-xs-3 col-md-2")); ?>
        <div class="col-xs-9 col-md-4">
          <?php echo form_input("lname",set_value("lname"),' id="lname" class="form-control" placeholder="Doe" title="Your last name" ');?>
        </div>
        <?php echo form_label("Email notification: ","email_notif", array("class" => "form-label col-xs-4 col-md-2"));?>
        <label class="checkbox-inline form-label col-xs-3 col-md-1" for="email_notif_yes" title="Check yes if you want your events mailed to you.">
            <?php echo form_radio("email_notif","Yes",($wants_email == 1) ? 1 : 0,'id="email_notif_yes" title="Check yes if you want your events mailed to you." ');?> Yes
        </label>
        <label class="checkbox-inline form-label col-xs-3 col-md-1" for="email_notif_no" title="Check no if you don't want your events sent to you.">
          <?php echo form_radio("email_notif","No",($wants_email == 1) ? 0 : 1,'id="email_notif_no" title="Check no if you don\'t want your events sent to you." ');?> No
        </label>
      </div>

      <div class="form-group">
        <div class="text-center">
          <div class="hidden-xs col-xs-4">
          </div>
          <div class="col-xs-6 col-md-2">
            <?php echo form_submit("register-button","Register",'class="btn btn-primary"'); ?>
          </div>
          <div class="col-xs-6 col-md-2">
            <a href="<?php echo site_url().'/site';?>">
              <?php echo form_button("homepage-button","Back",'class="btn btn-primary"'); ?>
            </a>
          </div>
          <div class="hidden-xs col-xs-4">
          </div>
        </div>
      </div>
    </form>
  </div>
</main>
