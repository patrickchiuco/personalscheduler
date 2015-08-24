<?php $this->load->view("common_views/header")?>
<div id="main_content">
  <div class="jumbotron">
    <h1 class="text-center"><?php echo $page_title; ?></h1>
  </div>
  <?php $this->load->view($main_content)?>
</div>
<?php $this->load->view("common_views/footer")?>
