<main class="content">
  <div class="page-header">
    <h1 class="text-center">User Profile</h1>
  </div>
  <div class="container">
    <dl class="dl-horizontal">
      <dt>Email: </dt>
      <dd><?php echo $email; ?></dd>
      <dt>First name:</dt>
      <dd><?php echo $fname; ?></dd>
      <dt>Last Name:</dt>
      <dd><?php echo $lname; ?></dd>
      <dt>Email notifications:</dt>
      <dd><?php echo ($email_notif === 1) ? 'On' : 'Off';?></dd>
      <?php if(!$verified): ?>
        <dt>Reminder:</dt>
        <span class="error">
          <dd>
            Please verify your email address. Please check your spam folder.
            If you need another verification, click the button below.
          </dd>
        </span>
      <?php endif; ?>
    </dl>
    <div class="row">
      <div class="<?php echo $verified ? 'col-sm-3' : 'col-sm-1'; ?>">
      </div>
      <div class="col-sm-3">
        <a href="<?php echo site_url().'/site/user_profile_edit'?>">
          <button class="btn btn-primary btn-block">Edit Profile</button>
        </a>
      </div>
      <?php if(!$verified):?>
        <div class="col-sm-4">
          <a href="<?php echo site_url().'/site/resend_verification'?>">
            <button class="btn btn-primary btn-block">Resend Verification</button>
          </a>
        </div>
      <?php endif; ?>
      <div class="col-sm-3">
        <a href="<?php echo site_url().'/site/user_page'?>">
          <button class="btn btn-primary btn-block">Back</button>
        </a>
      </div>
      <div class="col-sm-3">
      </div>
    </div>
  </div>
</main>
