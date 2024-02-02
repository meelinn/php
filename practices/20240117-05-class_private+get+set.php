<?php

#include-把20240117-04-class.php程式碼拷貝一份貼在此處
include __DIR__ . '/20240117-04-class.php';

#require-沒找到沒辦法繼續往下
#require __DIR__ . '/20240117-04-class.php';

#extends=從XX延伸過來繼承
#私有屬性沒有繼承,但仍存在
class Employee extends Person4
{
  public $employee_id; #員工編號

  function __construct($name, $age, $employee_id)
  {
    #有定義建構函式,且為繼承,必須在第一行呼叫父類函數
    parent::__construct($name, $age);
  }

  function getInfo()
  {
    $info = parent::getInfo(); #複製父層的getInfo()
    $info['empolyee_id'] = $this->employee_id;
    return $info;
  }
}

$q1 = new Employee('Victor', 30, 'C007');
echo "$q1->name $q1->employee_id <br>";
echo json_encode($q1->getInfo()) . "<br>"; #/20240117-04-class.php的getinfo

echo $q1->getSno() . "<br>";
