<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Dashboard</title>
</head>
<body>

  <h1>Upload an image</h1>

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

</body>
</html>
