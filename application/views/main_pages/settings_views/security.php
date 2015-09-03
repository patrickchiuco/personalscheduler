<main class="content">
  <div class="page-header">
    <h1 class="text-center">User Profile</h1>
  </div>
  




  <?php echo form_open("site/user_profile","");?>
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
  <?php echo form_close();?>
</main>
