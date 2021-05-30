<?php

namespace Src\Repository;

abstract class BaseRepository {

    protected $databaseConnection = null;

    public function __construct($databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }
}