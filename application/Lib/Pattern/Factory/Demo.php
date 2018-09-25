<?php
/**
 * 工厂模式测试Demo
 * @author wangdb
 */
include '../../Vendor/Pattern/Factory/XhSms.php';
$params = array();
$res = XhSms::gi()->sendSms($params, XhSms::ALIYUN);