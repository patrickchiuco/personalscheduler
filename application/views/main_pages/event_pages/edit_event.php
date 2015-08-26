<main class="content">
  <h2 class="text-center">Edit Event Page</h2>
  <div class="container">
    <?php if(!$update_done):?>
      <?php echo form_open("events/edit_event/".$eid,array("class" => "form form-horizontal","id"=>"edit-form"));?>
      <?php echo validation_errors("<div class='errors'>","</div>");?>
      <?php if(isset($errors)){echo $errors;} ?>
      <div class="form-group">
        <?php echo form_label("Name: ","ename"); ?>
        <?php echo form_input("ename",$ename,"id='ename'");?>
      </div>
      <div class="form-group">
        <?php echo form_label("Description: ","edesc");?>
        <?php echo form_textarea("edesc",$edesc,'id="edesc",rows="5",cols="40"')?>
      </div>
      <div class="form-group">
        <?php echo form_label("Date: ","edate");?>
        <?php echo form_input("edate",$edate,'id="edate",rows="5",cols="40",placeholder="YYYY-mm-dd"')?>
      </div>
      <div class="form-group">
        <?php echo form_submit("edit-event","Update Event",'class="btn btn-primary"');?>
        <a href="<?php echo site_url().'/site/user_page';?>">
          <?php echo form_button("user-page","Back",'id="user-page" class="btn btn-primary"')?>
        </a>
      </div>
    <?php else: ?>
      <div>
        <?php echo $message; ?>
      </div>
      <a href="<?php echo site_url().'/site/user_page';?>">
        <button type="button" class="btn btn-primary">Back</button>
      </a>
    <?php endif; ?>
  </div>
</main>
