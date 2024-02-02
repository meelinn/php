<?php
class Person
{
  #class裡面沒東西也是合法的class
  #public 宣告屬性 , 公開的=其他可以拜訪
  public $name;
  public $age;
  private $sno; #私有屬性只能在類別裡面使用
}

#用此類型建立一個個體
$p1 = new Person();
#前面已經有$,所以name不用+$
$p1->name = "Zoie";
echo "Hello $p1->name <br>";
echo "--- $p1->age---<br>";
var_dump($p1->age); #null
//$p1->sno = "123"; #error
