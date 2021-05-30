<?php

namespace Src\Common\Enums;

class States{
    const OK = 'OK';
    const NOK = 'NOK';

    public static function all(){
        return [
            self::OK, self::NOK
        ];
    }
}