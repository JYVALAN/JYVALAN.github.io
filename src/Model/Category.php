<?php
namespace Otopix\Model;

class Category
{
    /** @var int */
    private int $id;

    /** @var string */
    private string $name;

    /** @var Picture[] */
    

    public function __construct(string $sCat)
    {
        $this->name = $sCat;
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
     * @return Category
     */
    public function setId(int $id): Category
    {
        $this->id = $id;
        return $this;
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
     * @return Category
     */
    public function setName(string $name): Category
    {
        $this->name = $name;
        return $this;
    }

}

