<?php 
  if(isset($_FILES['image']['name'])){
    $image = $_FILES['image']['name'];
    $image_temp = $_FILES['image']['tmp_name'];
    print_r($_FILES);
  }
  else{
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
      <img id="photo"  alt="The screen capture will appear in this box."> 
    </div>
  </div>

  <form enctype="multipart/form-data" action="#" method="post" >
    <input type="hidden" name="image" id="image" value="">
    <input type="submit" value="Submit" name="submit" >
  </form>
</body>
</html>