<?php
$curl = curl_init();
$auth_data = array(
    'client_id'         => 'ulpD1ty4dFKc05UIi5yc9C89OaBsiUwfQ2QTGIfb',
    'client_secret'     => '06KkLQ1vkXIN3NiXnaLAOGEtkx17jk34GmQhf3CovfjAlM328cciknoVEXjtNehMP66slp5vtFEhlBpzlpv6x2Oy2jzQuKBhImrX8Plbk7MltOvJGuUYmQugsW832Szo',
    'grant_type'        => 'client_credentials'
);
curl_setopt($curl, CURLOPT_POST, 1);
curl_setopt($curl, CURLOPT_POSTFIELDS, $auth_data);
curl_setopt($curl, CURLOPT_URL, 'https://aegis.sedayu.one/oauth/token/');
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
$result = curl_exec($curl);
if(!$result){die("Connection Failure");}
curl_close($curl);
$hasil = (json_decode($result, true));
$access_token = $hasil['access_token'];
?>