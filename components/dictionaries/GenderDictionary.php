<?php

namespace app\components\dictionaries;

class GenderDictionary extends BaseDictionary
{
    public const MALE = 0;
    public const FEMALE = 1;
    public function getList(){
        return [
            self::MALE => 'Мужской',
            self::FEMALE => 'Женский'
        ];
    }
    public function customSort()
    {
        return [
            self::MALE,
            self::FEMALE
        ];
    }
}