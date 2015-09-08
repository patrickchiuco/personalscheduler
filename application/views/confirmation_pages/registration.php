<main>
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Registration Error</h3>
      <div class="confirmation-messages-front-page text-center">
        <?php echo $this->lang->line("registration_failed");?>
        <div class="row back-nav-front-page">
          <div class="col-sm-4">
          </div>
          <div class="col-sm-4">
            <div class="text-center">
              <a href="<?php echo site_url().'/site/login';?>">
                <button type="button" class="btn btn-primary btn-block">Log in Page</button>
              </a>
            </div>
          </div>
          <div class="col-sm-4">
          </div>
        </div>

      </div>
    </div>
    <div class="col-xs-1 col-md-3">
    </div>
  </div>

</main>
