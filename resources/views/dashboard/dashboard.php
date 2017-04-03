<?php

/* @var int $storedImagesCount */
/* @var string|null $cdnBaseUrl */

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
  <style type="text/css">
    body {
      font-family: sans-serif;

    }

    .float-left {
      float: left;
    }

    .configuration-container {
      clear: both;
    }

    .configuration {
      background-color: #dddddd;
      padding: 10px;
      margin-right: 10px;
    }

  </style>
</head>
<body>

  <h1>Dashboard</h1>

  <h2>Storage statistics</h2>

  <div class="configuration">
    <p><?php echo $storedImagesCount; ?></p>
  </div>

  <h2>Current configuration</h2>

  <div class="configuration-container">
    <div class="configuration float-left">
      <h3>CDN</h3>
      <p><?php echo $cdnBaseUrl ?: 'N/A'; ?></p>
    </div>
    <div class="configuration float-left">
      <h3>Glide</h3>
      <pre><?php print_r(config('glide')); ?></pre>
    </div>
    <div class="configuration float-left">
      <h3>Presets</h3>
      <pre><?php print_r(config('presets')); ?></pre>
    </div>
  </div>

</body>
</html>
