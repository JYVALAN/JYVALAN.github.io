<?php
namespace Otopix\Model;

class Likes
{
    use Timestampable;


    /** @var int */
    private ?int $id=null;

    /** @var Picture */
    private Picture $picture;

    /** @var User */
    private User $user;  

    /** @var int */
    private int $userId;  

    /** @var int */
    private int $pictureId;  

    /**
     * @param Picture $oPic
     * @param User $oUse
     */
    public function __construct()
    {
        // $this->picture = $oPic;
        // $this->user = $oUse;

        $this->createdAt = new \DateTime();
    }



    /**
     * Get the value of picture
     *
     * @return Picture
     */
    public function getPicture(): Picture
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     *
     * @param Picture $picture
     *
     * @return self
     */
    public function setPicture(Picture $picture): self
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
     * Get the value of userId
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set the value of userId
     *
     * @param int $userId
     *
     * @return self
     */
    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get the value of pictureId
     *
     * @return int
     */
    public function getPictureId(): int
    {
        return $this->pictureId;
    }

    /**
     * Set the value of pictureId
     *
     * @param int $pictureId
     *
     * @return self
     */
    public function setPictureId(int $pictureId): self
    {
        $this->pictureId = $pictureId;

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