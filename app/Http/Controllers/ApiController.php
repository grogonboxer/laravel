<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Illuminate\Http\Response;

class ApiController extends Controller
{
    protected $dpi;

	public function __construct(\App\Dpjmodule\ApiFactory $api){
		$this->dpi = $api;
	}
	
	public function dprun(Request $request,$v,$vocate){
		if($v == '2.0'){
			//参数处理 if()
			$method = $request->method();
			if(!isset($method)){
				//method没取到,服务器错误
				return response('{message:路径错误}',404);
			}

			//header头处理
			$header = $request->header();
			$header = $this->get_header($header);
			if(isset($header['error'])){
				$msg  = '{message:'.$header['error']['message'].'}';
				$code = $header['error']['status'];
				return response($msg,$code);
			}
			//all参数处理
			$all = $request->all();
			$all = $this->get_all($all);

			
			//url规则在这里设置 拿method举例子:
			//原路径: route.dapeijia.com/api/2.0/method/apartment/my_apartment
			// 跳转到:methodapi.dapeijia.com/2.0/apartment/my_apartment
			if(array_key_exists($vocate,config('app.vocate'))){
				$toper = config('app.vocate.'.$vocate);
				$path  = $request->path();
				//url过滤
				$tail  = strstr($path, $vocate);
				$url   = $toper.'/'.$v.'/'.$tail;
				//目前1.0方便测试
				$url = '192.168.1.120/openapi/api/1.0/'.$vocate.'/login';
			}else{
				//url出错,404
				return response('{message:路径错误}',404);
			}
			//具备权限
			//$acl = $this->dpi->factory('acl');
			//$rs_acl = $acl->authorize(用户角色,平台app,$访问url);
			//if()

			//echo $url.'\n';
			try{
				$fun_ob = $this->dpi->factory($vocate);
				echo $fun_ob->resend($method,$header,$all,$url);
			}catch(\Exception $e){
				if($e->getMessage() == '500'){
						return response('{message:服务器内部错误}',500);
				}
			}

			
		}else{
			//版本号不支持
			return response('{message:不支持该版本}',404);
		}
	}
	//head只需要 x-dp-id x-dp-key x-dp-token
	private function get_header($header){
			$iheader      = array();
			$header       = array_change_key_case($header, CASE_LOWER);
			$header_error = array(
				'message' => '参数未传够',
				'status'  => '500',
			);
			if(array_key_exists('x-dp-id',$header)){
				$iheader['x-dp-id']    = $header['x-dp-id'][0];
			}else{
				//id不存在.拦截
				$iheader['error']      = $header_error;
			}
			if(array_key_exists('x-dp-key',$header)){
				$iheader['x-dp-key']   = $header['x-dp-key'][0];
			}else{
				//key不存在.拦截
				$iheader['error']      = $header_error;
			}
			if(array_key_exists('x-dp-token',$header)){
				$iheader['x-dp-token'] = $header['x-dp-token'][0];
			}else{
				//token不存在.赋空值
				$iheader['x-dp-token'] = '';
			}
			return $iheader;
	}
	//all遇到file的时候需要重新封装
	private function get_all($all){
			return $all;
	}
}
