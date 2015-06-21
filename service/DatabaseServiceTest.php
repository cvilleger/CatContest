<?php

class DatabaseServiceTest extends PHPUnit_Framework_TestCase{

    public function testHaveConnection(){
        $DatabaseService = DatabaseService::getInstance();
        $Pdo = $DatabaseService->getPdo();

        $this->assertInstanceOf('PDO', $Pdo);
    }

}
