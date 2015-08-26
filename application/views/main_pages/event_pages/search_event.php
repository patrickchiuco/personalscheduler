<div class="jumbotron">
  <h1 class="text-center"><?php echo $page_title; ?></h1>
</div>
<?php if(isset($message)){echo $message;}?>
<div class="container">
  <div class="row">
    <?php if(isset($result)):?>

        <?php foreach($result as $key => $value): ?>
          <h2><?php echo "Matched by ".$key; ?></h2>
          <div><?php echo $value; ?></div>
        <?php endforeach; ?>

    <?php endif; ?>
  </div>
  <a href="<?php echo site_url().'/site/user_page'?>">
    <button type="button" class="btn btn-primary">Back</button>
  </a>
</div>
