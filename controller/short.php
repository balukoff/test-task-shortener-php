<?
class ControllerShort{
 private $model;
 private $link;
 public  $error;
 private $chars = "123456789bcdfghjkmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ";
 
 function __construct(){
  require_once './config.php';
  require_once './model/short.php';
  //$this->link = null;
  $this->model = new ModelShort;
  $this->model->connect(DB_HOST, DB_NAME, DB_USERNAME, DB_PASSWORD);
  $this->link = $this->model->getLink();
  if (!$this->link) $this->error = 'Database connection error';
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
       if (!$this->link) return false;
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
	   if ($this->link){ 
	   $shortCode = array();
		if (empty($url)){
            $this->error = "Can't get URL";
        }
        if ($this->validateUrlFormat($url) == false){
                $this->error = "URL has error format.";
        }
        if (CHECKURL_EXISTS) 
	   {
            if (!$this->checkUrlExists($url)){
                  $this->error = "URL doesn't exists";
            }
        }
        $__shortCode = $this->urlExistsInDb($url);
        if ($__shortCode == false) {
            $__shortCode = $this->createShortCode($url);
        }else{
		$__shortCode = $this->model->getCodeFromDB($url);
		}
     $shortCode['code'] =  $__shortCode;
	 $shortCode['site'] = SITE_LINK;
	 }
	 $shortCode['error'] = $this->error;
	 
	 return $shortCode;
 }

  protected function convertIntToShortCode($id) {
        $id = intval($id);
		$code = bin2hex(openssl_random_pseudo_bytes($id / 2));
		return $code;
    }

  public function shortCodeToUrl($code) {
        if (!$this->link) return false;
		if (empty($code)) {           
			$this->error = "ShortCode is in error format.";
			return false;
        }
        $urlRow = $this->model->getUrlFromDb($code);
        if (empty($urlRow)) {
                $this->error = "Database has no short URL.";
                return false;
		}
        return $urlRow[0];
    }
}
?>