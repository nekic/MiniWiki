<?php

/**
 * Created by PhpStorm.
 * User: nekic
 * Date: 8/14/17
 * Time: 11:55 PM
 */
class MenuTree
{
    public static function getMenuTree()
    {
        $source = self::prepare();
        $tree = self::makeTree($source);
        return $tree;
    }




    private static function prepare()
    {
        $tree = include '../src/tree.php';
        foreach ($tree as $id => &$row) {
            $row['html'] = '<span class="context-menu" data-pid="44">'.$row['title'].'</span>';
        }
        return $tree;
    }




    /**
     * 把返回的数据集转换成Tree
     * @param array $list 要转换的数据集
     * @param string $pk 自增字段（栏目id）
     * @param string $pid parent标记字段
     * @return array
     */
    private static function makeTree($list,$pk='id',$pid='pid',$child='children',$root=0){
        $tree=array();
        $packData=array();
        foreach ($list as  $data) {
            $packData[$data[$pk]] = $data;
        }
        foreach ($packData as $key =>$val){
            if($val[$pid]==$root){//代表跟节点
                $tree[]=& $packData[$key];
            }else{
                //找到其父类
                $packData[$val[$pid]][$child][]=& $packData[$key];
            }
        }
        return $tree;
    }

}