<?php

namespace App\Dpjmodule;

use \Curl\Curl;

class ICurl{
	
	public function curl_smi($method,$header,$all,$url){
		/*
		echo $url;
		print_r($header);
		print_r($method);
		print_r($all);
		*/
		$curl = new Curl();
		$curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
		$curl->setUserAgent('');
		$curl->setReferrer('');
		foreach ($header as $key=>$value){
			$curl->setHeader($key,$value);
		}
		$curl->$method($url,$all);

		if($curl->error){
			throw new \Exception($curl->error_code);
			
			return $curl->error_code;
		}else{
			return $curl->response;
		}
		$curl->close();
	}
}