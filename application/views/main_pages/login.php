
<div class="jumbotron">
  <h1 class="text-center">Login Page</h1>
</div>
<main class="container">
  <h2 class="text-center">Login Form</h2>
  <div class="row">
    <?php echo form_open("site/login","class='form-horizontal'"); ?>
      <div class="form-group">
        <?php echo form_label("Username: ","username",array("class" => "form-label col-xs-3 col-md-1")); ?>
        <div class="col-xs-9 col-md-11">
          <?php echo form_input("username",set_value("username"),"class='form-control' id='username'")."<br/>"; ?>
        </div>
      </div>
      <div class="form-group">
        <?php echo form_label("Password: ","password",array("class" => "form-label col-xs-3 col-md-1")); ?>
        <div class='col-xs-9 col-md-11'>
          <?php echo form_input("password",set_value("password"),"class='form-control' id='password'")."<br/>"; ?>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-2 col-md-5">
        </div>
        <div class="col-xs-4 col-md-1">
          <?php echo form_submit("login-button","Login",'class="btn btn-primary"'); ?>
        </div>
        <div class="col-xs-4 col-md-1">
          <a href="site/register">
            <?php echo form_button("register","Register",'class="btn btn-primary"'); ?>
          </a>
        </div>
        <div class="col-xs-2 col-md-5">
        </div>
      </div>
  </div>
  </form>
</main>
