<main class="container">
  <h2 class="text-center">Registration Form</h2>
  <?php echo validation_errors("<div class='error'>","</div>");?>
  <?php if(isset($errors)){ echo $errors; }?>
  <?php echo form_open("site/register",'class="form-horizontal"');?>
    <div class="form_group">
      <?php echo form_label("Email","email"); ?>
      <?php echo form_input("email",set_value("email"),"id='email'");?>
    </div>
    <div class="form_group">
      <?php echo form_label("Password","password"); ?>
      <?php echo form_password("password",set_value("password"),"id='password'");?>
    </div>
    <div class="form_group">
      <?php echo form_label("First name:","fname"); ?>
      <?php echo form_input("fname",set_value("fname"),'id="fname"');?>
    </div>
    <div class="form_group">
      <?php echo form_label("Middle name:","mname"); ?>
      <?php echo form_input("mname",set_value("mname"),'id="mname"');?>
    </div>
    <div class="form_group">
      <?php echo form_label("Last name:","lname"); ?>
      <?php echo form_input("lname",set_value("lname"),'id="lname"');?>
    </div>
    <div class="form_group">
      <?php echo form_label("Email notification: ","email_notif");?>
      <?php echo form_label("Yes: ","email_notif_yes")?>
      <?php echo form_radio("email_notif","Yes",TRUE,'id="email_notif_yes"');?>
      <?php echo form_label("No: ","email_notif_no")?>
      <?php echo form_radio("email_notif","No",FALSE,'id="email_notif_no"');?>
    </div>
    <div class="form_group">
      <?php echo form_submit("register-button","Register",'class="btn btn-primary"'); ?>
      <a href="<?php echo site_url().'/site';?>">
        <?php echo form_button("homepage-button","Back",'class="btn btn-primary"'); ?>
      </a>
    </div>
  </form>
</main>
