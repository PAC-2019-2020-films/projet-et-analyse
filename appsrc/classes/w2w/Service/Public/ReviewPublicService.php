<?php
    
    
    namespace Service;
    
    
    use Model\Movie;
    use Model\Review;
    use Model\User;

    class ReviewPublicService extends PublicService
    {
        
        private MoviePublicService $movieService;
        private UserPublicService $userService;
        private RatingPublicService $ratingService;
        
        /**
         * ReviewPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->movieService  = new MoviePublicService();
            $this->userService   = new UserPublicService();
            $this->ratingService = new RatingPublicService();
        }
        
        /**
         * reviewObjectBinder
         * Binds a PDO::fetchAll result row to a new Review Object
         * @param array $reviewArray
         * @return bool|Review
         */
        public function reviewObjectBinder(array $reviewArray)
        {
            if (isset($reviewArray['id']) && isset($reviewArray['content']) && isset($reviewArray['created_at']) && isset($reviewArray['fk_movie_id']) && isset($reviewArray['fk_user_id']) && isset($reviewArray['fk_rating_id'])) {
                $review = new Review(
                    $reviewArray['id'],
                    $reviewArray['content'],
                    $reviewArray['created_at'],
                    $this->movieService->getMovieByIdBarebone($reviewArray['fk_movie_id']),
                    $this->userService->getUserById($reviewArray['fk_user_id']),
                    $this->ratingService->getRatingById($reviewArray['fk_rating_id'])
                );
                
                if ($reviewArray['updated_at']) {
                    $review->setUpdatedAt($reviewArray['updated_at']);
                }
                
                return $review;
                
            } else {
                return false;
            }
        }
        
        /**
        * getAllReviews
        * @return Review[]
        */
        public function getAllReviews()
        {
            $allReviewsArray  = $this->reviewDAO->selectAllReviews();
            $allReviews = [];
    
            foreach ($allReviewsArray as $review) {
                $rev = $this->reviewObjectBinder($review);
                array_push($allReviews, $rev);
            }
            
            return $allReviews;
        }
        
        /**
         * @param int $id
         * @return Review
         */
        public function getReviewById(int $id)
        {
            $revById = $this->reviewDAO->selectReviewById($id);
            return $this->reviewObjectBinder($revById);
            
        }
        
        /**
        * getReviewsByMovie
        * @param Movie $movie
        * @return Review[]
        */
        public function getReviewsByMovie(Movie $movie)
        {
            $reviewsByMovieArray = $this->reviewDAO->selectReviewsByMovie($movie);
            $reviewsByMovie = [];
    
            foreach ($reviewsByMovieArray as $review){
                $rev = $this->reviewObjectBinder($review);
                array_push($reviewsByMovie, $rev);
            }
            
            return $reviewsByMovie;
        }
        
        /**
        * getReviewsByUser
        * @param User $user
        * @return Review[]
        */
        public function getReviewsByUser(User $user)
        {
            $reviewsByUserArray = $this->reviewDAO->selectReviewsByUser($user);
            $reviewByUser = [];
    
            foreach ($reviewsByUserArray as $review) {
                $rev = $this->reviewObjectBinder($review);
                array_push($reviewByUser, $rev);
            }
            
            return $reviewByUser;
        }
        
        
    }