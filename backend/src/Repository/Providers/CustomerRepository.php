<?php

namespace Src\Repository\Providers;

use Src\Repository\BaseRepository;
use Src\Repository\Helpers\Customers as CustomersHelper;
use Src\Repository\Interfaces\CustomerRepositoryInterface;

class CustomerRepository extends BaseRepository implements CustomerRepositoryInterface
{
    public function get()
    {
        $countries = CustomersHelper::$countries;

        $statement = "
            SELECT 
                id, name, phone
            FROM
                customer
        ";

        if(!empty($_GET) && isset($_GET['country']) && isset($countries[$_GET['country']])) {
            /*
            $countryFormat = $countries[$_GET['country']]['format'];
            $statement .= "Where phone REGEXP '" . $countryFormat."'";
            */
            $statement .= "Where phone like '(".$_GET['country'].")%'";
        }

        try {
            $statement = $this->databaseConnection->query($statement);
            $customers = $statement->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            exit($e->getMessage());
        }

        $customers = CustomersHelper::load($customers);

        return $customers;
    }
}