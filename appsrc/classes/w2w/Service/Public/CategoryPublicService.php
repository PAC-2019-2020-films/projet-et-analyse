<?php
    
    
    namespace Service;
    
    
    use Model\Category;
    
    class CategoryPublicService extends PublicService
    {
        /**
         * CategoryPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
         * categoryObjectBinder
         * Binds a PDO::fetchAll result row to a new Category Object
         * @param array $categoriesArray
         * @return bool|Category
         */
        public function categoryObjectBinder(array $categoriesArray)
        {
            if (isset($categoriesArray['id']) && isset($categoriesArray['name'])) {
                $category = new Category(
                    $categoriesArray['id'],
                    $categoriesArray['name']
                );
                
                if ($categoriesArray['description']) {
                    $category->setDescription($categoriesArray['description']);
                }
                
                return $category;
            } else {
                return false;
            }
        }
        
        /**
         * getAllCategories
         * @return Category[]
         */
        public function getAllCategories()
        {
            $categories[] = $this->categoryDAO->selectAllCategories();
            $allCategories = [];
            
            foreach ($categories as $category) {
                $cat = $this->categoryObjectBinder($category);
                array_push($allCategories, $cat);
            }
            
            return $allCategories;
        }
        
        /**
         * @param int $id
         * @return Category
         */
        public function getCategoryById(int $id)
        {
            $catById = $this->categoryDAO->selectCategoryById($id);
            
            $category = $this->categoryObjectBinder($catById);
            
            return $category;
        }
    }