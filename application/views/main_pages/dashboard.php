<div class="jumbotron">
  <h1 class="text-center"><?php echo $page_title; ?></h1>
</div>
<?php if(isset($message)){echo $message;}?>
<?php  echo $this->calendar->generate($this->uri->segment(3),$this->uri->segment(4),$events); ?>
