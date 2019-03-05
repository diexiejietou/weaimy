<?php 
	/**
	 * 配置文件
	 */
	/**
	* 
	*/
	class config{
		private $config;
		public function __construct($re_config=array()){
			$config = $this->set_config();
			$this->config = $this->reset_config($config,$re_config);
		}
		private function set_config(){
			$config = array();
			$config['S_LANG'] = 'zh-cn';
			$config['S_TPL_PATH'] = 'templates/default/';
			return $config;
		}
		public function get_config(){
			return $this->config;
		}
		private function reset_config($config,$re_config){
			foreach ($re_config as $key => $value) {
				$config[$key] = $value;
			}
			foreach ($config as $key => $value) {
				define($key,$value);
			}
			return $config;
		}
	}
?>