<?php


namespace DAO;


use Model\Rating;

class RatingDAO extends BaseDAO
{
    private string $table = "ratings";

    /**
     * RatingDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|array
     */
    public function selectAllRatings()
    {
        $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table}
                ORDER BY {$this->table}.value;
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
    public function selectRatingById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.id = :id";


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
    public function selectRatingByName(string $name)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.name = :name";


        $condition = [':name' => $name];

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
     * @param int $value
     * @return bool|array
     */
    public function selectRatingByValue(int $value)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description, 
                        {$this->table}.value
                FROM {$this->table} 
                WHERE {$this->table}.value = :value";


        $condition = [':value' => $value];

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
     * @param Rating $rating
     * @return bool|int
     */
    public function insertRating(Rating $rating)
    {
        $data = [
            'name' => $rating->getName(),
            'description' => $rating->getDescription(),
            'value' => $rating->getValue()
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
     * @param Rating $rating
     * @return bool|int
     */
    public function updateRating(Rating $rating)
    {
        $data = [
            'name' => $rating->getName(),
            'description' => $rating->getDescription(),
            'value' => $rating->getValue()
        ];

        $condition = "{$this->table}.id = {$rating->getId()}";

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
     * @param Rating $rating
     * @return bool|int
     */
    public function deleteRating(Rating $rating)
    {
        $condition = "{$this->table}.id = {$rating->getId()}";

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