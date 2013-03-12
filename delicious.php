<?php
class delicious{

	private $curl;
	private $curl_options;
	private $username;
	private $password;

	public function __construct($username, $password){
		$this->username = $username;
		$this->password = $password;
		$this->curl = curl_init();
	}

	public function set_options(){
		$this->curl_options = array(
			CURLOPT_RETURNTRANSFER => 1, 
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_USERPWD => $this->username . ':' . $this->password
		);
	}

	public function execute(){
		curl_setopt_array($this->curl, $this->curl_options);

		$response = curl_exec($this->curl);
		if(!$response){
			die('Error: "' . curl_error($this->curl) . '" - Code: ' . curl_errno($this->curl));
		}
		curl_close($this->curl);;		
		return $response;
	}

	public function get_all(){

		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/posts/all';
		$response = $this->execute();
		$xml = simplexml_load_string($response);	
		return $xml;
	}


	public function get_by_tag($tag){

		$this->set_options();
		$request_url = 'https://api.del.icio.us/v1/posts/all?tag=' . urlencode($tag);
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	
		return $xml;
	}


	public function get_by_offset($start, $limit){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/posts/all?start=' . $start;
		$request_url .= '&results=' . $limit;
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();	
		$xml = simplexml_load_string($response);	
		return $xml;
	}

	public function get_by_date_range($from_date, $to_date){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/posts/all?fromdt=' . $from_date;
		$request_url .= '&to_dt=' . $to_date;
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();			
		$xml = simplexml_load_string($response);	
		return $xml;		
	}

	public function add($url, $description = '', $tags = ''){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/posts/add?';
		$request_url .= 'url=' . urlencode($url);
		$request_url .= '&description=' . urlencode($description);
		$request_url .= '&tags=' . urlencode($tags);

		$this->curl_options[CURLOPT_URL] = $request_url;
		$this->execute();
	}


	public function delete($url){

		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/posts/delete?url=' . $url;
		$this->execute();

	}


	public function get($url = '', $date = '', $tag = ''){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/posts/get?';
		$request_url .= 'url=' . $url;
		$request_url .= '&dt=' . urlencode($date);
		$request_url .= '&tag=' . urlencode($tag);
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	
		return $xml;
	}

	public function get_recent($tag = '', $count = 1){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/posts/recent?';
		$request_url .= 'tag=' . urlencode($tag);
		$request_url .= '&count=' . $count;
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;
	}

	public function dates($tag = ''){

		$this->set_options();
		$request_url = 'https://api.del.icio.us/v1/posts/dates?tag=' . urlencode($tag);
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;		
	}

	public function hashes(){

		$this->set_options();
		$request_url = 'https://api.del.icio.us/v1/posts/all?hashes';
		$this->curl_options[CURLOPT_URL] = $request_url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;		
	}


	public function suggest($url){

		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/posts/suggest?url=' . $url;
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;	
	}

	public function tags(){
		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/tags/get';
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;			
	}

	public function delete_tag($tag){

		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/tags/delete?tag=' . urlencode($tag);
		$this->execute();
	}

	public function rename_tag($tag, $new_name){

		$this->set_options();
		$request_url 	= 'https://api.del.icio.us/v1/tags/rename?';
		$request_url .= 'old=' . urlencode($tag);
		$request_url .= '&new=' . urlencode($new_name);
		$this->curl_options[CURLOPT_URL] = $request_url;
		$this->execute();
	}

	public function get_bundles($bundle = ''){
		
		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.del.icio.us/v1/tags/bundles/all?bundle=' . urlencode($bundle);
		$response = $this->execute();
		$xml = simplexml_load_string($response);	

		return $xml;		
	}

	public function create_bundle($bundle, $tags){

		$this->set_options();
		$request_url  = 'https://api.delicious.com/v1/tags/bundles/set?';
		$request_url .= 'bundle=' . urlencode($bundle);
		$request_url .= '&tags=' . urlencode($tags);
		$this->curl_options[CURLOPT_URL] = $request_url;
		$this->execute();
	}

	public function delete_bundle($bundle){

		$this->set_options();
		$this->curl_options[CURLOPT_URL] = 'https://api.delicious.com/v1/tags/bundles/delete?bundle=' . urlencode($bundle);
		$this->execute();
	}
}
?>