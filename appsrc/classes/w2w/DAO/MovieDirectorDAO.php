<?php


namespace DAO;


use Model\Artist;
use Model\Movie;

class MovieDirectorDAO extends BaseDAO
{
    private string $table = 'movies_directors';
    private string $tableArtist = 'artists';
    private string $tableMovie = 'movies';

    /**
     * MovieDirectorDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * @param Movie $movie
     * @return bool|Artist[]
     */
    public function selectMovieDirectorsByMovie(Movie $movie)
    {
        $sql = "
                SELECT {$this->tableMovie}.id, 
                       {$this->table}.fk_movie_id, 
                       {$this->table}.fk_artist_id, 
                       {$this->tableArtist}.id, 
                       {$this->tableArtist}.last_name, 
                       {$this->tableArtist}.first_name
                FROM {$this->tableMovie}
                    LEFT JOIN {$this->table} 
                            ON {$this->tableMovie}.id = {$this->table}.id
                    LEFT JOIN {$this->tableArtist} 
                            ON {$this->table}.fk_artist_id={$this->tableArtist}.id
                WHERE {$this->tableMovie}.id = :id;
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
     * @param Artist $director
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovieDirector(Artist $director, Movie $movie)
    {
        $data = [
            "fk_movie_id" => $movie->getId(),
            "fk_artist_id" => $director->getId()
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
     * @param Artist $director
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieDirector(Artist $director, Movie $movie)
    {
        $condition = "
                {$this->table}.fk_movie_id = {$movie->getId()} 
            AND {$this->table}.fk_artist_id = {$director->getId()}
            ";

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