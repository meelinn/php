<?php

class Person4
{

  # 屬性宣告
  public $name;
  public $age;
  private $sno = 12;

  # 建構子
  function __construct($name, $age)
  {
    $this->name = $name;
    $this->age = $age;
  }
  function getInfo()
  {
    return [
      "name" => $this->name,
      "age" => $this->age,
    ];
  }
  function getSno()
  {
    return $this->sno;
  }
}
