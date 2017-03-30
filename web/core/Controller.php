<?php defined('BASEPATH') or exit('No direct script access allowed');

class Controller{

	public function __construct(){
		$this->input = load_class('Input');

		$this->smarty = new Smarty();
		$this->smarty->left_delimiter = "<{";
		$this->smarty->right_delimiter = "}>";
		$this->smarty->setTemplateDir(DIR_V);
		$this->smarty->setCompileDir(BASEPATH.'/cache/templates_c/');
		$this->smarty->setCacheDir(BASEPATH.'/cache/');

		session_start();
	}

	public function add($name,$value){
		$this->smarty->assign($name,$value);
	}

	public function display($path, $is_include = true){
        if($is_include){
            $this->smarty->display('web_header.html');
            $this->smarty->display($path);
            $this->smarty->display('web_footer.html');
        }else{
            $this->smarty->display($path);
        }
	}

	//POST请求 type=1 GET请求 type=0 data提交数组数据
    public static function curl_request($url,$type = 0, $data = array()){
        $url = 'http://127.0.0.1:9904//'.$url;
        //$url .= '?si){te_id='.SITEID.'&index_id='.INDEX_ID;
        if(!$type){
            $url .= '&stoken='.self::curl_url_token($url);
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_REFERER, "");
        //如果真POST请求
        if ($type) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        //curl_setopt($ch, CURLOPT_GETFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
        $rdata = curl_exec($ch);
        curl_close($ch);
        return $rdata;
    }
    
    //url添加stoken
    public static function curl_url_token($url){
        // AES-128
        $encrypter = load_class('AesCrypter');
        $stoken = base64_encode($encrypter->encrypt($url));
        $encrypter->close();
        return $stoken;
    }
}