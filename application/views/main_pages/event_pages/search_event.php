<main class="content">
  <div class="jumbotron">
    <h1 class="text-center"><?php echo $page_title; ?></h1>
  </div>

  <?php if(isset($message)){echo $message;}?>
  <div class="container">
    <div class="row">
        <?php if($has_results):?>
          <?php if(isset($result)):?>
            <?php if(count($result) > 1):?>
              <div class="panel-group" id="search-accordion">
              <?php foreach($result as $key => $value): ?>
                <div class="panel panel-default">
                  <div class="panel-heading">
                      <a class="search-accordion-heading" href="<?php echo '#panel-'.$key?>" data-toggle="collapse" data-parent="#search-accordion">
                        <?php echo "Matched by ".$key; ?>
                      </a><span class="caret"></span>
                  </div>
                  <div class="panel-collapse collapse" id="<?php echo 'panel-'.$key;?>">
                    <div class="panel-body">
                        <?php $count = 1;?>
                        <?php foreach($value as $entry): ?>
                          <dl class="search-result dl-horizontal">
                          <dt>Result Number:</dt>
                          <dd><?php
                           echo $count;
                           $count++;
                           ?></dd>
                          <dt>Name:</dt>
                          <dd><?php echo $entry->name?></dd>
                          <dt>Date:</dt>
                          <dd><?php echo $entry->date?></dd>
                          <dt>Description:</dt>
                          <dd><?php echo $entry->description?></dd>
                          </dl>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>
              <?php endforeach; ?>
              </div>
            <?php else:?>

            <?php endif;?>
          <?php endif; ?>
        <?php else: ?>
          <div class="confirmation-messages text-center">
            <?php echo $errors; ?>
          </div>
        <?php endif; ?>
    </div>
    <div class="row">
      <div class="col-sm-4"></div>
      <div class="col-sm-4">
        <a href="<?php echo site_url().'/site/user_page'?>">
          <button type="button" class="btn btn-primary btn-block">Back</button>
        </a>
      </div>
      <div class="col-sm-4"></div>
    </div>
  </div>
</main>
