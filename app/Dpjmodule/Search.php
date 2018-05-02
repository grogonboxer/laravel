<?php
namespace App\Dpjmodule;

use \App\Dpjmodule\IModule;
use \App\Dpjmodule\ICurl;
use \Curl\Curl;


class Search extends ICurl implements iModule{

	public function resend($method,$header,$all,$url){
		$method = strtolower($method);
		
		if($method == 'get_'){
			//缓存
			ksort($all);
			$key = $url.$method.json_encode($all);
			echo $key;
			print_r($all);
		}else{
			return parent::curl_smi($method,$header,$all,$url);
		}
	}
}
