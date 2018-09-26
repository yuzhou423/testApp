<?php
namespace Model\Test;

use Model\CacheModel;
class UserModel extends CacheModel {
    public $tableName = DB_NAME_TEST.".user";
//     self::$pk        = "id";
    
    /**
     * 根据ID获取真实的数据
     */
    public function getRealDataByIdKeys($idKeys){
        $idKeys   = $this->parseIdKey($idKeys);
        $result   = $ids = [];
        foreach($idKeys as $key=>$val){
            switch($key){
                case "AdminToUser":  // 说明是用户与管理员的绑定
                    array_walk($val, function(&$v){
                        $where['admin_id'] = $v[0];
                        $userData = $this->where($where)->find();
                        $v        = [
                            "cacheKey" => self::getIdKey($v[0]),
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
}