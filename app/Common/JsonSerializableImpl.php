<?php

namespace App\Common;

use JsonSerializable;

/**
 * 通过get_object_vars($this)直接获取当前类的属性
 * ！！！如果此类被其他类继承，则子类的private属性不能被序列化
 */
class JsonSerializableImpl implements JsonSerializable
{
    /**
     * 通过get_object_vars($this)直接获取当前类的属性，包含private、protected属性
     * ！！！此种方法如果用在当前类则没问题，如果用在父类，则子类的private属性不能被序列化
     */
    public function jsonSerialize()
    {
        return get_object_vars($this);
    }
}
