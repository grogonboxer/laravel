<?php
 namespace App\Dpjmodule;
 use \phpDocumentor\Reflection\DocBlockFactory;
 
class ApiFactory{

	public function factory($mod){
		$mod      = ucfirst(trim($mod));
		$mod_path = dirname(__FILE__).'/'.$mod.'.php';
		if(file_exists($mod_path)){
			include($mod_path);
			
			$class = new \ReflectionClass('App\Dpjmodule\\'.$mod);
			$res   = $class->newInstanceArgs();
			return $res;
		
		}else{
			//类不存在
			$error = '500';
			throw new \Exception($error);
			
		}
	}
}
