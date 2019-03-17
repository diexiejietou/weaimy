<?php

//严格过滤字符串中的危险符号
function strict($str)
{
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}
	$str = str_replace('&#','{^}',$str);
	$str = str_replace('#','&#35;',$str);
	$str = str_replace('--','-&#45;',$str);
	$str = str_replace('/*','/&#42;',$str);
	$str = str_replace('*/','&#42;/',$str);
	$str = str_replace('<','&#60;',$str);
	$str = str_replace('>','&#62;',$str);
	$str = str_replace('(','&#40;',$str);
	$str = str_replace(')','&#41;',$str);
	$str = str_replace("'",'&#39;',$str);
	$str = str_replace('"','&#34;',$str);
	$str = str_replace('\\','&#92;',$str);
	$str = str_replace('%20','&nbsp;',$str);
	$str = str_replace(chr(13).chr(10),'<br />',$str);
	$str = str_replace('{^}','&#',$str);
	return $str;
}

//设置全局变量数组
function set_global($filter = 'strict')
{
	global $global;
	$global = array();
	$global['url'] = $filter($_SERVER['QUERY_STRING']);
	//例如：  http://weaimy.com/?
	//$_SERVER['QUERY_STRING'] = /article/id-53/index.html
	if($global['url'] != '')
	{
		$arr = explode('/',$global['url']);
		//$arr = array("","article","id-53","index.html")
		$global['channel'] = $arr[1];
		//$global['channel'] = "article";
		for($i = 0; $i < count($arr); $i ++)
		{
			$strpos = strpos($arr[$i],'-');
			if($strpos)
			{
				$key = substr($arr[$i],0,$strpos);
				//$key = "id"
				$value = substr($arr[$i],$strpos + 1);
				//$value = "53"
				if(!isset($global[$key]))
				{
					if(is_numeric($value) && strpos($value,'.') === false)
					{
						$global[$key] = intval($value);
					}else{
						$global[$key] = $value;
					}
					//$global['id']=53
				}
			}
		}
	}
}

//获取post
function post($val,$filter = 'strict')
{
	return $filter(isset($_POST[$val])?$_POST[$val]:'');
}

///////////////////////////////////////////////////////////////
function controller()
{
	global $global,$smarty;
	
	$cmd = post('cmd');
	if($cmd == '')
	{
		$path = S_PROJECT . '/' . $global['channel'] . '.php';
		if(file_exists($path))
		{
			include($path);
		}else{
			include(S_PROJECT . '/' . S_PROJECT . '.php');
		}
	}else{
		include(S_PROJECT . '/common.func.php');
		
		$deal_file = get_global('file','deal');
		if($global['channel'] == 'deal')
		{
			load_lang_pack(S_PROJECT,array('info'));
			$path = S_PROJECT . '/module/deal.php';
		}else{
			load_lang_pack(S_PROJECT,array($global['channel']));
			$path = S_PROJECT . '/module/' . $global['channel'] . '/' . $deal_file . '.php';
		}
		if(file_exists($path))
		{
			include($path);
			$cmd = post('cmd');
			if(function_exists($cmd))
			{
				$cmd();
				exit();
			}
		}
		
		$material = get_material();
		$result = https_request(S_SERVER_URL,$material);
		//echo $result;
		$arr = json_decode($result,true);
		initial_simple($arr);
	}
}
?>