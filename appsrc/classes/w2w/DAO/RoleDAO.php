<?php
    
    
    namespace DAO;
    
    
    use Model\Role;
    
    class RoleDAO extends BaseDAO
    {
        private string $table = "roles";
        
        /**
         * RoleDAO constructor.
         */
        public function __construct()
        {
            parent::__construct();
        }
        
        
        /**
         * @return bool|array
         */
        public function selectAllRoles()
        {
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                ORDER BY {$this->table}.name;
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
         * @param string $name
         * @return bool|array
         */
        public function selectRoleByName(string $name)
        {
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name, 
                        {$this->table}.description
                FROM {$this->table}
                WHERE {$this->table}.name = :name;
                ";
            
            
            $condition = [':name' => $name];
            
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
         * @param int $id
         * @return bool|array
         */
        public function selectRoleById(int $id)
        {
            $sql = "SELECT  {$this->table}.id,
                        {$this->table}.name, 
                        {$this->table}.description
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
         * @param Role $role
         * @return bool|int
         */
        public function insertRole(Role $role)
        {
            $data = [
                'name'        => $role->getName(),
                'description' => $role->getDescription()
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
         * @param Role $role
         * @return bool|int
         */
        public function updateRole(Role $role)
        {
            $data = [
                'name'        => $role->getName(),
                'description' => $role->getDescription()
            ];
            
            $condition = "{$this->table}.id = {$role->getId()}";
            
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
         * @param Role $role
         * @return bool|int
         */
        public function deleteRole(Role $role)
        {
            $condition = "{$this->table}.id = {$role->getId()}";
            
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