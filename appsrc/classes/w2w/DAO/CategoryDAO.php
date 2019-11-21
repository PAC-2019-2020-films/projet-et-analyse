<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:30
 */

namespace DAO;


use Model\Category;

class CategoryDAO extends BaseDAO
{

    private string $table = "categories";

    /**
     * @return bool|Category[]
     */
    public function selectAllCategories()
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

        return false;
    }

    /**
     * @param int $id
     * @return bool|array
     */
    public function selectCategoryById(int $id)
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

        return false;
    }

    /**
     * @param string $name
     * @return bool|Category
     */
    public function selectCategoryByName(string $name)
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

        return false;
    }

    /**
     * @param Category $category
     * @return bool|int
     */
    public function insertCategory(Category $category)
    {
        $data = [
            'name' => $category->getName(),
            'description' => $category->getDescription()
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
     * @param Category $category
     * @return bool|int
     */
    public function updateCategory(Category $category)
    {
        $data = [
            'name' => $category->getName(),
            'description' => $category->getDescription()
        ];

        $condition = "{$this->table}.id = {$category->getId()}";

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
     * @param Category $category
     * @return bool|int
     */
    public function deleteCategory(Category $category)
    {
        $condition = "{$this->table}.id = {$category->getId()}";

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