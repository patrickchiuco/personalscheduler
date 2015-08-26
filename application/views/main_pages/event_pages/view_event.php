<main class="content">
  <div class="container">
    <h2 class="text-center">Event Details</h2>
    <div class="has-errors">
      <?php if(isset($errors)){ echo $errors;}?>
    </div>
    <dl>
      <dt>Name:</dt>
      <dd><?php echo $event_name; ?></dd>
      <dt>Description:</dt>
      <dd><?php echo $event_desc; ?></dd>
      <dt>Date:</dt>
      <dd><?php echo $event_date?></dd>
    </dl>
    <a href="<?php echo site_url()."/events/delete_event/".$eid?>">
      <button type="button" class="btn btn-primary">Delete</button>
    </a>
    <a href="<?php echo site_url()."/events/edit_event/".$eid?>">
      <button type="button" class="btn btn-primary">Edit</button>
    </a>
    <a href="<?php echo site_url()."/site/user_page"?>">
      <button type="button" class="btn btn-primary">Back</button>
    </a>
  </div>
</main>
