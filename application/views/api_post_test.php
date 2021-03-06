<main class="content">
  <h2 class="text-center">Add Event API TEST</h2>
    <div class="container">
    <?php echo form_open("scheduler_api/event/",'',array("email" => "bently.ackerman@gmail.com", "eid" => 17));?>
    <div class="form-group">
      <?php echo form_label("Name: ","event_name"); ?>
      <?php echo form_input("event_name",set_value("event_name"),"id='event_name' placeholder=\"John Doe's Birthday\" class='form-control'");?>
    </div>
    <div class="form-group">
      <?php echo form_label("Date: ","event_date"); ?>
      <?php echo form_input("event_date",set_value("event_date"),"id='event_date' placeholder='YYYY-mm-dd' class='form-control'");?>
    </div>
    <div class="form-group">
      <?php echo form_label("Description: ","event_desc");?>
      <?php echo form_textarea("event_desc",set_value("event_desc"),'id="event_desc",rows="5",cols="40" placeholder="John Doe\'s House" class="form-control"')?>
    </div>
    <div class="form-group">
      <?php echo form_submit("add-event","Add Event",'class="btn btn-primary"');?>
      <a href="<?php echo site_url().'/site/user_page';?>">
        <?php echo form_button("user-page","Back",'id="user-page" class="btn btn-primary"')?>
      </a>
    </div>
  </div>
</main>
