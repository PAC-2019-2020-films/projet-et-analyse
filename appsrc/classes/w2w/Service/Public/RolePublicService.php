<?php
    
    
    namespace Service;
    
    
    use Model\Role;
    
    class RolePublicService extends PublicService
    {
        
        
        /**
         * RolePublicService constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        /**
         * roleObjectBinder
         * Binds a PDO::fetchAll result row to a new Category Object
         * @param array $roleArray
         * @return bool|Role
         */
        public function roleObjectBinder(array $roleArray)
        {
            if (isset($roleArray['id']) && isset($roleArray['name'])) {
                $role = new Role(
                    $roleArray['id'],
                    $roleArray['name']
                );
                
                if (isset($roleArray['description'])) {
                    $role->setDescription($roleArray['description']);
                }
                
                return $role;
            } else {
                return false;
            }
        }
        
        /**
         * getAllRoles
         * @return Role[]
         */
        public function getAllRoles()
        {
            $allRolesArray = $this->roleDAO->selectAllRoles();
            $allRoles      = [];
            
            foreach ($allRolesArray as $role) {
                $rol = $this->roleObjectBinder($role);
                array_push($allRoles, $rol);
            }
            return $allRoles;
        }
        
        /**
        * getRoleByName
        * @param string $name
        * @return Role
        */
        public function getRoleByName(string $name)
        {
            $roleByName = $this->roleDAO->selectRoleByName($name);
            return $this->roleObjectBinder($roleByName);
        }
        
        /**
         * @param int $id
         * @return Role
         */
        public function getRoleById(int $id)
        {
            $roleById = $this->roleDAO->selectRoleById($id);
            return $this->roleObjectBinder($roleById);
        }
        
        
    }