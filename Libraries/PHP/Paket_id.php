<?php

/**
 * Library to use prime API of Paket.id
 *
 * @package		Paket.id
 * @subpackage		Application/Libraries
 * @category		PHP API Library
 * @author		Dika Maheswara
 */
 
class Paket_id {

	protected $api_key = NULL;
	
	public function set_api_key($key)
	{
		return $this->api_key=$key;
	}
	
	public function post_data($data_array=NULL,$return_type="json") //return type could be json or var (var for php array)
	{
		if(!$data_array)return;
		
		$url = 'http://paket.id/api/post?key='.$this->api_key;
		
		$fields = array(
								'from_email' => urlencode($data_array['from_email']),
								'from_name' => urlencode($data_array['from_name']),
								'from_address' => urlencode($data_array['from_address']),
								'from_zip_code' => urlencode($data_array['from_zip_code']),
								'from_area_id' => urlencode($data_array['from_area_id']),
								'to_name' =>  urlencode($data_array['to_name']),
								'to_address' =>  urlencode($data_array['to_address']),
								'to_zip_code' => urlencode($data_array['to_zip_code']),
								'to_area_id' => urlencode($data_array['to_area_id']),
								'from_phone' => urlencode($data_array['from_phone']),
								'to_phone' =>  urlencode($data_array['to_phone']),
								'to_email' => urlencode($data_array['to_email']),
								'message' => urlencode($data_array['message']),
								'note' => urlencode($data_array['note']),
								'email_receiver' => urlencode($data_array['email_receiver']), // -1 if no mail shld be sent to receiver, 0 otherwise
								'email_sender' => urlencode($data_array['email_sender']) // -1 if no mail shld be sent to sender, 0 otherwise
						);
		
		//url-ify the data for the POST
		$fields_string="";
		foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
		rtrim($fields_string, '&');
		
		//open connection
		$ch = curl_init();
		
		//set the url, number of POST vars, POST data
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_POST, count($fields));
		curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
		
		//execute post
		$result = curl_exec($ch);
		
		//close connection
		curl_close($ch);
		
		if ($return_type=="json")$this->json($result);
		elseif ($return_type=="var")return $result;
	}
	
	public function json($result)
	{
		//set json header
		header('Content-Type: application/json');
		
		//print out result
		echo json_encode($result);	
	}
}
