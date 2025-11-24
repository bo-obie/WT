<?php
//variables
$name="John";
$Age=24;
$score=92;

//expression
$passed=($score>=50);

//array
$subjects=array("ADS"=>90, "WT"=>85, "AI"=>78);

echo"Student name: $name<br>";
echo"Student age: $Age<br>";

//control structure

if($passed){
  echo"Passed";

}
else{
  echo"failed";
}

echo"<br>Subject Marks<br>";
$total=0;
foreach($subjects as $subject=>$marks){
  echo"$subject=$marks<br>";
  $total+=$marks;
}

$average=$total/count($subjects);
echo"$average<br>";

if($average>=90){
  echo"A Grade";
}
elseif($average>=75){
  echo"B grade";
}
elseif($average>=50){
  echo"C grade";
}
else{
  echo"Failed";
}
?>