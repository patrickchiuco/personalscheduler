<main class="content">
  <?php if(!$confirm):?>
    <div class="container">
      <h2>Confirm delete?</h2>
      <div>
        Are you sure you want to delete this event?
      </div>
      <a href="<?php echo site_url().'/events/delete_event/'.$eid.'/1'?>">
        <button type="button">Yes</button>
      </a>
      <a href="<?php echo site_url().'/site/user_page/'?>">
        <button type="button">No</button>
      </a>
    </div>
  <?php else: ?>
    <?php echo $message; ?>
    <a href='<?php echo site_url()."/site/user_page"?>'>
      <button type="button">Back</button>
    </a>
  <?php endif; ?>
</main>
