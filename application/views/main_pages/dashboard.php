<div class="jumbotron">
  <h1 class="text-center"><?php echo $page_title; ?></h1>
</div>
<div class="container">
  <h2>User: <?php echo $email;?></h2>
  <?php if(isset($message)){echo $message;}?>
  <div class="row">
      <?php echo form_open(site_url()."/events/search/");?>
          <div class="form-group">
            <div class="col-xs-8 col-md-3">
              <?php echo form_input("search-term","Search here","class='form-control'"); ?>
            </div>
            <?php echo form_submit("submit","Search","class='col-xs-2 col-md-3'");?>
          </div>
      </form>
  </div>
  <?php echo $this->calendar->generate($this->uri->segment(3),$this->uri->segment(4),$events); ?>
  <a href="<?php echo site_url().'/events/add_event'?>">
    <button type="button" class="btn btn-primary">Add Event</button>
  </a>

  <a href="<?php echo site_url().'/site/logout'?>">
    <button type="button" class="btn btn-primary">Logout</button>
  </a>
</div>
