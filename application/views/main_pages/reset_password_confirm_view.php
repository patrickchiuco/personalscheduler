<main class="container" id="contents">
  <div class="row">
    <div class="col-xs-1 col-sm-2">
    </div>
    <div id="main-div" class="row col-xs-10 col-sm-8 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Reset Password</h3>
      <?php if($updated):?>
        <div class="confirmation-messages-front-page text-center">
          Your password has been successfully reset.
        </div>
      <?php else: ?>
        <div class="confirmation-messages-front-page text-center">
          Something went wrong when resetting. Please contact your administrator.
        </div>
      <?php endif; ?>
      <div class="text-center">
        <a href="<?php echo site_url().'/site/login'?>">
          <button type="button" class="btn btn-primary">Login Page</button>
        </a>
      </div>
    </div>
    <div class="col-sm-2">
    </div>
  </div>
</main>
