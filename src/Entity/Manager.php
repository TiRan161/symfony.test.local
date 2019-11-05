<?php


namespace App\Entity;


use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Manager
{
    /** @var integer */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $surname;
    /** @var string */
    private $middleName;
    /**@var string*/
    private $email;
    /** @var string */
    private $photo;

    /**
     * @return string|null
     */
    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    /**
     * @param string $photo
     * @return Manager
     */
    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Manager
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }
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
    public function getName(): ?string
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
    public function getSurname(): ?string
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
     * @return string
     */
    public function getMiddleName(): ?string
    {
        return $this->middleName;
    }

    /**
     * @param string $middleName
     * @return Manager
     */
    public function setMiddleName(string $middleName): self
    {
        $this->middleName = $middleName;
        return $this;
    }

    /**
     * @return Branch
     */
    public function getBranch(): ?Branch
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