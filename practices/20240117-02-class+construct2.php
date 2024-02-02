<?php
class Person2
{
  #class裡面沒東西也是合法的class
  #public 宣告屬性 , 公開的=其他可以拜訪
  public $name;
  public $age;

  #建構子
  function __construct($name, $age)
  { #$name,$age=形式參數=區域變數
    $this->name = $name;
    $this->age = $age;
  }
  function getInfo()
  { #function預設式public,所以外面可以公開呼叫
    return [
      "name" => $this->name,
      "age" => $this->age,
    ];
  }
}



#呼叫建構函式 construct
$p2 = new Person2('Harris', 27);

echo "Hello $p2->name <br>";
echo "--- $p2->age---<br>";
var_dump($p2->age);
echo json_encode($p2->getInfo());
