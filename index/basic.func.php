<?php 
	function main(){
		global $global,$smarty;
		set_global();
		set_more_global();
		controller();
	}
	function set_more_global(){
		global $global;
		$global['user_id'] = 0;
		$global['channel'] = get_global('channel','index');
		$global['mod'] = get_global('mod','profile');
		$global['cat'] = get_global('cat',0);
		$global['page'] = get_global('page',1);
		$global['id'] = get_global('id',0);	
		$global['original'] = $global['channel'];
	}
?>