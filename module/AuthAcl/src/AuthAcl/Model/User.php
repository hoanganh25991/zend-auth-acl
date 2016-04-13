<?php
namespace AuthAcl\Model;

use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;

class User{
  protected $table = "users";

  /**
   * @param string $email
   * @return array $result
   */
  public function findUser($email){
    $adpater = new Adapter(array(
      'driver' => 'Pdo',
      'dsn' => 'mysql:dbname=zend_form-validate;host=localhost',
      'username' => 'root',
      'password' => 'ifrc',
      'driver_options' => array(
        \PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''
      )
    ));
    $sql = new Sql($adpater);
    $select = $sql->select();
    $select->from($this->table)->where(array(
      "email" => $email,
    ));
    $statement = $sql->prepareStatementForSqlObject($select);
    $result = $statement->execute();
    $a = $result;
    $resultSet = ArrayUtils::iteratorToArray($result);
    return $resultSet;
  }
}