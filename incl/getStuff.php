<?php
class getStuff
{
	public function getArray($thing) {
		$arr = array();
		$arr1 = explode("$#@(_fields_separator_*&%^", $thing);
		foreach($arr1 as &$thing){
			$name = explode("$#@(_field_name_value_separator_*&%^", $thing)[0];
			if($name != ""){
				$value = explode("$#@(_field_name_value_separator_*&%^", $thing)[1];
				$arr[$name] = $value;
			}
		}
		return $arr;
	}
}
?>