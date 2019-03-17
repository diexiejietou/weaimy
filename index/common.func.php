<?php 
function set_smarty()
{
	$template_dir = S_TPL_PATH . 'index/';
	
	/*include('include/browser.class.php');
	$obj = new browser();
	$browser = $obj->check_browser();
	if($browser != 'pc' && $browser != 'unknown')
	{
		$template_dir = S_TPL_PATH . 'mobile/';
		if(!file_exists($template_dir))
		{
			$template_dir = 'templates/default/mobile/';
		}
	}*/
	
	global $smarty;
	$smarty = new Smarty;
	$smarty->template_dir = $template_dir;
	$smarty->compile_dir = 'index/compile/';
	$smarty->cache_dir = 'index/cache/';
}
function initial($config_file_name = '')
{
	global $global,$smarty,$lang;
	
	$material = get_material($config_file_name);
	$result = https_request(S_SERVER_URL,$material);
	$arr = json_decode($result,true);
	if(is_array($arr))
	{
		foreach($arr as $key => $value)
		{
			if($key != 'lang' && $key != 'callback' && $key != 'result')
			{
				$smarty->assign($key,$value);
			}
		}
		initial_simple($arr);
	}else{
		error_info();
	}
	
	$smarty->assign('lang',$lang);
	$smarty->assign('S_FRONT_URL',S_FRONT_URL);
	$smarty->assign('S_TPL_PATH',S_FRONT_URL . S_TPL_PATH);
	$smarty->assign('S_LANG',S_LANG);
	$smarty->assign('S_MULTILINGUAL',S_MULTILINGUAL);
	
	$smarty->registerPlugin('function','url','url');
}
function create_html($url)
{
	if(S_HALF_STATIC)
	{
		$html = ob_get_contents();
		if($url == '')
		{
			if(S_FLASH != 1)
			{
				$path = '/' . S_URL_SUFFIX;
			}else{
				$path = '/flash.html';
			}
		}else{
			$path = $url;
		}
		$path = 'html' . $path;
		if(substr($path,-1) == '/')
		{
			$path .= S_URL_SUFFIX;
		}
		if(!file_exists($path))
		{
			$dir = dirname($path);
			if(!is_dir($dir))
			{
				mkdir($dir,0777,true);
			}
			file_put_contents($path,$html);
		}
	}
}
?>