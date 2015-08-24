<main class="content">
  <h2 class="text-center">Add Event Page</h2>
  <?php echo form_open("events/add_event");?>
  <?php echo validation_errors("<div class='errors'>","</div>");?>
  <?php if(isset($errors)){echo $errors;} ?>
  <div class="form-group">
    <?php echo form_label("Name: ","event_name"); ?>
    <?php echo form_input("event_name",set_value("event_name"),"id='event_name'");?>
  </div>
  <div class="form-group">
    <?php echo form_label("Description: ","event_desc");?>
    <?php echo form_textarea("event_desc",set_value("event_desc"),'id="event_desc",rows="5",cols="40"')?>
  </div>
  <div class="form-group">
    <?php echo form_submit("add-event","Add Event",'class="btn btn-primary"');?>
    <a href="<?php echo site_url().'/site/user_page';?>">
      <?php echo form_button("user-page","Back",'id="user-page" class="btn btn-primary"')?>
    </a>
  </div>
</main>
