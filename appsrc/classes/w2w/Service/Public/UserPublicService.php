<?php
    
    
    namespace Service;
    
    use Model\User;
    
    class UserPublicService extends PublicService
    {
        
        private RolePublicService $roleService;
        
        /**
         * UserPublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
            $this->roleService = new RolePublicService();
        }
        
        /**
         * userObjectBinder
         * Binds a PDO::fetchAll result row to a new Category Object
         * @param array $userArray
         * @return bool|User
         */
        public function userObjectBinder(array $userArray)
        {
            if (isset($userArray['id']) && isset($userArray['user_name']) && isset($userArray['email']) && isset($userArray['email_verified']) && isset($userArray['password_hash']) && isset($userArray['created_at']) && isset($userArray['fk_role_id']) && isset($userArray['banned']) && isset($userArray['number_reviews'])) {
                $user = new User(
                    $userArray['id'],
                    $userArray['user_name'],
                    $userArray['email'],
                    $userArray['email_verified'],
                    $userArray['password_hash'],
                    $userArray['created_at'],
                    $this->roleService->getRoleById($userArray['fk_role_id']),
                    $userArray['banned'],
                    $userArray['number_reviews']
                );
                
                if (isset($userArray['updated_at'])) {
                    $user->setUpdatedAt($userArray['updated_at']);
                }
                
                if (isset($userArray['last_login_at'])) {
                    $user->setLastLoginAt($userArray['last_login_at']);
                }
                
                return $user;
                
            } else {
                return false;
            }
        }
        
        /**
         * @param int $id
         * @return User
         */
        public function getUserById(int $id)
        {
            $userById = $this->userDAO->selectUserById($id);
            return $this->userObjectBinder($userById);
        }
        
        /**
        * getUserByMail
        * @param string $mail
        * @return User
        */
        public function getUserByMail(string $mail)
        {
            $userByEmail = $this->userDAO->selectUserByMail($mail);
            return $this->userObjectBinder($userByEmail);
        }
        
        /**
        * getUserByUserName
        * @param string $userName
        * @return User
        */
        public function getUserByUserName(string $userName)
        {
            $userByUserName = $this->userDAO->selectUserByUserName($userName);
            return $this->userObjectBinder($userByUserName);
        }
        
        
        
    }