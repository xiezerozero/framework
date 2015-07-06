<?php
/**
 * Test.php
 *
 * PhpStorm
 *
 * @author: xielin
 */

require_once 'TestUser.php';
require_once 'TestBook.php';

use Test\Collection\TestBook;
use Test\Collection\TestUser;

$testUser = new TestUser(12, 'testUser');
$testUser->getBookCollection()->addItem(new TestBook('name', 'number', '12.3'));

interface IDbInterface
{
    public function insert($table,$values,$fields = null, $dataTypes = null);

    public function update($table,$fields,$values,$where = null,$dataTypes = null);

    public function delete($table,$where = null,$placeHolders = null, $dataTypes = null);

    public function fetchOne($sqlQuery, $fetchModel = null, $placeHolders = null);

    public function fetchAll($sqlQuery, $fetchModel = null, $placeHolders = null);
}

class Mysql implements IDbInterface
{

    public function insert($table, $values, $fields = null, $dataTypes = null)
    {
    }

    public function update($table, $fields, $values, $where = null, $dataTypes = null)
    {
    }

    public function delete($table, $where = null, $placeHolders = null, $dataTypes = null)
    {
    }

    public function fetchOne($sqlQuery, $fetchModel = null, $placeHolders = null)
    {
    }

    public function fetchAll($sqlQuery, $fetchModel = null, $placeHolders = null)
    {
    }
}

class Oracle implements IDbInterface
{

    public function insert($table, $values, $fields = null, $dataTypes = null)
    {
    }

    public function update($table, $fields, $values, $where = null, $dataTypes = null)
    {
    }

    public function delete($table, $where = null, $placeHolders = null, $dataTypes = null)
    {
    }

    public function fetchOne($sqlQuery, $fetchModel = null, $placeHolders = null)
    {
    }

    public function fetchAll($sqlQuery, $fetchModel = null, $placeHolders = null)
    {
    }
}

class DatabaseFactory
{
    public static function factory($type)
    {
        switch ($type) {
            case 'mysql':
                return new Mysql();
            case 'oracle':
                return new Oracle();
        }
    }
}

