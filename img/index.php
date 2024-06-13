<?php
function b64()
{
  $img_file = 'foto3.jpg';

  // Load file contents into variable
  $bin = file_get_contents($img_file);
  
  // Encode contents to Base64
  $img_string = base64_encode($bin);
  // header("Content-type: image/png");
  // $base64 = base64_decode($img_string);

  return $img_string;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body>
  <h1>imagem</h1>
  <?php
  $img = b64();
  echo $img;
  echo '<img src="data:image/png; base64,'.$img.'" alt="" style="max-width: 50px; max-height: 50px;">';
  ?>
</body>

</html>