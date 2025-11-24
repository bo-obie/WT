

<?php
//single inheritance

class animal{
  public function eat(){
           echo"An Animal can eat.<br>";
  }
}

class dog extends animal{

  public function bark(){
    echo"A dog is an animal which barks and eats.<br>";
  }
}


$dog= new dog();
$dog->eat();
$dog->bark();
?>

<?php
//multiple
trait Trait1{
  public function showa(){
    echo"This is trait 1.\n";
  }
}

trait Trait2{
  public function showb(){
    echo"This is trait 2.\n";
  }
}

class myclass{
  use Trait1, Trait2;
  public function showc(){
    echo"this is a class.<br>";
  }
}

$obj= new myclass();
$obj->showa();
$obj->showb();
$obj->showc();



?>

<?php
//multilevel

class grandparent{
  public function p1(){
    echo"I am the grandparent\n";
  }
}

class parentclass extends grandparent{
  public function p2(){
    echo"I am the parent\n";
  }
}

class childclass extends parentclass{
  public function p3(){
    echo"I am the latest child\n";
  }
}

$child= new childclass();

$child->p1();
$child->p2();
$child->p3();

?>