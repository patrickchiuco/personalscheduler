<main class="content">
  <div class="jumbotron">
    <h1 class="text-center">Add Event</h1>
  </div>
    <div class="container">
      <?php if(!$success):?>
        <?php echo form_open_multipart("events/add_event",'',$hidden);?>
        <?php if(isset($errors)){echo $errors;} ?>
        <div class="form-group <?php if(form_error('event_name') != ''){ echo 'has-error';}?>">
          <?php echo form_label("Name: ","event_name",array("class"=>"control-label")); ?>
          <?php echo form_input("event_name",set_value("event_name"),"id='event_name' placeholder=\"John Doe's Birthday\" class='form-control'");?>
          <span class="error"><?php echo form_error("event_name")?></span>
        </div>
        <div class="form-group <?php if(form_error('event_date') != ''){ echo 'has-error';}?>">
          <?php echo form_label("Date: ","event_date",array("class"=>"control-label")); ?>
          <?php echo form_input("event_date",set_value("event_date"),"id='event_date' placeholder='YYYY-mm-dd' class='form-control'");?>
          <span class="error"><?php echo form_error("event_date")?></span>
        </div>
        <div class="form-group <?php if(form_error('event_desc') != ''){ echo 'has-error';}?>">
          <?php echo form_label("Description: ","event_desc",array("class"=>"control-label"));?>
          <?php echo form_textarea("event_desc",set_value("event_desc"),'id="event_desc",rows="5",cols="40" placeholder="John Doe\'s House" class="form-control"')?>
          <span class="error"><?php echo form_error("event_desc")?></span>
        </div>
        <div class="form-group <?php if(form_error('images[]') != ''){ echo 'has-error';}?>">
          <?php echo form_label("Related Image(s) (use shift to select multiple): ","related_files", isset($file_errors) ? array("class"=>"control-label file-error") : array("class"=>"control-label"));?>
          <input type="file" multiple name="images[]" size="20" id="related_files"/>
          <span class="error"><?php echo form_error("images[]");?></span>
        </div>
        <div class="form-group">
          <?php echo form_submit("add-event","Add Event",'class="btn btn-primary"');?>
          <a href="<?php echo site_url().'/site/user_page';?>">
            <?php echo form_button("user-page","Back",'id="user-page" class="btn btn-primary"')?>
          </a>
        </div>
        </form>
      <?php else: ?>
        <div class="confirmation-messages text-center">
          Event Successfully Added
        </div>
        <div class="row">
          <div class="col-sm-5">
          </div>
          <div class="col-sm-2">
            <a href='<?php echo site_url()."/site/user_page/".$curr_year.'/'.$curr_month;?>'>
              <button type="button" class="btn btn-primary btn-block">Dashboard</button>
            </a>
          </div>
          <div class="col-sm-5">
          </div>
        </div>
      <?php endif; ?>
    </div>
</main>
