<?php 
if(isset($flag)&&!empty($flag)){
	$arr = array('flag' => $flag);
	echo json_encode($arr);
}else{
	echo json_encode(array('flag' => 'nothing'));
}
?>
