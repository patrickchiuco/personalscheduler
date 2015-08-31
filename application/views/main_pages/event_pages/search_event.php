<div class="jumbotron">
  <h1 class="text-center"><?php echo $page_title; ?></h1>
</div>
<?php if(isset($message)){echo $message;}?>
<div class="container">
  <div class="row">
      <?php if($has_results):?>
        <?php if(isset($result)):?>
            <?php foreach($result as $key => $value): ?>
              <h2><?php echo "Matched by ".$key; ?></h2>
              <?php foreach($value as $entry): ?>
                <dl class="search-result">
                <dt>Name:</dt>
                <dd><?php echo $entry->name?></dd>
                <dt>Date:</dt>
                <dd><?php echo $entry->date?></dd>
                <dt>Description:</dt>
                <dd><?php echo $entry->description?></dd>
                </dl>
              <?php endforeach; ?>
            <?php endforeach; ?>
        <?php endif; ?>

      <?php else: ?>
        <?php echo $errors; ?>
      <?php endif; ?>
  </div>
  <a href="<?php echo site_url().'/site/user_page'?>">
    <button type="button" class="btn btn-primary">Back</button>
  </a>
</div>
