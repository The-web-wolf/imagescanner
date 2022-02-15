<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  // OKAY I SEE THAT THE REASON THIS DID NOT WORK, IS THE BASE64 IS PASSED AS POST NOT FILE,
  // SO HERE IS THE SOLUTION


  // if there's file (that is form was submitted from desktop)
  if (isset($_FILES['image']['name'])) {
    // this is the file ( you can move_uploaded with this)
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    $image_size = $_FILES['image']['size'];
    $image_error = $_FILES['image']['error'];

    // upload file to server ( done some error handling, you an save the path to database)
    $image_ext = explode('.', $image);
    $image_ext = strtolower(end($image_ext));

    $allowed = array('jpg', 'jpeg', 'png');

    if (in_array($image_ext, $allowed)) {
      if ($image_error === 0) {
        if ($image_size <= 1000000) {
          $image_destination = 'uploads/' . uniqid('', true) . '.' . $image_ext;
          move_uploaded_file($image_temp, $image_destination);
          echo '<img src="' . $image_destination . '" alt="">';
        } else {
          echo 'File is too big';
        }
      } else {
        echo 'There was an error uploading your file';
      }
    } else {
      echo 'You cannot upload files of this type';
    }
  } else if (isset($_POST['image'])) {
    // this is the base64 (from mobile), i will parse and upload it as well
    $data = $_POST['image'];
    if (preg_match('/^data:image\/(\w+);base64,/', $data, $type)) {
      $data = substr($data, strpos($data, ',') + 1);
      $type = strtolower($type[1]); // jpg, png, gif

      if (!in_array($type, ['jpg', 'jpeg', 'png'])) {
        echo ('invalid image type');
      }
      $data = str_replace(' ', '+', $data);
      $data = base64_decode($data);

      if ($data === false) {
        echo ('base64_decode failed');
      }
    } else {
      echo ('did not match data URI with image data');
    }
    $image_destination = 'uploads/' . uniqid('', true) . '.' . $type;

    file_put_contents($image_destination, $data);
  }

  // IF ALL IS WELL, you can save this to the database
  echo $image_destination;
} else {
  echo "Please select an image";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="main.css">
  <script src="capture.js" async></script>
</head>

<body>

  <div class="contentarea">
    <p class="instruction">
      Focus the card on the borders of the camera, recapture until you are satisfied with the result then submit
    </p>
    <div class="camera">
      <video id="video">Video stream not available.</video>
      <button id="startbutton">Capture</button>
    </div>
    <canvas id="canvas">
    </canvas>
    <div class="output">
      <img id="photo" alt="The screen capture will appear in this box.">
    </div>
  </div>

  <form enctype="multipart/form-data" action="#" method="post">
    <input type="hidden" name="image" id="image">
    <input type="submit" value="Submit" name="submit">
  </form>
</body>

</html>