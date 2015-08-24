<main class="content">
  <h2 class="text-center">Add Event Page</h2>
  <?php echo form_open();?>
  <div class="form-group">
    <?php echo form_label("Name","event_name"); ?>
    <?php echo form_input("email",set_value("email"),"id='description'");?>
  </div>
  <div class="form-group">
    <?php echo form_label("Description","description");?>
    <?php echo form_textarea("description",set_value("description"),'id="description",rows="5",cols="40"')?>
  </div>
  <div class="form-group">
    <?php echo form_submit("Description","description");?>
    <?php echo form_textarea("description",set_value("description"),'id="description",rows="5",cols="40"')?>
  </div>
</main>
