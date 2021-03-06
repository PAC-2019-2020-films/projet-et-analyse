<?php


namespace Model;


class Artist
{
    private int $id;
    private string $firstName;
    private string $lastName;

    /**
     * Artist constructor.
     * @param int $id
     * @param string $lastName
     */
    public function __construct(int $id, string $lastName)
    {
        $this->id = $id;
        $this->lastName = $lastName;
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
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     *
    */
    public function serialize()
    {

    }


}