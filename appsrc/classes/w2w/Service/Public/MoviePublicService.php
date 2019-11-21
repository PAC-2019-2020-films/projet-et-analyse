<?php
    
    
    namespace Service;
    
    use DateTime;
    
    use Model\Artist;
    use Model\Category;
    use Model\Movie;
    use Model\Rating;
    use Model\Tag;
    
    class MoviePublicService extends PublicService
    {
        private CategoryPublicService $categoryService;
        private ReviewPublicService $reviewService;
        private RatingPublicService $ratingService;
        
        /**
         * MoviePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            
            $this->categoryService = new CategoryPublicService();
            $this->reviewService   = new ReviewPublicService();
            $this->ratingService   = new RatingPublicService();
        }
        
        
        /**
         * Binds a PDO::fetchAll result row to a new Movie Object
         * @param array $movieArray
         * @return bool|Movie $movie
         */
        public function movieObjectBinder(array $movieArray)
        {
            if (isset($movieArray['id']) && isset($movieArray['title']) && isset($movieArray['fk_category_id'])) {
                
                $movie = new Movie(
                    $movieArray['id'],
                    $movieArray['title'],
                    $this->categoryService->getCategoryById($movieArray['fk_category_id'])
                );
                
                if ($movieArray['description']) {
                    $movie->setDescription($movieArray['description']);
                }
                
                if ($movieArray['year']) {
                    $movie->setYear($movieArray['year']);
                }
                
                if ($movieArray['poster']) {
                    $movie->setPoster($movieArray['poster']);
                }
                
                if ($movieArray['fk_admin_review.id']) {
                    $movie->setReviewAdmin($this->reviewService->getReviewById($movieArray['fk_admin_review.id']));
                }
                
                if ($movieArray['fk_rating_id']) {
                    $movie->setRating($this->ratingService->getRatingById($movieArray['fk_rating_id']));
                }

//            Fetch, instantiate and add tags to the Movie Object
                $movieTags = $this->movieTagsDAO->selectMovieTagsByMovie($movie);
                
                if ($movieTags) {
                    foreach ($movieTags as $movieTag) {
                        $tag = new Tag(
                            $movieTag['id'],
                            $movieTag['name'],
                        );
                        
                        if ($movieTag['description']) {
                            $tag->setDescription($movieTag['description']);
                        }
                        
                        $movie->addTag($tag);
                    }
                }

//            Fetch, instantiate and add directors to the Movie Object
                $movieDirectors = $this->movieDirectorDAO->selectMovieDirectorsByMovie($movie);
                
                if ($movieDirectors) {
                    foreach ($movieDirectors as $movieDirector) {
                        $director = new Artist(
                            $movieDirector['id'],
                            $movieDirector['last_name'],
                        );
                        
                        if ($movieDirector['first_name']) {
                            $director->setFirstName($movieDirector['first_name']);
                        }
                        
                        $movie->addDirector($director);
                    }
                }

//            Fetch, instantiate and add actors to the Movie Object
                $movieActors = $this->movieActorDAO->selectMovieActorsByMovie($movie);
                
                if ($movieActors) {
                    foreach ($movieActors as $movieActor) {
                        $actor = new Artist(
                            $movieActor['id'],
                            $movieActor['last_name'],
                        );
                        
                        if ($movieActor['first_name']) {
                            $actor->setFirstName($movieActor['first_name']);
                        }
                        
                        $movie->addDirector($actor);
                    }
                }
                
                return $movie;
            } else {
                return false;
            }
        }
        
        
        /**
         * getAllMovies
         * @return Movie[]
         */
        public function getAllMovies()
        {
//        Select movies from DB
            $movies[]  = $this->movieDAO->selectAllMovies();
            $allMovies = [];

//        Create new Movie Object for each DB row and push it to array
            foreach ($movies as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($allMovies, $mov);
            }
            
            return $allMovies;
        }
        
        
        /**
         * getMovieById
         * @param int $id
         * @return Movie
         */
        public function getMovieById(int $id)
        {
            $movieById = $this->movieDAO->selectMovieById($id);
            return $this->movieObjectBinder($movieById);
        }
        
        /**
         * @param int $id
         * @return Movie
         */
        public function getMovieByIdBarebone(int $id)
        {
            $movieById = $this->movieDAO->selectMovieById($id);
            
            $movie = new Movie(
                $movieById['id'],
                $movieById['title'],
                $this->categoryService->getCategoryById($movieById['fk_category_id'])
            );
            
            return $movie;
        }
        
        
        /**
         * getLastFiveMovies
         * @return Movie[]
         */
        public function getLastFiveMovies()
        {
            $lastFiveMoviesArray = $this->movieDAO->selectLastFiveMovies();
            
            $lastFiveMovies = [];
            
            foreach ($lastFiveMoviesArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($lastFiveMovies, $mov);
            }
            
            return $lastFiveMovies;
        }
        
        /**
         * getBestFiveMovies
         * @return Movie[]
         */
        public function getBestFiveMovies()
        {
            return $this->movieDAO->selectBestFiveMovies();
        }
        
        /**
         * getMoviesByCat
         * @param $category Category
         * @return Movie[]
         */
        public function getMoviesByCat(Category $category)
        {
            $moviesByCatArray = $this->movieDAO->selectMoviesByCat($category);
            $moviesByCat      = [];
            
            foreach ($moviesByCatArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($moviesByCat, $mov);
            }
            
            return $moviesByCat;
            
        }
        
        /**
         * getMoviesByTag
         * @param $tag Tag
         * @return Movie[]
         */
        public function getMoviesByTag(Tag $tag)
        {
            $moviesByTagArray = $this->movieDAO->selectMoviesByTag($tag);
            $moviesByTag      = [];
            
            foreach ($moviesByTagArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($moviesByTag, $mov);
            }
            
            return $moviesByTag;
        }
        
        /**
         * getMoviesByRating
         * @param Rating $rating
         * @return Movie[]
         */
        public function getMoviesByRating(Rating $rating)
        {
            $moviesByRatingArray = $this->movieDAO->selectMoviesByRating($rating);
            $moviesByRating      = [];
            
            foreach ($moviesByRatingArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($moviesByRating, $mov);
            }
            return $moviesByRating;
        }
        
        
        /**
         * getMoviesBySearch
         * @param string $keyword
         * @return Movie[]
         */
        public function getMoviesBySearch(string $keyword)
        {
            $moviesBySearchArray = $this->movieDAO->selectMoviesBySearch($keyword);
            $moviesBySearch      = [];
            
            foreach ($moviesBySearchArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($moviesBySearch, $mov);
            }
            
            return $moviesBySearch;
        }
        
        /**
        * getMoviesByDirector
        * @param Artist $director
        * @return Movie[]
        */
        public function getMoviesByDirector(Artist $director)
        {
            /**
            * TODO : GET MOVIES BY DIRECTOR
            */
            $movieByDirector = [];
            return $movieByDirector;
        }
        
        /**
        * getMoviesByActor
        * @param Artist $actor
        * @return Movie[]
        */
        public function getMoviesByActor(Artist $actor)
        {
            
            /**
            * TODO : GET MOVIES BY ACTOR
            */
            $movieByActor = [];
            return $movieByActor;
        }
        
        /**
        * getMoviesByYear
        * @param DateTime $date
        * @return Movie[]
        */
        public function getMoviesByYear(DateTime $date)
        {
            $movieByYearArray = $this->movieDAO->selectMoviesByYear($date);
            $movieByYear = [];
    
            foreach ($movieByYearArray as $movie) {
                $mov = $this->movieObjectBinder($movie);
                array_push($movieByYear, $mov);
            }
            return $movieByYear;
        }
        
    }