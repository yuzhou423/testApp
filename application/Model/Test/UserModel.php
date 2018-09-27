<?php
namespace Model\Test;

use Model\Common\CacheModel;
/**
 * 用户表模型
 * @author wangdb
 */
class UserModel extends CacheModel {
    public $tableName  = DB_NAME_TEST.".user";  // 数据表【用户表】
    public $dbConfName = DB_NAME_TEST;  // 数据库
    public $pk         = "id";  // 主键ID
    
    /**
     * 根据ID获取真实的数据
     */
    public function getRealDataByIdKeys($idKeys){
        $idKeys   = $this->parseIdKey($idKeys);
        $result   = $ids = [];
        foreach($idKeys as $key=>$val){
            $res=[];
            switch($key){
                case "AdminToUser":  // 说明是用户与管理员的绑定
                    array_walk($val, function(&$v){
                        $where['admin_id'] = $v[0];
                        $userData = $this->where($where)->find();
                        $v        = [
                            "cacheKey" => self::getAdminIdKey($v[0]),
                            "data"     => $userData
                        ];
                    });
                    $res   = $val;
                    break;
                default:
                    $ids[] = $key;
                    break;
            }
            foreach($res as $v){
                array_push($result, $res);
            }
        }
        $res = parent::getRealDataByIdKeys($ids);
        foreach($res as $val){
            array_push($result, $val);
        }
        return $result;
    }
    
    /**
     * 将数据转化成缓存结构
     */
    public function changeToCacheData($data){
        foreach($data as $key=>$val){
            if(isset($val['cacheKey'])){
                
            }
        }
    }
    
    /**
     * 获取管理员缓存key
     */
    public function getAdminIdKey($id){
        return "AdminToUser_".$id;
    }
}