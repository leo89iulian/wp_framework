<?php 
class vc{
	public static $_instance;
        
	private function __construct($args = null) {
		// coodul aici
	}
	public static function getInstance($args = null){
		if(!(self::$_instance instanceof self)) {
			self::$instance = new vc($args);
		}
		return self::$_instance;
	}
	public function cache($k,$time="+1 hour",$v=NULL){
		if($v===NULL){
			$time_c=get_option("cache_".$k."_time",1);
			if(strtotime($time,$time_c)<strtotime("now")){
				return false;
			}
			$res = get_option("cache_".$k,1);
			if(unserialize($v)===NULL){$res=unserialize($res);}
			return $res;
		}else{
			$ov=$v;
			if(is_array($v)){$v=serialize($v);}
			update_option("cache_".$k,$v);
			update_option("cache_".$k."_time",strtotime("now"));
			return $ov;
		}
	}
}