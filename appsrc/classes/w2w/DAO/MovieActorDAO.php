<?php


namespace DAO;


use Model\Artist;
use Model\Movie;

class MovieActorDAO extends BaseDAO
{
    private string $table = 'movies_actors';
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
    public function selectMovieActorsByMovie(Movie $movie)
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
     * @param Artist $actor
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovieActor(Artist $actor, Movie $movie)
    {
        $data = [
            "fk_movie_id" => $movie->getId(),
            "fk_artist_id" => $actor->getId()
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
     * @param Artist $actor
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovieActor(Artist $actor, Movie $movie)
    {
        $condition = "{$this->table}.fk_movie_id = {$movie->getId()} AND {$this->table}.fk_artist_id = {$actor->getId()}";

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