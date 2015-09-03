<div class="page-header">
  <h1 class="text-center">User Dashboard</h1>
</div>
<main class="container">
  <div class="row dashboard-nav">
    <div class="col-sm-6 text-left">
      <?php echo form_open(site_url()."/events/search/","class='form-inline'");?>
          <div class="form-group">
              <?php echo form_input("search-term","","class='form-control' placeholder='Search'"); ?>
          </div>
        <div class="form-group">
          <?php echo form_submit("submit","Search","class='btn btn-primary btn-block'");?>
        </div>
          </form>
        </div>
      <div class="col-sm-6 text-right">
        <a href="<?php echo site_url().'/site/user_profile';?>">
          <button class="btn btn-primary">Settings</button>
        </a>
        <a href="<?php echo site_url().'/site/logout'?>">
          <button type="button" class="btn btn-primary">Logout</button>
        </a>
      </div>
  </div>
  <?php if(isset($message)){echo $message;}?>
  <?php echo $this->calendar->generate($this->uri->segment(3),$this->uri->segment(4),$events); ?>
  <div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-4">
      <a href="<?php echo site_url().'/events/add_event'?>">
        <button type="button" class="btn btn-primary btn-block">Add Event</button>
      </a>
    </div>
    <div class="col-sm-4">
    </div>
  </div>
</main>
