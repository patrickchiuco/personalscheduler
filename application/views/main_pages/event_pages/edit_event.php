<main class="content">
  <div class="page-header">
    <h1 class="text-center">Edit Event Page</h1>
  </div>
  <div class="container">
    <?php if(!$update_done):?>
      <?php echo form_open_multipart("events/edit_event/".$eid,array("class" => "form form-horizontal","id"=>"edit-form"));?>
      <?php if(isset($errors)){echo $errors;} ?>
      <div class="form-group <?php if(form_error('ename') != ''){ echo 'has-error';}?>">
        <?php echo form_label("Name: ","ename",array("class" => "control-label")); ?>
        <?php echo form_input("ename",$ename,"id='ename' class='form-control'");?>
        <span class="error"><?php echo form_error("ename"); ?></span>
      </div>
      <div class="form-group <?php if(form_error('edate') != ''){ echo 'has-error';}?>">
        <?php echo form_label("Date: ","edate", array("class" => "control-label"));?>
        <?php echo form_input("edate",$edate,'id="edate",rows="5",cols="40",placeholder="YYYY-mm-dd" class="form-control"')?>
        <span class="error"><?php echo form_error("edate"); ?></span>
      </div>
      <div class="form-group <?php if(form_error('edesc') != ''){ echo 'has-error';}?>">
        <?php echo form_label("Description: ","edesc", array("class" => "control-label"));?>
        <?php echo form_textarea("edesc",$edesc,'id="edesc",rows="5",cols="40" class="form-control"')?>
        <span class="error"><?php echo form_error("edesc"); ?></span>
      </div>
      <div class="form-group">
        <?php echo form_label("Related Images (check to delete): ","related_img",array("class" => "control-label"));?>
        <br>
        <?php if(isset($event_images)):?>
          <?php foreach($event_images as $key=>$value):?>
            <label for="<?php echo 'related_img'.$key;?>"><?php echo $value; ?></label>
            <input type="checkbox" name="related_img_del[]" id="<?php echo "related_img".$key; ?>" value="<?php echo $key; ?>">
            <img src="<?php echo base_url()."uploads/".$value;?>">
          <?php endforeach; ?>
        <?php else: ?>
          No related files.
        <?php endif;?>
        <br/>
      </div>
      <div class="form-group <?php if(form_error('images[]') != ''){echo 'has-error';}?>">
        <label for="new_files" class="control-label">Upload more files:</label>
        <input type="file" multiple name="images[]" size="20" id="new_files"/>
        <span class="error"><?php echo form_error("images[]"); ?></span>
      </div>
      <div class="form-group">
        <?php echo form_submit("edit-event","Update Event",'class="btn btn-primary"');?>
        <a href="<?php echo site_url().'/site/user_page';?>">
          <?php echo form_button("user-page","Back",'id="user-page" class="btn btn-primary"')?>
        </a>
      </div>
    <?php else: ?>
      <div class="confirmation-messages text-center">
        <?php echo $message; ?>
      </div>
      <div class="row">
        <div class="col-xs-5">
        </div>
        <div class="col-xs-2">
          <a href="<?php echo site_url().'/site/user_page';?>">
            <button type="button" class="btn btn-primary btn-block">Dashboard</button>
          </a>
        </div>
        <div class="col-xs-5">
        </div>
      </div>
    <?php endif; ?>
  </form>
  </div>
</main>
