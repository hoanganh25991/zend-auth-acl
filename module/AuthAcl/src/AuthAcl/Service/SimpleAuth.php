<?php
namespace AuthAcl\Service;

use AuthAcl\Util\Encrypt;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Stdlib\ArrayUtils;
use Zend\Stdlib\ParametersInterface;

class SimpleAuth{
    /**
     * @param ParametersInterface $data (key,value) submited from loginForm
     * @return bool
     */

    public function auth($data){
        $email = $data->get('email');
        /** @var array $user */
        $user = $this->findUser($email);
        $encryptPass = Encrypt::hash($data->get('password'));
        if($encryptPass === $user['password']){
            return $user;
        }
        return false;
    }

    public function findUser($email){
        $table = 'users';
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
        $select->from($table)->where(array(
            "email" => $email,
        ));
        $statement = $sql->prepareStatementForSqlObject($select);
        $result = $statement->execute();
//        $a = $result;
        $resultSet = ArrayUtils::iteratorToArray($result);
        $firstResultSet = $resultSet[0];
        return $firstResultSet;
    }
}