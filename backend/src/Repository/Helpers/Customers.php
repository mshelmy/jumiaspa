<?php

namespace Src\Repository\Helpers;

use Src\Common\Enums\States;

class Customers
{
    public static $countries = [
        '237' => [
            'name' => 'Cameroon',
            'code_format' => '/\(237\)/',
            'format' => '/\(237\)\ ?[2368]\d{7,8}$/'
        ],
        '251' => [
            'name' => 'Ethiopia',
            'code_format' => '/\(251\)/',
            'format' => '/\(251\)\ ?[1-59]\d{8}$/'
        ],
        '212' => [
            'name' => 'Morocco',
            'code_format' => '/\(212\)/',
            'format' => '/\(212\)\ ?[5-9]\d{8}$/'
        ],
        '258' => [
            'name' => 'Mozambique',
            'code_format' => '/\(258\)/',
            'format' => '/\(258\)\ ?[28]\d{7,8}$/'
        ],
        '256' => [
            'name' => 'Uganda',
            'code_format' => '/\(256\)/',
            'format' => '/\(256\)\ ?\d{9}$/'
        ]
    ];

    public static function load($customers)
    {
        $state = null;
        if (!empty($_GET) && isset($_GET['state']) && in_array($_GET['state'], States::all()))
            $state = $_GET['state'];

        foreach ($customers as $key => $customer){
            $countryPhoneCode = substr($customer['phone'], 1, 3);
            $country = self::$countries[$countryPhoneCode];

            if(preg_match($country['format'], $customer['phone'])){
                $customers[$key]['state'] = States::OK;
            } else if(preg_match($country["code_format"], $customer['phone'])){
                $customers[$key]['state'] = States::NOK;
            }

            if($state && $state != $customers[$key]['state']){
                unset($customers[$key]);
                continue;
            }

            $customers[$key]['phone'] = str_replace('('.$countryPhoneCode.') ','', $customers[$key]['phone']);
            $customers[$key]['code'] = '+' . $countryPhoneCode;
            $customers[$key]['country'] = $country['name'];
        }

        return array_values($customers);
    }
}