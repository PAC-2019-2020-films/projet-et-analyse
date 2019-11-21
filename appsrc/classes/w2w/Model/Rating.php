<?php
    /**
     * Created by PhpStorm.
     * User: Meh
     * Date: 14/11/2019
     * Time: 20:50
     */
    
    namespace Model;
    
    
    class Rating
    {
        private int $id;
        private string $name;
        private string $description;
        private string $value;

        /**
         * Rating constructor.
         * @param int $id
         * @param string $name
         * @param string $value
         */
        public function __construct(int $id, string $name, string $value)
        {
            $this->id = $id;
            $this->name = $name;
            $this->value = $value;
        }


        /**
         * @return int
         */
        public function getId(): int
        {
            return $this->id;
        }

        /**
         * @param int $id
         */
        public function setId(int $id): void
        {
            $this->id = $id;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }

        /**
         * @param string $name
         */
        public function setName(string $name): void
        {
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getDescription(): string
        {
            return $this->description;
        }

        /**
         * @param string $description
         */
        public function setDescription(string $description): void
        {
            $this->description = $description;
        }

        /**
         * @return string
         */
        public function getValue(): string
        {
            return $this->value;
        }

        /**
         * @param string $value
         */
        public function setValue(string $value): void
        {
            $this->value = $value;
        }
        
    }