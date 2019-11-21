<?php


namespace DAO;


use Model\User;
use w2w\AuthenticationToken;

class AuthenticationTokenDAO extends BaseDAO
{
    private string $table = 'authentication_tokens';
    private string $tableUser = 'users';

    /**
     * @param User $user
     * @return bool|AuthenticationToken
     */
    public function getTokenByUser(User $user)
    {
        $sql = "
            SELECT  {$this->table}.id,
                    {$this->table}.email,
                    {$this->table}.token,
                    {$this->table}.expires_at,
                    {$this->table}.verified_at,
                    {$this->table}.new_password,
                    {$this->table}.fk_user_id
            FROM {$this->table}
            WHERE {$this->table}.fk_user_id = :userId;
        ";

        $condition = [':userId' => $user->getId()];

        $result = $this->select($sql, $condition);

        if (is_array($result)){
            return $result[0];
        }

        return false;
    }

    /**
     * @param AuthenticationToken $token
     * @param User $user
     * @return bool|int
     */
    public function insertToken(AuthenticationToken $token, User $user)
    {

        $data = [
            'email' => $token->getEmail(),
            'token' => $token->getToken(),
            'expires_at' => $token->getExpiresAt(),
            'verified_at' => $token->getVerifiedAt(),
            'new_password' => $token->getNewPassword(),
            'fk_user_id' => $user->getId()
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
     * @param AuthenticationToken $token
     * @return bool|int
     */
    public function updateToken(AuthenticationToken $token)
    {
        $data = [
            'email' => $token->getEmail(),
            'token' => $token->getToken(),
            'expires_at' => $token->getExpiresAt(),
            'verified_at' => $token->getVerifiedAt(),
            'new_password' => $token->getNewPassword(),
            'fk_user_id' => $token->getUser()->getId()
        ];

        $condition = "{$this->table}.id = {$token->getId()}";

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
     * @param AuthenticationToken $token
     * @return bool|int
     */
    public function deleteToken(AuthenticationToken $token)
    {
        $condition = "{$this->table}.id = {$token->getId()}";

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