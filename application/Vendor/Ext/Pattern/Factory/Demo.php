<?php
/**
 * 工厂模式测试Demo
 * @author wangdb
 */
$params = array();
$res = Ext\Pattern\Factory\XhSms::gi()->sendSms($params, Ext\Pattern\Factory\XhSms::ALIYUN);