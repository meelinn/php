<?php
class Person3
{
  #class裡面沒東西也是合法的class
  #public 宣告屬性 , 公開的=其他可以拜訪
  public $name;
  public $age;
  private $secret;

  #建構子
  function __construct($name, $age)
  { #$name,$age=形式參數=區域變數
    $this->name = $name;
    $this->age = $age;
  }

  #設定"讀取(get)"private物件
  function getSecret()
  {
    return $this->secret;
  }

  #setter設定器
  function setSecret($new_secret)
  {
    $this->secret = $new_secret;
  }
}



#呼叫建構函式 construct
$p3 = new Person3('Peter', 23);

echo "Hello $p3->name <br>";
echo "--- $p3->age---<br>";

$p3->setSecret('你好');
echo $p3->getSecret() . '<br>';
