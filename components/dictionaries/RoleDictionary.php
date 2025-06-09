<?php

namespace app\components\dictionaries;

class RoleDictionary extends BaseDictionary
{
    public const ADMIN = 0;
    public const JURY = 1;
    public const PARTICIPANT = 2;
    public function getList(){
        return [
            self::ADMIN => 'Администратор',
            self::JURY => 'Организатор',
            self::PARTICIPANT => 'Участник',
        ];
    }
    public function customSort(){
        return [
            self::ADMIN,
            self::JURY,
            self::PARTICIPANT,
        ];
    }
}