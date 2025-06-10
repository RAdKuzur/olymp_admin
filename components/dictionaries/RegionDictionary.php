<?php

namespace app\components\dictionaries;

use phpseclib3\Crypt\EC\Curves\secp112r1;

class RegionDictionary extends BaseDictionary
{
    public const ASTRAKHAN_REGION = 30;
    public function getList(){
        return [
            self::ASTRAKHAN_REGION => 'Астраханская область',
        ];
    }
    public function customSort(){
        return [
            self::ASTRAKHAN_REGION
        ];
    }
}