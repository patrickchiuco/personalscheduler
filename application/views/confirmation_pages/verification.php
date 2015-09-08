<main class="container" id="contents">
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Confirmation</h3>
      <div class="text-center confirmation-messages">
        <?php if(isset($sent)):?>
          <?php if($sent):?>
            <?php if($resent):?>
              <?php echo $this->lang->line("ver_email_was_resent");?>
            <?php else:?>
              <?php echo $this->lang->line("ver_email_was_sent");?>
            <?php endif; ?>
             <?php echo $resent ? 'resent' : 'sent';?>
          <?php else: ?>
            <?php echo $this->lang->line("resending_verification_failed");?>
          <?php endif; ?>
          <div class="row back-nav-front-page">
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4">
              <div class="text-center">
                <a href="<?php echo site_url().($resent ? '/site/user_page' : '/site/login')?>">
                  <button class="btn btn-primary btn-block"><?php echo $resent ? 'Dashboard' : 'Log in';?></button>
                </a>
              </div>
            </div>
            <div class="col-xs-4">
            </div>
          </div>
        <?php else: ?>
          <?php if($verified):?>
            Email verification successful!
          <?php else: ?>
            Sorry unable to verify your email.
          <?php endif; ?>

          <div></div>
          <div class="row">
            <div class="col-xs-4">
            </div>
            <div class="col-xs-4">
              <div class="text-center">
                <a href="<?php echo site_url().($logged_in ? '/site/user_page' : '/site/login');?>">
                  <button class="btn btn-primary btn-block"><?php echo $logged_in ? 'Dashboard' : 'Log in';?></button>
                </a>
              </div>
            </div>
            <div class="col-xs-4">
            </div>
          </div>
        <?php endif; ?>
      </div>


      </div>

    <div class="col-xs-1 col-md-3">
    </div>
    </div>
</main>
