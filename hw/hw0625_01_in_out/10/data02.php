<?php
function dd($money)
{
    echo "<pre>";
    echo print_r($money);
    echo"</pre>";
}

$input = $_GET;
$money= $input;

$amount =(float)($money['money'] ?? 0);
$from = $money['from']?? 'twd';
$to = $money['to']?? 'usd';
$result =0 ;

switch($from){

    case 'usd':
        if($to == 'twd'){$result = $amount * 32;}
        if($to == 'usd'){$result = $amount;}
    break;
   
   case 'jpy':
         if($to == 'twd'){$result = $amount *0.19;}
        if($to == 'jpy'){$result = $amount;}
    break;

    case 'eur':
        if($to == 'twd'){$result = $amount *34;}
       if($to == 'eur'){$result = $amount;}
   break;
 
   case 'krw':
     if($to == 'twd'){$result = $amount /51;}
    if($to == 'krw'){$result = $amount;}
    break;
   
    case 'twd':
        if($to == 'twd'){$result = $amount;}
        if($to == 'usd'){$result = $amount /32;}
        if($to == 'jpy'){$result = $amount /0.19;}
        if($to == 'eur'){$result = $amount /34;}
        if($to == 'krw'){$result = $amount *51;}
  break;


}

$money['result'] = round($result, 2);
echo json_encode($money, JSON_UNESCAPED_UNICODE);


?>