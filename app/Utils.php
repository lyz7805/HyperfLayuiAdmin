<?php

declare(strict_types=1);

namespace App;

use Hyperf\DbConnection\Db;

class Utils
{
    /**
     * 随机字符串生成
     *
     * @param int $len 字符串长度，默认64位
     * @param string|null $chars 随机生成字符串的范围
     * @return string
     */
    public static function createRandStr(int $len = 64, ?string $chars = null): string
    {
        if (!$chars) {
            $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        return substr(str_shuffle(str_repeat($chars, rand(5, 8))), 0, $len);
    }

    /**
     * 转换特定数据位数组
     *
     * @param string $data
     * @param string $fromType
     * @return array
     */
    public static function convertDataToArray(string $data, $fromType = 'JSON')
    {
        switch (strtoupper($fromType)) {
            case 'XML':
                $rs = xmlrpc_decode($data);
                break;
            case 'JSON':
            default:
                $rs = json_decode($data, true);
                break;
        }
        return $rs;
    }

    /**
     * 加密密码
     *
     * @param string $password 原始密码
     * @param string $salt 盐值
     * @return string
     */
    public static function encryptPassword(string $password, string $salt): string
    {
        return md5(md5(sha1($password . $salt)));
    }

    /**
     * 数组生成树
     *
     * @param array $list
     * @param integer $root 
     * @param string $id
     * @param string $pid
     * @param string $child
     * @return array
     */
    public static function listToTree(array $list, int $root = 0, string $id = 'id', string $pid = 'parent_id', string $child = 'child')
    {
        $tree = [];

        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$id]] = &$list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId = $data[$pid];
            if ($root == $parentId) {
                $tree[] = &$list[$key];
            } else {
                if (isset($refer[$parentId])) {
                    $parent = &$refer[$parentId];
                    $parent[$child][] = &$list[$key];
                }
            }
        }

        return $tree;
    }

    public static function parseTreeMenuToList(array $tree, int $parentId = 0, array &$menus = []): array
    {
        $id = $parentId + 1;

        foreach ($tree as $m) {
            $menu = [
                'id' => $id,
                'parent_id' => $parentId,
                'is_menu' => 1,
                'title' => $m['title'],
                'href' => $m['href'] ?: null,
                'icon' => $m['icon'],
                'target' => $m['target'] ?: '_self',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (Db::table('admin_menu')->where('id', $menu['id'])->doesntExist()) {
                Db::table('admin_menu')->insert($menu);
            }
            $menus[] = $menu;

            if (isset($m['child'])) {
                $childParentId = $id;
                self::parseTreeMenuToList($m['child'], $childParentId, $menus);
                $id = count($menus) + 1;
            } else {
                $id++;
            }
        }

        return $menus;
    }

    public static function sha1(...$str)
    {
        $string = implode('-', array_values($str));
        return sha1($string, false);
    }

    public static function dataHashKey(array $data)
    {
        $sortKey = [
            'id',
            'measurement',
            'bk',
            'mk',
            'xm',
            'zjmc',
            'year',
            'date',
        ];

        if (isset($data['type'])) {
            if ($data['type'] == 'day') {
                unset($data['date']);
                unset($data['year']);
            }
        }

        $string = '';
        foreach ($sortKey as $key) {
            if (count($data) == 0) {
                break;
            }

            if (isset($data[$key])) {
                $string .= '$key' . '=' . $data[$key];
                unset($data[$key]);
            }
        }

        return sha1($string, false);
    }
}
