<?php
namespace common\lib;

use Yii;
use common\api\VsoApi;

/**
 * 上传图片
 *
 */
class Industry {
    /**
     * 获取分类，构造一个数组，第一维为一级分类，第二维为二级分类，第三维为三级分类，每一级的节点
     * 有三个键值，id(int)-分类id；name(string)-分类名称；children(Array)-子类
     * 注意：三级分类不存在的时候可能会导致异常
     */
    public static function getApiIndustryList() {
        $cats = self::getApiIndustries();
        if (!$cats) {
            return [];
        }
        $arr = array();
        $root = $a = $lvl = 0;
        $levemore = false;
        foreach ($cats as $v) {
            $item = array('id' => $v['id'], 'name' => $v['name']);
            if ($root && $root != $v['root']) {
                $root = 0;
            }
            if ($v['lvl'] < $lvl && $lvl) {
                $a = $lvl = 0;

            }
            if ($v['lvl'] > $lvl) {
                $lvl = $v['lvl'];
            }

            if ($v['lvl'] === 0) {
                if ($root === 0) {
                    $root = $v['root'];
                }
                $arr[$root] = $item;
            }
            if ($v['lvl'] === 1) {
                if ($a === 0) {
                    $a = $v['id'];
                }
                if ($levemore) {
                    $arr[$root]['children'][$v['id']] = $item;
                } else {
                    $arr[$root]['children'][$a] = $item;
                }
            }
            if ($v['lvl'] === 2) {
                $levemore = true;
                $arr[$root]['children'][$a]['children'][] = $item;
            }
        }
//        return $arr;
        $catList = [];
        foreach ($cats as $k => $v) {
            if ($v['lvl'] == 0) {//一级节点
                $catList[$v['id']]['id'] = $v['id'];
                $catList[$v['id']]['name'] = $v['name'];
                $secondArr = self::getAllChildren($v, $cats);
                if ($secondArr) {
                    $catList[$v['id']]['children'] = array();
                    foreach ($secondArr as $m => $n) {
                        if ($n['lvl'] == 1) {//二级节点
                            $catList[$v['id']]['children'][$n['id']]['id'] = $n['id'];
                            $catList[$v['id']]['children'][$n['id']]['name'] = $n['name'];
                            $thirdArr = self::getAllChildren($n, $secondArr);
                            if ($thirdArr) {
                                foreach ($thirdArr as $l => $r) {
                                    $catList[$v['id']]['children'][$n['id']]['children'] = array();
                                    if ($r['lvl'] == 2) {//三级节点
                                        $catList[$v['id']]['children'][$n['id']]['children'][] = [
                                            'id' => $r['id'],
                                            'name' => $r['name']];
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
        return $catList;
    }

    /**
     * 获取分类，构造二维数组，第一维为一级分类，第二维为二级分类
     */
    public static function getIndustryArr() {
        $cats = self::getApiIndustries();
        if (!$cats) {
            return [];
        }
        $catList = [];
        foreach ($cats as $k => $v) {
            if ($v['lvl'] == 0) {//一级节点
                $catList[$v['id']]['id'] = $v['id'];
                $catList[$v['id']]['name'] = $v['name'];
                $secondArr = self::getAllChildren($v, $cats);
                if ($secondArr) {
                    $catList[$v['id']]['children'] = array();
                    foreach ($secondArr as $m => $n) {
                        if ($n['lvl'] == 1) {//二级节点
                            $catList[$v['id']]['children'][$n['id']]['id'] = $n['id'];
                            $catList[$v['id']]['children'][$n['id']]['name'] = $n['name'];
                            $thirdArr = self::getAllChildren($n, $secondArr);
                            if ($thirdArr) {
                                foreach ($thirdArr as $l => $r) {
                                    $catList[$v['id']]['children'][$n['id']]['children'] = array();
                                    if ($r['lvl'] == 2) {//三级节点
                                        $catList[$v['id']]['children'][$n['id']]['children'][] = [
                                            'id' => $r['id'],
                                            'name' => $r['name']];
                                    }
                                }
                            }
                        }
                    }
                }
            }

        }
        return $catList;
    }

    /**
     * 获取子节点
     */
    public static function getAllChildren($node, $cats) {
        $childArr = [];
        foreach ($cats as $cat) {
            if ($node['lft'] < $cat['lft'] && $node['rgt'] > $cat['rgt'] && $node['root'] == $cat['root']) {
                $childArr[] = $cat;
            }
        }
        return $childArr;
    }

    /**
     * 获取子节点
     */
    public static function getNextChildren($node, $cats) {
        $childArr = [];
        foreach ($cats as $cat) {
            if ($node['lft'] < $cat['lft'] && $node['rgt'] > $cat['rgt'] && ($node['lvl'] + 1) == $cat['lvl'] && $node['root'] == $cat['root']) {
                $childArr[] = $cat;
            }
        }
        return $childArr;
    }

    //获取父级节点列表
    public static function getParentNodeInfo($node, $cats) {
        $parentArr = [];
        foreach ($cats as $cat) {
            if ($node['lft'] > $cat['lft'] && $node['rgt'] < $cat['rgt'] && $node['root'] == $cat['root']) {
                $parentArr[] = $cat;
            }
        }
        return $parentArr;
    }

    //获取父级分类和父级对应的同级的分类
    public static function getParentNodeList($node_id, $cats) {
        $_node_info = Industry::getNodeInfo($node_id, true);
        if (empty($_node_info)) {
            return false;
        }

        $_parent_list = self::getParentNodeInfo($_node_info, $cats);
        if (empty($_parent_list)) {
            return false;
        }

        $_all_list = array_merge($_parent_list, [$_node_info]);
        if (!empty($_all_list)) {
            foreach ($_all_list as $key => $val) {
                $_all_list[$key]['_level_list'] = self::getNodeInfoByLevel($val, $cats);
            }
        }
        return $_all_list;
    }

    //获取同级节点列表
    public static function getNodeInfoByLevel($node, $cats) {
        $Arr = [];
        foreach ($cats as $cat) {
            if ($node['lvl'] == $cat['lvl'] && $node['lvl'] == 0 && $cat['lvl'] == 0) {
                $Arr[] = $cat;
            } else if ($node['lvl'] == $cat['lvl'] && $node['root'] == $cat['root']) {
                $Arr[] = $cat;
            }
        }
        return $Arr;
    }

    /**
     * 通过节点id获取节点信息
     */
    public
    static function getNodeInfo($id, $all_info = false) {
        $data = Yii::$app->redis->get('Maker_Rc_industryList');
        $info = array(
            'name' => ''
        );
        if (!$data) {
            $expireTime = \Yii::$app->params['catExpireTime'];
            // 将 $data 存放到缓存供下次使用
            $data = self::getApiIndustries();
            $redis = yii::$app->redis;
            $redis->setex('Maker_Rc_industryList', $expireTime, json_encode($data));
        } else {
            $data = json_decode($data, true);
        }
        foreach ($data as $val) {
            if ($val['id'] == $id) {
                if ($all_info) {
                    $info = $val;
                } else {
                    $info['name'] = $val['name'];
                }
            }

        }

        return $info;
    }

    /**
     * 获取接口数据
     */
    public static function getApiIndustries() {

        $url = yii::$app->params['industryListUrl'];
        $data = [
        ];
        $cats = VsoApi::send($url, $data, $type = "get");
        if (empty($cats['data'])) {
            return [];
        } else {
            return $cats['data'];
        }

    }

    /**
     * 从缓存中获取分类数据
     */
    public static function getIndustryList() {
        // 尝试从缓存中取回 $data
        $data = yii::$app->redis->get('Maker_Rc_catList');
        if (!$data) {
            $expireTime = \Yii::$app->params['catExpireTime'];
            // 将 $data 存放到缓存供下次使用
            $data = Industry::getApiIndustryList();
            $redis = yii::$app->redis;
            $redis->setex('Maker_Rc_catList', $expireTime, json_encode($data));
        } else {
            $data = json_decode($data, true);
        }
        return $data;
    }

    /**
     * 三级分类联动需要的json结构
     * 前台调用方式是bui的三级联动，然后是静态调用方式
     * json格式如下
     * $jsonStr = '[{"id":"1","text":"山东","children":[{"id":"11","text":"济南","leaf":false,"children":[{"id":"121","text":"斯蒂芬撒旦区","leaf":true},
     * {"id":"121","text":"斯蒂芬斯蒂芬","leaf":true}]},{"id":"12","text":"淄博","leaf":false,"children":[{"id":"121","text":"淄川区","leaf":true},
     * {"id":"121","text":"某区","leaf":true}]}]},{"id":"2","text":"广东","children":[{"id":"21","text":"广州","leaf":false,"children":[{"id":"211","text":"花都区","leaf":true},
     * {"id":"211","text":"海珠区","leaf":true}]},{"id":"22","text":"茂名","leaf":false,"children":[{"id":"221","text":"化区","leaf":true}]}]}]';
     *
     */
    public static function industryToJson() {
        /**
         * 重拼三级分类需要的数组结构
         *
         */
        $cateArr = array();
        $pArr = Industry::getIndustryList();
        $i = 0;
        foreach ($pArr as $aitem) {
            $item = array();
            $item['id'] = "{$aitem['id']}";
            $item['text'] = $aitem['name'];
            if (isset($aitem['children'])) {
                $item['leaf'] = false;
                $j = 0;
                foreach ($aitem['children'] as $bitem) {
                    $itemb = array();
                    $itemb['id'] = "{$bitem['id']}";
                    $itemb['text'] = $bitem['name'];
                    if (isset($bitem['children'])) {
                        $itemb['leaf'] = false;
                        $item['children'][$j] = $itemb;
                        $k = 0;

                        foreach ($bitem['children'] as $citem) {
                            $itemc = array();
                            $itemc['id'] = "{$citem['id']}";
                            $itemc['text'] = $citem['name'];
                            $itemc['leaf'] = true;
                            $item['children'][$j]['children'][] = $itemc;
                            $k++;
                        }
                    } else {
                        $itemb['leaf'] = true;
                        $item['children'][$j] = $itemb;
                    }
                    $j++;
                }

            } else {
                $item['leaf'] = true;
            }
            $cateArr[$i] = $item;
            $i++;
        }
        return json_encode($cateArr);
    }
}

?>