<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:26
 */

namespace DAO;

use PDO;
use PDOException;

class BaseDAO extends PDO
{

    /*
    * TODO : GET DB PARAMS FROM CONFIG
    */

    private string $dsn = 'mysql:dbname=w2w; host=localhost; charset=utf8';
    private string $user = 'w2w';
    private string $password = '';

    /**
     * BaseDAO constructor.
     */
    public function __construct()
    {
        parent::__construct($this->dsn, $this->user, $this->password);
    }

    /**
     * @param string $sql : complete SQL SELECT statement
     * @param array $conditions : associative array with the key being the named parameter and the value being the value to bind.
     *
     * @return array|PDOException
     */
    public function select(string $sql, $conditions = null)
    {
        $dbh = $this->prepare($sql);

        if ($conditions != null) {
            foreach ($conditions as $key => $value) {
                $dbh->bindValue($key, $value);
            }
        }

        try {
            $dbh->execute();
            return $dbh->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $exception) {
            return $exception;
        }

    }

    /**
     * @param string $table : target table where insert will take place in the DB.
     * @param array $data : associative array of the data to insert in the DB where the Key = DB column and the Value = Value to store in DB.
     *
     * @return int|PDOException : returns PDO::lastInsertId() value or PDOException
     */
    public function insert(string $table, array $data)
    {
        $keys = implode(', ', array_keys($data));
        $values = ':' . implode(', :', array_keys($data));

        $sql = "INSERT INTO $table ($keys) VALUES ($values)";
        $dbh = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $dbh->bindValue($key, $value);
        }

        try {
            $dbh->execute();
            return $this->lastInsertId();
        } catch (PDOException $exception) {
            return $exception;
        }
    }

    /**
     * @param string $table : target table where update will take place in the DB.
     * @param array $data : associative array of the data to update in the DB where the Key = DB column and the Value = Value to store in DB.
     * @param string $condition : SQL condition syntax ie. "someColumn = {$someValue} AND anotherColumn = {$someOtherValue}"
     *
     * @return bool|PDOException : returns PDO::rowCount() value or PDOException
     */
    public function update(string $table, array $data, string $condition)
    {
        $upkeys = '';

        foreach ($data as $key => $value) {
            $upkeys .= "$key =:$key,";
        }

        $upkeys = rtrim($upkeys, ',');

        $sql = "UPDATE $table SET $upkeys WHERE $condition";

        $dbh = $this->prepare($sql);

        foreach ($data as $key => $value) {
            $dbh->bindValue($key, $value);
        }

        try {
            $dbh->execute();
            return $dbh->rowCount();
        } catch (PDOException $exception) {
            return $exception;
        }
    }

    /**
     * @param string $table : target table where delete will take place in the DB.
     * @param string $condition : SQL condition syntax ie. "someColumn = {$someValue} AND anotherColumn = {$someOtherValue}"
     * @return bool|PDOException : returns PDO::rowCount() value or PDOException
     */
    public function delete(string $table, string $condition)
    {
        $sql = "DELETE FROM $table WHERE $condition";
        $dbh = $this->prepare($sql);

        try {
            $dbh->execute();
            return $dbh->rowCount();
        } catch (PDOException $exception) {
            return $exception;
        }
    }

}