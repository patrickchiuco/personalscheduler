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
    </dl>
    <div class="row">
      <div class="col-sm-3">
      </div>
      <div class="col-sm-3">
        <a href="<?php echo site_url().'/site/user_profile_edit'?>">
          <button class="btn btn-primary btn-block">Edit Profile</button>
        </a>
      </div>
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
