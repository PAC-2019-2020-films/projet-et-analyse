<?php


namespace DAO;

use Model\Movie;
use Model\Tag;

class MovieTagsDAO extends BaseDAO
{
    private string $table = 'movies_tags';
    private string $tableTag = 'tags';

    /**
     * MovieDirectorDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
    * @param Movie $movie
    * @return bool|Tag[]
    */
    public function selectMovieTagsByMovie(Movie $movie)
    {
        $sql = "
                SELECT {$this->table}.fk_movie_id, 
                       {$this->table}.fk_tag_id, 
                       {$this->tableTag}.id, 
                       {$this->tableTag}.name, 
                       {$this->tableTag}.description
                FROM {$this->table}
                    LEFT JOIN {$this->tableTag} 
                            ON {$this->tableTag}.id = {$this->table}.fk_tag_id
                WHERE {$this->table}.fk_movie_id = :id;
        ";

        $condition = [':id' => $movie->getId()];

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
     * @param Tag $tag
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovieTag(Tag $tag, Movie $movie)
    {
        $data = [
            "fk_movie_id" => $movie->getId(),
            "fk_tag_id" => $tag->getId()
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
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieTag(Tag $tag, Movie $movie)
    {
        $condition = "{$this->table}.fk_movie_id = {$movie->getId()} AND {$this->table}.fk_tag_id = {$tag->getId()}";

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