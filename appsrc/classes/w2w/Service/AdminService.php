<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:28
     */
    
    namespace Service;
    
    
    use Model\Movie;

    class AdminService extends UserService
    {
        /**
        * addMovie
        * @param $movie
        * @return bool
        */
        public function addMovie(Movie $movie)
        {

            return false;
        }
        
        /**
        * editMovie
        * @param $movie
        * @return bool
        */
        public function editMovie(Movie $movie)
        {
            return false;
        }
        
        /**
        * deleteMovie
        * @param $movie
        * @return bool
        */
        public function deleteMovie(Movie $movie)
        {
            return false;
        }
        
    }