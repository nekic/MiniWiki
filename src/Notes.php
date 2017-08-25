<?php

/**
 * Created by PhpStorm.
 * User: nekic
 * Date: 8/15/17
 * Time: 11:59 AM
 */
class Notes
{

    public function create()
    {

        $title = $_POST['name'];
        $pid   = $_POST['pid'];
        $type  = $_POST['type'];

        $treeArr = MenuTree::getTreeArray();

        $id = max(array_keys($treeArr))+1;
        $treeArr[$id] = array(
            'title'=>$title,
            'pid' => $pid,
            'id'  => $id,
            'type' => $type,
            'sort'=> 0,
        );

        $content = '<?php ' . PHP_EOL . 'return ' . var_export($treeArr,true) .';';
        $res = file_put_contents('../src/tree.php',$content);

        $trees = MenuTree::genDynamicTree($treeArr);


        $result =  array(
            'status' => 1,
            'tree'   => $trees,
            'info'   => '操作成功',
        );

        echo json_encode($result);
    }

    public function rename()
    {

        $title = $_POST['name'];
        $id   = $_POST['id'];

        $treeArr = MenuTree::getTreeArray();
        $treeArr[$id]['title'] = $title;


        $content = '<?php ' . PHP_EOL . 'return ' . var_export($treeArr,true) .';';
        $res = file_put_contents('../src/tree.php',$content);

        $trees = MenuTree::genDynamicTree($treeArr);


        $result =  array(
            'status' => 1,
            'tree'   => $trees,
            'info'   => '操作成功',
        );

        echo json_encode($result);
    }

    public function delete()
    {

        $id   = $_POST['id'];

        $treeArr = MenuTree::getTreeArray();
        $item = $treeArr[$id];

        if($item['type']==1) { // 是文件，直接删除
            unset($treeArr[$id]);
        } else { // 是目录, 如果目录为空，可以删除
            $isDirEmpty = true;
            foreach ($treeArr as $row) {
                if($row['pid']==$id) { // 目录不为空，不能删除
                    $isDirEmpty = false;
                    break;
                }
            }

            if($isDirEmpty) {
                unset($treeArr[$id]);
            } else {
                $result =  array(
                    'status' => 0,
                    'info'   => '分类不为空，不能删除！',
                );

                echo json_encode($result);
                return 0;
            }
        }


        $content = '<?php ' . PHP_EOL . 'return ' . var_export($treeArr,true) .';';
        $res = file_put_contents('../src/tree.php',$content);

        $trees = MenuTree::genDynamicTree($treeArr);

        $result =  array(
            'status' => 1,
            'tree'   => $trees,
            'info'   => '操作成功',
        );

        echo json_encode($result);
    }

    public function save()
    {
        $id = $_POST['id'];
        $content = $_POST['content'];
        $res = file_put_contents('../articles/1-200/'.$id,$content);

        $result =  array(
            'status' => 1,
            'info'   => '操作成功',
        );

        echo json_encode($result);
    }

    public function get()
    {
        $id = $_GET['id'];
        $content = file_get_contents('../articles/1-200/'.$id);
        $result =  array(
            'status' => 1,
            'info'   => '操作成功',
            'content'=> $content
        );

        echo json_encode($result);
    }
}