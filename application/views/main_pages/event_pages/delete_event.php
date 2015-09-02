<main class="content">
  <div class="jumbotron">
    <h1 class="text-center"><?php echo $page_name?></h1>
  </div>
  <?php if(!$confirm):?>
    <div class="container">
      <div class="confirmation-messages text-center">
        Are you sure you want to delete this event?
      </div>
      <div class="row">
        <div class="col-xs-3 col-sm-4">
        </div>
        <div class="col-xs-3 col-sm-2">
          <a href="<?php echo site_url().'/events/delete_event/'.$eid.'/1';?>">
            <button type="button" class="btn btn-primary btn-block">Yes</button>
          </a>
        </div>
        <div class="col-xs-3 col-sm-2">
          <a href="<?php echo site_url().'/site/user_page/'.$event_year.'/'.$event_month;?>">
            <button type="button" class="btn btn-primary btn-block">No</button>
          </a>
        </div>
        <div class="col-xs-3 col-sm-4">
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="confirmation-messages text-center">
      <?php echo $message; ?>
    </div>
    <div class="row">
      <div class="col-sm-5">
      </div>
      <div class="col-sm-2">
        <a href='<?php echo site_url()."/site/user_page/".$event_year.'/'.$event_month;?>'>
          <button type="button" class="btn btn-primary btn-block">Back</button>
        </a>
      </div>
      <div class="col-sm-5">
      </div>
    </div>
  <?php endif; ?>
</main>
