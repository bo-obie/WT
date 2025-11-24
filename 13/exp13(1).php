<?php
$cookie_name="User";
$cookie_value="Max";

setcookie($cookie_name,$cookie_value,time()+(84600*30),"/");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>
<body>
  
<h1>Cookies</h1>

<?php

if(!isset($_COOKIE[$cookie_name])){
  echo"cookie named:". $cookie_name ."is not set";
}
else{
  echo"Cookie" . $cookie_name. "is set";
  echo"Value" . $_COOKIE[$cookie_name];
}



?>

</body>
</html>