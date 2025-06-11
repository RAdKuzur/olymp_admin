<?php

namespace app\components\dictionaries;

class ClassDictionary extends BaseDictionary
{
    public const CLASS_9 = 9;
    public const CLASS_10 = 10;
    public const CLASS_11 = 11;
    public function getList(){
        return [
            self::CLASS_9 => '9 класс',
            self::CLASS_10 => '10 класс',
            self::CLASS_11 => '11 класс',
        ];
    }
    public function customSort()
    {
        return [
            self::CLASS_9,
            self::CLASS_10,
            self::CLASS_11

        ];
    }
}