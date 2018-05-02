<?php
namespace App\Dpjmodule;

//use Illuminate\Support\Facades\Cache;
use \App\Dpjmodule\IModule;
use \App\Dpjmodule\ICurl;
use \Curl\Curl;


class Admin extends ICurl implements iModule{

	public function resend($method,$header,$all,$url){
		$method = strtolower($method);
		//$method = 'get_';
		echo "string";
		if($method == 'get_'){
			//缓存
			/*
			ksort($all);
			$key = $url.$method.json_encode($all);
			echo $key;
			print_r($all);
			*/
			//$val = Cache::('daren','xiaohai',300);
		//	exit();
		}else{
			return parent::curl_smi($method,$header,$all,$url);
		}
	}
}
