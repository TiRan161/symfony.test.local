<?php


namespace App\Entity;


use Doctrine\Common\Collections\ArrayCollection;

class Branch
{
    /** @var integer */
    private $id;
    /** @var string */
    private $name;
    /** @var ArrayCollection */
    private $managers;

    public function __construct()
    {
        $this->managers = new ArrayCollection();
    }

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
     * @return Branch
     */
    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getManagers(): ArrayCollection
    {
        return $this->managers;
    }

    /**
     * @param ArrayCollection $managers
     * @return Branch
     */
    public function setManagers(ArrayCollection $managers): self
    {
        $this->managers = $managers;

        return $this;
    }

    /**
     * @param Manager $manager
     * @return Branch
     */
    public function addManager(Manager $manager): self
    {
        /** @var ArrayCollection $managers */
        $managers = $this->managers;
        if (!$managers->contains($manager)) {
            $managers->add($manager);
        }
        return $this;
    }

    /**
     * @param Manager $manager
     * @return Branch
     */
    public function removeManager(Manager $manager): self
    {
        /** @var ArrayCollection $managers */
        $managers = $this->managers;
        if ($managers->contains($manager)) {
            $managers->removeElement($manager);
        }
        return $this;
    }


}