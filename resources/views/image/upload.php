<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Upload an image</title>
</head>
<body>

  <div style="float: left; margin-right: 20px;">
    <h1>Upload an image by file</h1>

    <p>
      Use this form to upload an image to the service
    </p>

    <form method="post" action="/upload" enctype="multipart/form-data">
      <p>
        <label>Path: <input type="text" name="path"/></label>
      </p>
      <p>
        <label>Image: <input type="file" name="image"/></label>
      </p>
      <p>
        <input type="submit" name="submit" value="Upload image"/>
      </p>
    </form>  
  </div>

  <div style="float: left; margin-right: 20px;">
    <h1>Upload an image by file</h1>

    <p>
      Use this form to upload an image by URL
    </p>

    <form method="post" action="/uploadFromUrl">
      <p>
        <label>Path: <input type="text" name="path"/></label>
      </p>
      <p>
        <label>URL: <input type="text" name="url"/></label>
      </p>
      <p>
        <input type="submit" name="submit" value="Upload image"/>
      </p>
    </form>
  </div>

</body>
</html>
