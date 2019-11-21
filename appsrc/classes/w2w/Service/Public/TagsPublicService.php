<?php
    
    
    namespace Service;
    
    
    use DAO\TagsDAO;
    use Model\Tag;
    
    class TagsPublicService extends BaseService
    {
        
        private TagsDAO $tagsDAO;
        
        /**
         * TagsPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->tagsDAO = new TagsDAO();
        }
        
        /**
         * tagObjectBinder
         * @param array $tagArray
         * @return bool|Tag
         */
        public function tagObjectBinder(array $tagArray)
        {
            if (isset($tagArray['id']) && isset($tagArray['name'])) {
                $tag = new Tag(
                    $tagArray['id'],
                    $tagArray['name']
                );
                
                if (isset($tagArray['description'])) {
                    $tag->setDescription($tagArray['description']);
                }
                return $tag;
            } else {
                return false;
            }
        }
        
        /**
         * getAllTags
         * @return Tag[]
         */
        public function getAllTags()
        {
            $allTagsArray = $this->tagsDAO->selectAllTags();
            $allTags      = [];
            
            foreach ($allTagsArray as $tag) {
                $ta = $this->tagObjectBinder($tag);
                array_push($allTags, $ta);
            }
            
            return $allTags;
        }
        
        /**
         * getTagById
         * @param int $id
         * @return Tag
         */
        public function getTagById(int $id)
        {
            $tagById = $this->tagsDAO->selectTagById($id);
            return $this->tagObjectBinder($tagById);
        }
        
        /**
         * getTagByName
         * @param string $name
         * @return Tag
         */
        public function getTagByName(string $name)
        {
            $tagByName = $this->tagsDAO->selectTagByName($name);
            return $this->tagObjectBinder($tagByName);
        }
        
        
    }