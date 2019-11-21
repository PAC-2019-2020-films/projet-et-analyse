<?php


namespace DAO;


use Model\Tag;

class TagsDAO extends BaseDAO
{
    private string $table = 'tags';

    /**
     * TagsDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
     * @return bool|array
     */
    public function selectAllTags()
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                ORDER BY {$this->table}.name;
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
    public function selectTagById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
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
    public function selectTagByName(string $name)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                WHERE {$this->table}.name = :name;
                ";

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
     * @param Tag $tag
     * @return bool|int
     */
    public function insertTag(Tag $tag)
    {
        $data = [
            'name' => $tag->getName(),
            'description' => $tag->getDescription()
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
     * @param Tag $tag
     * @return bool|int
     */
    public function updateTag(Tag $tag)
    {
        $data = [
            'name' => $tag->getName(),
            'description' => $tag->getDescription()
        ];

        $condition = "{$this->table}.id = {$tag->getId()}";

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
     * @param Tag $tag
     * @return bool|int
     */
    public function deleteTag(Tag $tag)
    {
        $condition = "{$this->table}.id = {$tag->getId()}";

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