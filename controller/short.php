<?
class ControllerShort{
 private $model;
 private $link;
 public  $error;
 private $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
  
 
 function __construct(){
  require_once './config.php';
  require_once './model/short.php';
  $this->model = new ModelShort;
  $this->model->connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
  
  if (!empty($this->error)) print $this->error;
 }
 
 // check if url real exists 
 
 private function checkUrlExists($url) {
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_NOBODY, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_exec($ch);
  $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
  curl_close($ch);
  return (!empty($response) && $response != 404);
 }
 
 // check if url exists in database
 
 protected function urlExistsInDb($url) {
       if ((int)$this->model->urlExistsInDB($url) == 0){
	    return false;
	   }else return true;
    }
 
 // create short url code and insert into database
 
 protected function createShortCode($url) {
  $id = $this->model->insertUrlInDb($url);
  $shortCode = $this->convertIntToShortCode($id);
  $this->model->insertShortCodeInDb($id, $shortCode);
  return $shortCode;
}

 protected function validateUrlFormat($url) {
  return filter_var($url, FILTER_VALIDATE_URL, FILTER_FLAG_HOST_REQUIRED);
}

 public function urlToShortCode($url) {
        $shortCode = array();
		if (empty($url)) {
            $this->error = "Не получен адрес URL.";
        }
        if ($this->validateUrlFormat($url) == false) {
                $this->error = "Адрес URL имеет неправильный формат.";
        }
        if (CHECKURL_EXISTS) 
	   {
            if (!$this->checkUrlExists($url)) {
                  $this->error = "Адрес URL не существует.";
            }
        }
        $__shortCode = $this->urlExistsInDb($url);
        if ($__shortCode == false) {
            $__shortCode = $this->createShortCode($url);
        }else{
		$__shortCode = $this->model->getCodeFromDB($url);
		}
     $shortCode['code'] =  $__shortCode;
	 $shortCode['error'] = $this->error;
	 $shortCode['site'] = SITE_LINK;
	 
	 return $shortCode;
    }

  protected function convertIntToShortCode($id) {
        $id = intval($id);
		$code = bin2hex(openssl_random_pseudo_bytes($id / 2));
		return $code;
    }

  public function shortCodeToUrl($code) {
        if (empty($code)) {
            //throw new \Exception(
			$this->error = "Не задан короткий код.";//);
			return false;
        }
        /*if ($this->validateShortCode($code) == false) {
            //throw new \Exception(
              $this->error = "Короткий код имеет неправильный формат.";
        }*/
        $urlRow = $this->model->getUrlFromDb($code);
		//print_r($urlRow);
        if (empty($urlRow)) {
         //   throw new \Exception(
                $this->error = "Короткий код не содержится в базе.";//);
                return false;
		}
        return $urlRow[0];
    }
	
    protected function validateShortCode($code) {
        return preg_match("|[" . self::$chars . "]+|", $code);
    }
	
}

?>