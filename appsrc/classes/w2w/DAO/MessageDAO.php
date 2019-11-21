<?php


namespace DAO;


use Model\Message;
use DateTime;

class MessageDAO extends BaseDAO
{
    private string $table = 'messages';

    /**
     * MessageDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|Message[]
     */
    public function selectAllMessages()
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name, 
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;  
        ";

        $result = $this->select($sql);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param string $name
     * @return bool|Message[]
     */
    public function selectMessagesByName(string $name)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.first_name = :name 
                        OR {$this->table}.last_name = :name
                ORDER BY {$this->table}.created_at;  
        ";

        $condition = [':name' => $name];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $email
     * @return bool|Message[]
     */
    public function selectMessagesByEmail(string $email)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.email = :email
                ORDER BY {$this->table}.created_at;  
        ";

        $condition = [':email' => $email];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $keyword
     * @return bool|Message[]
     */
    public function selectMessagesByKeyword(string $keyword)
    {
        $needle = "%$keyword%";

        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.first_name LIKE :needle
                    OR {$this->table}.last_name LIKE :needle
                    OR {$this->table}.email LIKE :needle
                    OR {$this->table}.content LIKE :needle
                    OR {$this->table}.created_at LIKE :needle
                    OR {$this->table}.treated LIKE :needle
                ORDER BY {$this->table}.created_at;  
        ";

        $condition = [':needle' => $needle];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param DateTime $date
     * @return bool|Message[]
     */
    public function selectMessagesByDate(DateTime $date)
    {

        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.created_at = :date
                ORDER BY {$this->table}.first_name;  
        ";

        $condition = [':date' => $date];

        $result = $this->select($sql);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param bool $treated
     * @return bool|Message[]
     */
    public function selectMessagesByTreated(bool $treated)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                       {$this->table}.email,
                       {$this->table}.content,
                       {$this->table}.created_at,
                       {$this->table}.treated
                FROM {$this->table}
                WHERE {$this->table}.treated = :treated
                ORDER BY {$this->table}.created_at;  
        ";

        $condition = [':treated' => $treated];

        $result = $this->select($sql);

        if (is_array($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


    /**
     * @param Message $message
     * @return bool|int
     */
    public function insertMessage(Message $message)
    {
        $data = [
            'first_name' => $message->getFirstName(),
            'last_name' => $message->getLastName(),
            'email' => $message->getEmail(),
            'content' => $message->getContent(),
            'created_at' => $message->getCreatedAt(),
            'treated' => $message->isTreated(),
        ];

        $result = $this->insert($this->table, $data);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Message $message
     * @return bool|int
     */
    public function updateMessage(Message $message)
    {
        $data = [
            'first_name' => $message->getFirstName(),
            'last_name' => $message->getLastName(),
            'email' => $message->getEmail(),
            'content' => $message->getContent(),
            'created_at' => $message->getCreatedAt(),
            'treated' => $message->isTreated(),
        ];

        $condition = "{$this->table}.id = {$message->getId()}";

        $result = $this->update($this->table, $data, $condition);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */
        return false;
    }

    /**
     * @param Message $message
     * @return bool|int
     */
    public function deleteMessage(Message $message)
    {
        $condition = "{$this->table}.id = {$message->getId()}";

        $result = $this->delete($this->table, $condition);

        if (is_int($result)) {
            return $result;
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }


}