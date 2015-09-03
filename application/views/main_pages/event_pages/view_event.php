<main class="content">
  <div class="jumbotron">
    <h1 class="text-center">Event Details</h1>
  </div>
  <div class="container">
    <div class="has-errors">
      <?php if(isset($errors)){ echo $errors;}?>
    </div>
    <dl class="dl-horizontal">
      <dt>Name:</dt>
      <dd><?php echo $event_name; ?></dd>
      <dt>Description:</dt>
      <dd><?php echo $event_desc; ?></dd>
      <dt>Date:</dt>
      <dd><?php echo $event_date?></dd>
      <dt>Related Images: </dt>
      <dd>
        <?php if(isset($images)):?>
            <table class="table table-responsive table-condensed table-bordered">
              <tr>
                <th>
                  File name
                </th>
                <th>
                  Image
                </th>
              </tr>
            <ul id="related_imgs" class="list-unstyled">
            <?php foreach($images as $key=>$value):?>
              <tr>
                <td class="text-center"><?php echo $value;?></td>
                <td class="text-center"><img src="<?php echo base_url()."uploads/".$value;?>"></td>
              </tr>
            <?php endforeach; ?>
            </table>
          </dd>
        <?php else: ?>
          No related files.
        <?php endif; ?>
      </dd>
    </dl>
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-2">
        <a href="<?php echo site_url()."/events/delete_event/".$eid?>">
          <button type="button" class="btn btn-primary btn-block">Delete</button>
        </a>
      </div>
      <div class="col-sm-2">
        <a href="<?php echo site_url()."/events/edit_event/".$eid?>">
          <button type="button" class="btn btn-primary btn-block">Edit</button>
        </a>
      </div>
      <div class="col-sm-2">
        <a href="<?php echo site_url()."/site/user_page"?>">
          <button type="button" class="btn btn-primary btn-block">Back</button>
        </a>
      </div>
      <div class="col-sm-3">
      </div>
    </div>




  </div>
</main>
