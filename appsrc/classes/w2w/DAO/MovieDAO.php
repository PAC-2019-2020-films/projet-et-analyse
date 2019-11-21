<?php
/**
 * Created by PhpStorm.
 * User: Meh
 * Date: 14/11/2019
 * Time: 20:31
 */

namespace DAO;


use Model\Artist;
use Model\Category;
use Model\Movie;
use Model\Rating;
use Model\Tag;
use DateTime;

class MovieDAO extends BaseDAO
{
    private string $table = 'movies';
    private string $tableCategories = 'categories';
    private string $tableReviews = 'reviews';
    private string $tableRating = 'ratings';
    private string $tableTags = 'tags';
    private string $tableMovieTags = 'movies_tags';

    /**
     * @return bool|Movie[]
     */
    public function selectAllMovies()
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                ORDER BY {$this->table}.year DESC;  
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
    public function selectMovieById(int $id)
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id,
                       {$this->table}.fk_admin_review.id,
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.id = :id
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
     * @param Category $category
     * @return bool|array
     */
    public function selectMoviesByCat(Category $category)
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.fk_category_id = :category
        ";

        $condition = [':category' => $category->getId()];

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
     * @return bool|array
     */
    public function selectMoviesByTag(Tag $tag)
    {
        $sql = "
                SELECT {$this->tableTags}.id, 
                       {$this->tableMovieTags}.fk_tag_id, 
                       {$this->tableMovieTags}.fk_movie_id, 
                       {$this->table}.id, 
                       {$this->table}.title,  
                       {$this->table}.description,  
                       {$this->table}.year,  
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->tableTags}
                    LEFT JOIN {$this->tableMovieTags} 
                            ON {$this->tableTags}.id = {$this->tableMovieTags}.fk_tag_id
                    LEFT JOIN {$this->table} 
                            ON {$this->table}.id = {$this->tableMovieTags}.fk_movie_id
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->tableTags}.id = :id;
       ";

        $condition = [':id' => $tag->getId()];

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
     * @param Rating $rating
     * @return bool|array
     */
    public function selectMoviesByRating(Rating $rating)
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.fk_rating_id = :rating
        ";

        $condition = [':rating' => $rating->getId()];

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
     * @return bool|array
     */
    public function selectMoviesBySearch(string $keyword)
    {
        $needle = "%$keyword%";

        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.title LIKE :needle
                            OR {$this->table}.description LIKE :needle
                ORDER BY {$this->table}.year DESC;  
        ";

        $condition = [':needle' => $keyword];

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
     * @return bool|array
     */
    public function selectLastFiveMovies()
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                ORDER BY {$this->table}.id DESC
                LIMIT 5;  
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
     * @return bool|Movie[]
     */
    public function selectBestFiveMovies()
    {
        /**
        * TODO : SELECT BEST FIVE MOVIES
        */
        return false;
    }

    /**
     * @param Artist $director
     * @return bool|Movie[]
     */
    public function selectMoviesByDirector(Artist $director)
    {
        /**
        * TODO : SELECT MOVIES BY DIRECTOR
        */
        return false;
    }

    /**
     * @param Artist $actor
     * @return bool|Movie[]
     */
    public function selectMoviesByActor(Artist $actor)
    {
        
        /**
        * TODO : SELECT MOVIES BY ACTOR
        */
        return false;
    }

    /**
     * @param DateTime $date
     * @return bool|array
     */
    public function selectMoviesByYear(DateTime $date)
    {
        $sql = "
                SELECT {$this->table}.id, 
                       {$this->table}.title, 
                       {$this->table}.description, 
                       {$this->table}.year, 
                       {$this->table}.poster, 
                       {$this->table}.fk_category_id, 
                       {$this->table}.fk_admin_review.id, 
                       {$this->table}.fk_rating_id
                FROM {$this->table}
                    LEFT JOIN {$this->tableCategories} 
                            ON {$this->tableCategories}.id = {$this->table}.fk_category_id
                    LEFT JOIN {$this->tableReviews} 
                            ON {$this->tableReviews}.id = {$this->table}.fk_admin_review_id
                    LEFT JOIN {$this->tableRating} 
                            ON {$this->tableRating}.id = {$this->table}.fk_rating_id
                WHERE {$this->table}.year = :date
                ORDER BY {$this->table}.title;  
        ";

        $condition = [':date', $date];

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
     * @param Movie $movie
     * @return bool|int
     */
    public function insertMovie(Movie $movie)
    {
        $data = [
            'title' => $movie->getTitle(),
            'description' => $movie->getDescription(),
            'year' => $movie->getYear(), // !!!! WARNING YEAR IS IN INT (wut?) in the DB while $movie->getYear() is DATETIME !!!!
            /*
            * TODO : update DB year field type
            */
            'poster' => $movie->getPoster(),
            'fk_category_id' => $movie->getCategory()->getId(),
            'fk_admin_review_id' => $movie->getReviewAdmin()->getId(),
            'fk_rating_id' => $movie->getRating()->getId()
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
     * @param Movie $movie
     * @return bool|int
     */
    public function updateMovie(Movie $movie)
    {
        $data = [
            'title' => $movie->getTitle(),
            'description' => $movie->getDescription(),
            'year' => $movie->getYear(), // !!!! WARNING YEAR IS IN INT (wut?) in the DB while $movie->getYear() is DATETIME !!!!
            /*
            * TODO : update DB year field type
            */
            'poster' => $movie->getPoster(),
            'fk_category_id' => $movie->getCategory()->getId(),
            'fk_admin_review_id' => $movie->getReviewAdmin()->getId(),
            'fk_rating_id' => $movie->getRating()->getId()
        ];

        $condition = "{$this->table}.id = {$movie->getId()}";

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
     * @param Movie $movie
     * @return bool|int
     */
    public function deleteMovie(Movie $movie)
    {
        $condition = "{$this->table}.id = {$movie->getId()}";

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