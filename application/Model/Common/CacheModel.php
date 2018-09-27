<?php
namespace Model\Common;

use core\Model;
class CacheModel extends Model{
    use CacheModelTools;  
    
    protected $pk = "id";
    
    public function __construct() {
        parent::__construct ();
    }
    
    
    /**
     * 根据主键ID获取真实的数据
     * @param  string  $ids
     * @return mixed
     * @author wangdb
     */
    public function getRealDataByIdKeys($ids){
        $res = $this->where([$this->pk=>['in', $ids]])->field('*')->select();
        if(empty($res)){
            return [];
        }else{
            return $res;
        }
    }
    
    /**
     * 子类可写此方法，来生成自定义的idkey
     */
//     public function getIdKey($id){
//         return "Example_".$id;
//     }
    
    /**
     * 解析缓存key
     */
    public function parseIdKey($data, $key="_"){
        if(!is_array($data)){
            $data = [$data];
        }
        foreach($data as $val){
            $temp = explode($key, $val);
            $result[array_shift($temp)][] = $temp;
        }
        unset($data, $key, $temp);
        
        return $result;
    }
}