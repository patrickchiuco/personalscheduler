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
      <dt>Related Images: </dt>
    <?php if(isset($images)):?>
      <dd>
        <ul id="related_imgs">
        <?php foreach($images as $key=>$value):?>
          <li><label><?php echo $value.": ";?></label><img src="<?php echo base_url()."uploads/".$value;?>"></li>
        <?php endforeach; ?>
        </ul>
      </dd>
    <?php else: ?>
      No related files.
    <?php endif; ?>
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
