<?php
/**
 * Created by PhpStorm.
 * User: Wang
 * Date: 2016/10/27
 * Time: 0:13
 * 作用:根据权限显示导航栏
 */

$ap_codes;//全局变量，用于存放权限代码集合

/**
 *获取权限代码集合
 * @param unknow $ar_id
 */
function getCodes($ar_id){
    global $ap_codes;
    $where['ar_id']=$ar_id;
    $code=M('admin_role')->field('ap_codes')->where($where)->find();
    $ap_codes=explode(',',$code['ap_codes']);
}

/**
 * 判断是否具有权限
 * @param $str
 * @return string
 */
function checkPower($str){
    global $ap_codes;
    $arr=explode(',', $str);//将权限集合转换为数组
    $check=array_intersect($arr,$ap_codes);//存在交集即拥有权限
    return empty($check)?"0":"1";
}
