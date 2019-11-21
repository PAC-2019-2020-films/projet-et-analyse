<?php


namespace DAO;


use Model\Artist;

class ArtistDAO extends BaseDAO
{
    private string $table = 'artists';

    /**
     * ArtistDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|array
     */
    public function selectAllArtists()
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name
                FROM {$this->table}
                ORDER BY {$this->table}.first_name;  
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
    public function selectArtistById(int $id)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name,
                FROM {$this->table}
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
     * @param string $name
     * @return bool|array
     */
    public function selectArtistsByName(string $name)
    {
        $sql = "
                SELECT {$this->table}.id,
                       {$this->table}.first_name,
                       {$this->table}.last_name
                FROM {$this->table}
                WHERE {$this->table}.first_name = :name 
                    OR {$this->table}.last_name = :name 
                ORDER BY {$this->table}.first_name;  
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
     * @param Artist $artist : the Artist to insert in the DB
     * @return bool|int : returns false if it fails to insert into the DB, returns value of PDO::lastInsertId if it succeeds.
     */
    public function insertArtist(Artist $artist)
    {
        $data = [
            'first_name' => $artist->getFirstName(),
            'last_name' => $artist->getLastName()
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
     * @param Artist $artist
     * @return bool|int
     */
    public function updateArtist(Artist $artist)
    {
        $data = [
            'first_name' => $artist->getFirstName(),
            'last_name' => $artist->getLastName()
        ];

        $condition = "{$this->table}.id = {$artist->getId()}";

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
     * @param Artist $artist
     * @return bool|int
     */
    public function deleteArtist(Artist $artist)
    {
        $condition = "{$this->table}.id = {$artist->getId()}";

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