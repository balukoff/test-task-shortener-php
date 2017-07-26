<?
class ModelShort{
  private $db;
  private $timestamp;
  public function connect($host, $db, $username, $password){
   $link = mysqli_connect($host, $username, $password);
   if (!$link) $this->error = 'Ошибка соединения с сервером баз данных';
    else{
	 if (!mysqli_select_db($link, $db)){
	  $this->error = 'База данных не существует';
	 }else 
	  $this->link = $link;
	  $this->db = $db;
    }
 }
  public function urlExistsInDB($url){
    $query = "SELECT short_url FROM short_url WHERE wide_url = '$url' LIMIT 1";
	$result = mysqli_query($this->link, $query);
	return mysqli_num_rows($result);
  }
  
 public function insertUrlInDb($url) {
        $this->timestamp = $_SERVER["REQUEST_TIME"];
		$query = "INSERT INTO short_url(wide_url, date_added) VALUES ('$url', '$timestamp')";
		mysqli_query($this->link, $query);
	   return mysqli_insert_id($this->link);
    }
  
  public function insertShortCodeInDb($id, $code) {
        if ($id == null || $code == null) {
            throw new \Exception("Ошибка параметров ввода.");
        }
        $query = "UPDATE short_url SET short_url = '$code' WHERE id = $id";
        $result = mysqli_query($this->link, $query);
		
        if (mysqli_affected_rows($this->link) < 1) {
            throw new \Exception(
                "Ошибка обновления строки.");
        }
        return true;
    }

  public function getUrlFromDb($code) {
        $query = "SELECT * FROM short_url WHERE short_url = '$code' LIMIT 1";
        $result = mysqli_query($this->link, $query);
        $out = array();
		while($row = mysqli_fetch_assoc($result)){
		 $out[] = $row['wide_url'];
		}
		return $out;
    }
	
	public function getCodeFromDb($url) {
        $query = "SELECT short_url FROM short_url WHERE wide_url = '$url' LIMIT 1";
        $result = mysqli_query($this->link, $query);
        $out = array();
		while($row = mysqli_fetch_assoc($result)){
		 $out[] = $row['short_url'];
		}
		return $out;
    }
  

}

?>