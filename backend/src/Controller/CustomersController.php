<?php

namespace Src\Controller;

use Src\Controller\Http\Responses;
use Src\Repository\Providers\CustomerRepository;

class CustomersController
{
    private $databaseConnection;
    private $requestMethod;
    private $customerRepository;

    use Responses;

    public function __construct($databaseConnection, $requestMethod)
    {
        $this->databaseConnection = $databaseConnection;
        $this->requestMethod = $requestMethod;
        $this->customerRepository = new CustomerRepository($databaseConnection);
    }

    private function index()
    {
        return $this->customerRepository->get();
    }
}