<?php
function staticAdminWeb(){
    return '/admin/';
}

/**
 * 数组的合并，并加上html标识前缀
 * @param array $data
 * @param int $pid
 * @param string $html
 * @param int $level
 * @return array
 */
function treeLevel(array $data, int $pid = 0, string $html = '--', int $level = 0) {
    static $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['html'] = str_repeat($html, $level * 2);
            $val['level'] = $level + 1;
            $arr[] = $val;
            treeLevel($data, $val['id'], $html, $val['level']);
        }
    }
    return $arr;
}


/**
 * 递归成多层数组
 * @param array $data
 * @param int $pid
 * @return array
 */
function subTree(array $data, int $pid = 0){
    $arr = [];
    foreach ($data as $val) {
        if ($pid == $val['pid']) {
            $val['sub'] = subTree($data,$val['id']);
            $arr[] = $val;
        }
    }
    return $arr;
}
