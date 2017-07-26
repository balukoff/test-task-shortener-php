<?
 require_once './controller/short.php';
 if ($_SERVER['REQUEST_METHOD'] != 'POST') die('protocol_error');
 $shortURL = new ControllerShort();
 $code = $shortURL->urlToShortCode($_POST['url']);
 $json_data = array('code' => $code['code'], 'error' => $code['error'], 'site' => $code['site']);
 echo json_encode($json_data);
 ?>