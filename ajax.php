<?
 error_reporting(E_ERROR);
 
 require_once './controller/short.php';
 if ($_SERVER['REQUEST_METHOD'] != 'POST') $json_data = array('error' => 'Protocol error');
 if (trim($_POST['url']) !== ''){
 $shortURL = new ControllerShort();
 $code = $shortURL->urlToShortCode($_POST['url']);
 $json_data = array('code' => $code['code'], 'error' => $code['error'], 'site' => $code['site']);
 }else
 $json_data = array('error' => 'Empty request');
 
 echo json_encode($json_data);
 ?>