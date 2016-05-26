<?php
function multi2one ($array, $delimiter = '->', $key = '') {
    $data = [];
    if ( !is_array($array) ) {
        return $data;
    }
    foreach ( $array as $k => $v ) {
        $newKey = trim($key.$delimiter.$k, $delimiter);
        if ( is_array($v) ) {
            $data = array_merge($data, multi2one($v, $delimiter, $newKey));
        } else {
            $data[$newKey] = $v;
        }
    }
    return $data;
}

function array_merge_multi (){
    $args = func_get_args();
    $array = array();
    foreach ( $args as $arg ) {
        if ( is_array($arg) ) {
            foreach ( $arg as $k => $v ) {
                if ( is_array($v) ) {
                    $array[$k] = isset($array[$k]) ? $array[$k] : array();
                    $array[$k] = array_merge_multi($array[$k], $v);
                } else {
                    $array[$k] = $v;
                }
            }
        }
    }
    return $array;
}

// function getdepartmentinfo($token,$vv) {
// 	$url = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=$token&id=$vv";
// 	$ch = curl_init();
// 	curl_setopt($ch, CURLOPT_URL,$url );
// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
// 	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false); 
// 	curl_setopt($ch, CURLOPT_HEADER, 0);
// 	$output = curl_exec($ch);
// 	curl_close($ch);
// 	$department = json_decode($output,true);
// 	//$departmentname = $department;
// 	return $department;
// 	//return $departmentname;
// 	//p($departmentname);die;
// }

