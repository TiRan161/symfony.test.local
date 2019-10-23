<?php


namespace App\Entity;


class Manager
{
    /** @var integer */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $surname;
    /** @var Branch */
    private $branch;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return Manager
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     * @return Manager
     */
    public function setSurname(string $surname): self
    {
        $this->surname = $surname;
        return $this;
    }

    /**
     * @return Branch
     */
    public function getBranch(): Branch
    {
        return $this->branch;
    }

    /**
     * @param Branch $branch
     * @return Manager
     */
    public function setBranch(Branch $branch): self
    {
        $this->branch = $branch;

        return $this;
    }




}