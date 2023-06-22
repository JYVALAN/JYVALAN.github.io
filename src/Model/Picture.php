<?php
namespace Otopix\Model;

class Picture
{
    /** Le mot "use" permet d'utiliser le trait Timestampable */
    use Timestampable;

    /** @var int */
    private ?int $id = null;

    /** @var string */
    private string $title;

    /** @var string */
    private string $description;

    /** @var string|null */
    private ?string $picture;

    /** @var Category */
    private Category $category;

    /** @var User */
    private User $user;

    /** @var int */
    private int $nbDownloads = 0;    


    /**
     * @param string $sTitle
     * @param string $sDescription
     * @param Category $oCat
     * @param string $sPicture
     * @param User $oUse
     */
    public function __construct(string $sTitle, string $sDescription, Category $oCat, string $sPicture, User $oUse)
    {
        $this->title = $sTitle;
        $this->description = $sDescription;
        $this->category = $oCat;
        $this->picture = $sPicture;
        $this->user = $oUse;

        $this->createdAt = new \DateTime();
    }


    

    /**
     * Get the value of title
     *
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * Set the value of title
     *
     * @param string $title
     *
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of description
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set the value of description
     *
     * @param string $description
     *
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the value of category
     *
     * @return Category
     */
    public function getCategory(): Category
    {
        return $this->category;
    }

    /**
     * Set the value of category
     *
     * @param Category $category
     *
     * @return self
     */
    public function setCategory(Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get the value of picture
     *
     * @return ?string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param ?string $picture
     *
     * @return self
     */
    public function setPicture(?string $picture): self
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get the value of user
     *
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * Set the value of user
     *
     * @param User $user
     *
     * @return self
     */
    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get the value of nbDownloads
     *
     * @return int
     */
    public function getNbDownloads(): int
    {
        return $this->nbDownloads;
    }

    /**
     * Set the value of nbDownloads
     *
     * @param int $nbDownloads
     *
     * @return self
     */
    public function setNbDownloads(int $nbDownloads): self
    {
        $this->nbDownloads = $nbDownloads;

        return $this;
    }

    /**
     * Get the value of id
     *
     * @return ?int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @param ?int $id
     *
     * @return self
     */
    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
    }
}
