<?php
    
    
    namespace Service;
    
    
    use Model\Rating;
    
    class RatingPublicService extends PublicService
    {
        
        /**
         * RatingPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
         * ratingObjectBinder
         * @param array $ratingArray
         * @return bool|Rating
         */
        public function ratingObjectBinder(array $ratingArray)
        {
            if (isset($ratingArray['id']) && isset($ratingArray['name']) && isset($ratingArray['value'])) {
                $rating = new Rating(
                    $ratingArray['id'],
                    $ratingArray['name'],
                    $ratingArray['value'],
                );
                
                if ($ratingArray['description']) {
                    $rating->setValue($ratingArray['description']);
                }
                
                return $rating;
            } else {
                return false;
            }
        }
        
        /**
         * getAllRatings
         * @return Rating[]
         */
        public function getAllRatings()
        {
            $allRatingsArray = $this->ratingDAO->selectAllRatings();
            $allRatings = [];
    
            foreach ($allRatingsArray as $rating) {
                $rat = $this->ratingObjectBinder($rating);
                array_push($allRatings, $rat);
            }
            
            return $allRatings;
        }
        
        /**
         * @param int $id
         * @return Rating
         */
        public function getRatingById(int $id)
        {
            $ratingById = $this->ratingDAO->selectRatingById($id);
            return $this->ratingObjectBinder($ratingById);
            
        }
        
        /**
        * getRatingByName
        * @param string $name
        * @return Rating
        */
        public function getRatingByName(string $name)
        {
            $ratingByName = $this->ratingDAO->selectRatingByName($name);
            return $this->ratingObjectBinder($ratingByName);
        }
        
        /**
        * getRatingByValue
        * @param int $value
        * @return Rating
        */
        public function getRatingByValue(int $value)
        {
            $ratingByValue = $this->ratingDAO->selectRatingByValue($value);
            return $this->ratingObjectBinder($ratingByValue);
        }
        
    }