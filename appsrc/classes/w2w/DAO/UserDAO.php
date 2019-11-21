<?php


namespace DAO;


use Model\Role;
use Model\User;
use w2w\AuthenticationToken;

class UserDAO extends BaseDAO
{
    private string $table = 'users';
    private string $tableRole = 'roles';
    private string $tableToken = 'authentication_tokens';

    /**
     * UserDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|User[]
     */
    public function selectAllUsers()
    {
        $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id = {$this->table}.fk_role_id
            ORDER BY {$this->table}.id;
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
     * @param int $id
     * @return bool|array
     */
    public function selectUserById(int $id)
    {
        $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id =  {$this->table}.fk_role_id
            WHERE {$this->table}.id = :id;
        ";

        $condition = [':id' => $id];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result[0];
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $email
     * @return bool|array
     */
    public function selectUserByMail(string $email)
    {
        $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->tableRole} ON {$this->tableRole}.id =  {$this->table}.fk_role_id
            WHERE {$this->table}.email = :email;
        ";

        $condition = [':email' => $email];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result[0];
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param string $userName
     * @return bool|array
     */
    public function selectUserByUserName(string $userName)
    {
        $sql = "
            SELECT  {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            WHERE {$this->table}.user_name = :username;
        ";

        $condition = [':username' => $userName];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result[0];
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param AuthenticationToken $authToken
     * @return bool|User
     */
    public function selectUserByToken(AuthenticationToken $authToken)
    {
        $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->tableToken}
              LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id 
            WHERE {$this->tableToken}.id = :tokenId;
        ";

        $condition = [':tokenId' => $authToken->getId()];

        $result = $this->select($sql, $condition);

        if (is_array($result)) {
            return $result[0];
        }

        /*
        * TODO : handle PDOException ?
        */

        return false;
    }

    /**
     * @param Role $role
     * @return bool|User[]
     */
    public function selectUsersByRole(Role $role)
    {
        $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id 
            WHERE {$this->table}.fk_role_id = :userRole;
        ";

        $condition = [':userRole' => $role->getId()];

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
     * @param bool $banned
     * @return bool|User[]
     */
    public function selectUsersBanned(bool $banned)
    {
        $sql = "
            SELECT  {$this->tableToken}.id, 
                    {$this->table}.id, 
                    {$this->table}.user_name, 
                    {$this->table}.email, 
                    {$this->table}.email_verified, 
                    {$this->table}.password_hash, 
                    {$this->table}.first_name, 
                    {$this->table}.last_name, 
                    {$this->table}.created_at,
                    {$this->table}.updated_at,
                    {$this->table}.last_login_at,
                    {$this->table}.banned,
                    {$this->table}.number_reviews,
                    {$this->table}.fk_role_id,
                    {$this->tableRole}.id,
                    {$this->tableRole}.name,
                    {$this->tableRole}.description
            FROM {$this->table}
            LEFT JOIN {$this->table} 
                ON {$this->table}.id = {$this->tableToken}.fk_user_id
            WHERE {$this->table}.banned = :banned;
        ";

        $condition = [':banned' => $banned];

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
     * @param User $user
     * @return bool|int
     */
    public function insertUser(User $user)
    {
        $data = [
            'user_name' => $user->getUserName(),
            'email' => $user->getEmail(),
            'email_verified' => $user->isEmailVerified(),
            'password_hash' => $user->getPasswordHash(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
            'last_login_at' => $user->getLastLoginAt(),
            'banned' => $user->isBanned(),
            'number_reviews' => $user->getNumberReviews(),
            'fk_role_id' => $user->getRole()->getId(),
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
     * @param User $user
     * @return bool|int
     */
    public function updateUser(User $user)
    {
        $data = [
            'user_name' => $user->getUserName(),
            'email' => $user->getEmail(),
            'email_verified' => $user->isEmailVerified(),
            'password_hash' => $user->getPasswordHash(),
            'first_name' => $user->getFirstName(),
            'last_name' => $user->getLastName(),
            'created_at' => $user->getCreatedAt(),
            'updated_at' => $user->getUpdatedAt(),
            'last_login_at' => $user->getLastLoginAt(),
            'banned' => $user->isBanned(),
            'number_reviews' => $user->getNumberReviews(),
            'fk_role_id' => $user->getRole()->getId(),
        ];

        $condition = "{$this->table}.id = {$user->getId()}";

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
     * @param User $user
     * @return bool|int
     */
    public function deleteUser(User $user)
    {
        $condition = "{$this->table}.id = {$user->getId()}";

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