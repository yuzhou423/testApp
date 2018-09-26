<?php
/**
 * 工厂模式测试Demo
 * @author wangdb
 */
include './XhSms.php';
$params = array();
$res = XhSms::gi()->sendSms($params, XhSms::ALIYUN);