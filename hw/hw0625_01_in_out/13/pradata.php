<?php
function dd($data)
{
    echo "<pre>";
    print_r($data);
    echo "</pre>";
}



$input = $_GET;

$data = $input;

$num1 = $data['num1'] ?? 600;
$num2 = $data['num2'] ?? 200;
$opt = $data['opt'] ?? '-';
$result = 0;

switch ($opt) {
     case '+':
     $result = $num1 + $num2;
     break; 

     case '-':
     $result = $num1 - $num2;
     break; 

     case '*':
     $result = $num1 * $num2;
     break; 

     case '/':
     $result = $num1 / $num2;
     break; 

     default:
     break;

}

$data['result'] = $result;

echo json_encode($data);
