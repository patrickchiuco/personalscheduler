<main class="content">
  <div class="page-header">
    <h1 class="text-center">User Profile</h1>
  </div>
  <div class="container">
    <div class="form-group">
      <?php echo form_label("Email notification: ","email_notif", array("class" => "control-label"));?>
      <label class="checkbox-inline control-label" for="email_notif_yes" title="Check yes if you want your events mailed to you.">
          <?php echo form_radio("email_notif","Yes",($wants_email == 1) ? 1 : 0,'id="email_notif_yes" title="Check yes if you want your events mailed to you." ');?> Yes
      </label>
      <label class="checkbox-inline control-label" for="email_notif_no" title="Check no if you don't want your events sent to you.">
        <?php echo form_radio("email_notif","No",($wants_email == 1) ? 0 : 1,'id="email_notif_no" title="Check no if you don\'t want your events sent to you." ');?> No
      </label>
    </div>
  </div>
</main>
