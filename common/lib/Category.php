<?php

/**
 * 无限极分类-二维无限分类数组
 **/

namespace common\lib;

class Category
{
    //无限分类数组，其中必须要有id和pid
    private $list = [];
    //id => pid 数组
    private $sp_list = [];
    //子分类key
    private $sk;
    //父分类key
    private $pk;

    /**
     *对数组进行初始化处理
     * $cat_list 无限分类数组
     * $_son_key 数组中子分类的key值
     * $_pare_key 数组中父分类的key值
     * @return mixed array
     **/
    public function __construct($cat_list, $_skey = 'id', $_pkey = 'pid')
    {
        $this->sk = $_skey;
        $this->pk = $_pkey;
        $this->init($cat_list);
    }

    /**
     *对数组进行初始化处理
     * @return mixed array
     **/
    private function init($cat_list){
        if(empty($cat_list)){
            return false;
        }
        //对数组进行预处理
        foreach($cat_list as $key => $val){
            //生成sid => pid 数组
            $this->sp_list[$val[$this->sk]] = $val[$this->pk];
            //以数组的子分类值作为索引
            $this->list[$val[$this->sk]] = $val;
        }
        unset($cat_list);
    }

    /**
     * 获取格式化的树形数据
     * @param $pid int $list中顶级分类id
     * @param $level int $list中顶级分类的层级
     * @param $html string 上下层级之间的标示符号
     * @return mixed
     **/
    public function _sort($pid = 0, $level = 0, $html = '-')
    {
        if (empty($this->list)) {
            return false;
        }
        static $tree = array();
        foreach ($this->list as $v) {
            if ($v[$this->pk] == $pid) {
                $v['sort'] = $level + 1;
                $v['html'] = str_repeat($html, $level);
                $tree[$v[$this->sk]] = $v;
                $this->_sort($v[$this->sk], $level + 1);
            }
        }
        return $tree;
    }

    /**
     * 获取分类的无限极子分类，以树型结构显示
     * @param $son string 子节点节点名
     * @return mixed
     **/
    public function _tree($son = 'son')
    {
        if (empty($this->list)) {
            return false;
        }
        $list = $this->list;
        foreach($list as $item)
            $list[$item[$this->pk]][$son][$item[$this->sk]] = &$list[$item[$this->sk]];
        return isset($list[0][$son]) ? $list[0][$son] : array();
    }

    /**
     * 获取分类的祖先分类
     * @param $id int 分类id
     * @param $type bool true-返回祖先分类数组 false-返回祖先分类id
     * @return mixed
     **/
    public function _ancestor($id, $type = true)
    {
        if (empty($this->list) || empty($this->sp_list)) {
            return false;
        }
        while($this->sp_list[$id]) {
            $id = $this->sp_list[$id];
        }
        return $type && isset($this->list[$id]) ? $this->list[$id] : $id;
    }

    /**
     * 获取所有父级分类对应层级关系
     * @param $id int 分类id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
    public function _parents($id, $type = true)
    {
        if (empty($this->list)) {
            return false;
        }
        $info = [];
        while(isset($this->sp_list[$id])){
            $info[] = $type ? $this->list[$id] : $id;
            $id = $this->sp_list[$id];
        }
        return $info;
    }

    /**
     * 获取所有子级分类对应层级关系
     * @param $id int 子分类id
     * @param $type bool true-返回分类数组 false-返回分类id
     * @return mixed
     **/
    public function _sons($id, $type = true)
    {
        if (empty($this->list)) {
            return false;
        }
        static $info = array();
        foreach ($this->list as $val) {
            if ($val[$this->pk] == $id) {
                $info[] = $type ? $val : $val[$this->sk];
                if ($this->_has_son($val[$this->sk])) {
                    $this->_sons($val[$this->sk], $type);
                }
            }
        }
        return $info;
    }

    /**
     * 是否含有子分类，是否是叶子节点
     * @param $pid int 父分类id
     * @return mixed
     **/
    public function _has_son($pid)
    {
        if (empty($this->list) || empty($this->sp_list)) {
            return false;
        }
        return in_array($pid, array_values($this->sp_list));
    }

    /**
     * 释放存储空间
     **/
    public function __destruct()
    {
        unset($this->list);
        unset($this->sp_list);
        unset($this->sk);
        unset($this->pk);
    }

}
?>