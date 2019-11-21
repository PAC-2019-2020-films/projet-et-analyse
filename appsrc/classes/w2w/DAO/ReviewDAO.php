<?php


namespace DAO;


use Model\Movie;
use Model\Review;
use Model\User;

class ReviewDAO extends BaseDAO
{
    private string $table = 'reviews';

    /**
     * ReviewDAO constructor.
     */
    public function __construct()
    {
        parent::__construct();
    }


    /**
    * @return bool|array
    */
    public function selectAllReviews()
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id,  
                FROM {$this->table}
                ORDER BY {$this->table}.created_at;
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
    public function selectReviewById(int $id)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
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
    * @param Movie $movie
    * @return bool|array
    */
    public function selectReviewsByMovie(Movie $movie)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
                FROM {$this->table}
                WHERE {$this->table}.fk_movie_id = :movieId;
                ";

        $condition = [':movieId' => $movie->getId()];

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
    * @return bool|array
    */
    public function selectReviewsByUser(User $user)
    {
        $sql = "SELECT  {$this->table}.id, 
                        {$this->table}.content, 
                        {$this->table}.created_at, 
                        {$this->table}.updated_at, 
                        {$this->table}.fk_movie_id, 
                        {$this->table}.fk_user_id, 
                        {$this->table}.fk_rating_id
                FROM {$this->table}
                WHERE {$this->table}.fk_user_id = :userId;
                ";

        $condition = [':userId' => $user->getId()];

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
    * @param Review $review
    * @return bool|int
    */
    public function insertReview(Review $review)
    {
        $data = [
            'content' => $review->getContent(),
            'created_at' => $review->getCreatedAt(),
            'updated_at' => $review->getUpdatedAt(),
            'fk_movie_id' => $review->getMovie()->getId(),
            'fk_user_id' => $review->getUser()->getId(),
            'fk_rating_id' => $review->getRating()->getId(),
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
    * @param Review $review
    * @return bool|int
    */
    public function updateReview(Review $review)
    {
        $data = [
            'content' => $review->getContent(),
            'created_at' => $review->getCreatedAt(),
            'updated_at' => $review->getUpdatedAt(),
            'fk_movie_id' => $review->getMovie()->getId(),
            'fk_user_id' => $review->getUser()->getId(),
            'fk_rating_id' => $review->getRating()->getId(),
        ];

        $condition = "{$this->table}.id = {$review->getId()}";

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
    * @param Review $review
    * @return bool|int
    */
    public function deleteReview(Review $review)
    {
        $condition = "{$this->table}.id = {$review->getId()}";

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