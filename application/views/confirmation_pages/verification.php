<main class="container" id="contents">
    <?php //echo validation_errors("<div class='error'>","</div>");?>
  <div class="row">
    <div class="col-xs-1 col-md-3">
    </div>
    <div id="main-div" class="row col-xs-10 col-md-6 rounded-corners-5">
      <div class="site-banner"><h2 class="text-center">Chronos</h2></div>
      <h3 id="page-subtitle" class="text-center">Confirmation</h3>
      <div class="text-center confirmation-messages"><?php print_r($message["success"]);?></div>
      <div class="row">
        <div class="col-xs-4">
        </div>
        <div class="col-xs-4">
          <div class="text-center">
            <a href="<?php echo site_url().'/site/'?>">
              <button class="btn btn-primary btn-block">Home Page</button>
            </a>
          </div>
        </div>
        <div class="col-xs-4">
        </div>
      </div>

      </div>

    <div class="col-xs-1 col-md-3">
    </div>
    </div>
</main>
