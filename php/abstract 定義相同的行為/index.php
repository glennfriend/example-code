<?php


// 定義相同的行為使用 abstract
function abstract_example(Dog $dog)
{
    echo $dog->getTalk();
}
abstract_example(new BlackDog);


// 而不是使用 interface
function interface_example(Bird $bird)
{
    echo $bird->getSpeed();
}
interface_example(new African);




//
//
//

abstract class Bird {
    abstract function getSpeed();
  }
  
  class European extends Bird {
    public function getSpeed() {
      return '1';
    }
  }
  class African extends Bird {
    public function getSpeed() {
      return '2';
    }
  }
  

  interface Dog {
    function getTalk();
  }
  
  class BlackDog implements Dog {
    public function getTalk() {
      return 'b';
    }
  }
  class RedDog implements Dog {
    public function getTalk() {
      return 'r';
    }
  }

