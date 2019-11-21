<?php
    
    
    namespace Service;
    
    
    use Model\Artist;
    
    use DAO\ArtistDAO;
    
    class ArtistPublicService extends BaseService
    {
        private ArtistDAO $artistDAO;
        
        /**
         * ArtistPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->artistDAO = new ArtistDAO();
            
        }
        
        /**
         * artistObjectBinder
         * @param array $artistArray
         * @return bool|Artist
         */
        public function artistObjectBinder(array $artistArray)
        {
            if (isset($artistArray['id']) && isset($artistArray['last_name'])) {
                $artist = new Artist(
                    $artistArray['id'],
                    $artistArray['last_name']
                );
                
                if (isset($artistArray['first_name'])) {
                    $artist->setFirstName($artistArray['first_name']);
                }
                
                return $artist;
            } else {
                return false;
            }
        }
        
        /**
         * getAllArtists
         * @return Artist[]
         */
        public function getAllArtists()
        {
            $allArtistsArray = $this->artistDAO->selectAllArtists();
            $allArtists      = [];
            
            foreach ($allArtistsArray as $artist) {
                $art = $this->artistObjectBinder($artist);
                array_push($allArtists, $art);
            }
            return $allArtists;
        }
        
        /**
        * getArtistById
        * @param int $id
        * @return Artist
        */
        public function getArtistById(int $id)
        {
            $artistById = $this->artistDAO->selectArtistById($id);
            return $this->artistObjectBinder($artistById);
        }
        
        /**
        * getArtistsByName
        * @param string $name
        * @return Artist[]
        */
        public function getArtistsByName(string $name)
        {
            $artistsByNameArray = $this->artistDAO->selectArtistsByName($name);
            $artistsByName = [];
    
            foreach ($artistsByNameArray as $artist) {
                $art = $this->artistObjectBinder($artist);
                array_push($artistsByName, $art);
            }
            return $artistsByName;
        }
        
        
        
    }