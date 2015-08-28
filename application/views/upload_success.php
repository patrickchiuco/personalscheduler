<!DOCTYPE>
<html>
  <head>
    <title>Upload Form</title>
    <meta charset="utf-8">
    <style>
      dt{
        font-weight: bold;
        font-family: sans-serif;
        font-size: 1.1em;
      }
      dd{
        font-family: serif;
        font-size: 0.9em;
      }
    </style>
  </head>
  <body>
    <main>
      <section>
        <h3>Your file was successfully uploaded!</h3>
        <dl>
          <dt>File name:</dt>
          <?php echo "<dd>".$uploadInfo['file_name']."</dd>"; ?>
          <dt>Full path:</dt>
          <?php echo "<dd>".$uploadInfo['full_path']."</dd>"; ?>
          <dt>Size in pixels:</dt>
          <?php echo "<dd>".$uploadInfo['image_size_str']."</dd>";
                //clean up formatting
          ?>
          <dt>Original image:</dt>
          <img alt="Uploaded image" src="<?php echo base_url()."\/uploads\/".$uploadInfo['file_name']?>">
          <dt>File size in kilobytes:</dt>
          <?php echo "<dd>".$uploadInfo['file_size']."</dd>"; ?>
          <dt>Thumbnail name:</dt>
          <?php echo "<dd>".$thumbnail_name."</dd>"; ?>
          <dt>Thumbnail:</dt>
          <img alt="Uploaded image" src="<?php echo base_url()."\/uploads\/".$thumbnail_name?>">
      </dl>
      </section>
    </main>
  </body>
</html>
