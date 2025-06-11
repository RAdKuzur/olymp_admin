<?php

namespace app\components\dictionaries;

class DisabilityDictionary extends BaseDictionary
{
    public const HEALTHY = 0;
    public const DISABILITY = 1;
    public function getList(){
        return [
            self::HEALTHY => 'Нет ОВЗ',
            self::DISABILITY => 'Есть ОВЗ'
        ];
    }
    public function customSort()
    {
        return [
            self::HEALTHY,
            self::DISABILITY
        ];
    }
}