<?php
namespace Otopix\Model;

use Otopix\Security\UserAuthentificationInterface;

/**
 * implements permet de forcer la classe User à respecter les contrats indiqués (interfaces)
 */
class User implements UserAuthentificationInterface
{
    /** Le mot "use" permet d'utiliser le trait Timestampable */
    use Timestampable, Connectable;

    /** @var int */
    const ROLE_USER = 1;
    /** @var int */
    const ROLE_ADMIN = 2;

    /** @var array */
    const ROLE_CONF = [
        self::ROLE_USER => [
            'label' => 'Utilisateur',
        ],
        self::ROLE_ADMIN => [
            'label' => 'Administrateur',
        ],
    ];

    /** @var int */
    private int $id = 0;

    /** @var string */
    private string $lastname;

    /** @var string */
    private string $firstname;

    /** @var string */
    private string $email;

    /** @var string */
    private string $password;

    /** @var string */
    private ?string $user_picture = null;

    /** @var string */
    private ?string $bio = null;

    /** @var int */
    private int $role;

    /** @var array */
    private array $pictures = [];

    /**
     * @param string $sLastname
     * @param string $sFirstname
     * @param string $sEmail
     * @param string $sPassword
     * @param string $sUser_picture
     * @param string $sBio
     */
    public function __construct(string $sLastname, string $sFirstname, string $sEmail, string $sPassword)
    {
        $this->lastname = $sLastname;
        $this->firstname = $sFirstname;
        $this->email = $sEmail;
        $this->password = $sPassword;

        // $this->user_picture = $sUser_picture;
        // $this->bio = $sBio;
        $this->role = self::ROLE_USER;
        $this->createdAt = new \DateTime();
        $this->connectedAt = new \DateTime();
    }

    /**
     * Permet de personnaliser la fonctionnalité "clone" (native de PHP)
     */
    public function __clone()
    {
        // Si on clone l'objet User, on ne veut pas que le mot de passe soit conservé
        $this->password = '';
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return NULL;
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
     * @return User
     */
    public function setId(int $id): User
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     * @return User
     */
    public function setLastname(string $lastname): User
    {
        $this->lastname = $lastname;
        return $this;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     * @return User
     */
    public function setFirstname(string $firstname): User
    {
        $this->firstname = $firstname;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): User
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): User
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return int
     */
    public function getRole(): int
    {
        return $this->role;
    }

    /**
     * @param int $role
     * @return User
     */
    public function setRole(int $role): User
    {
        $this->role = $role;
        return $this;
    }


    /**
     * Get the value of bio
     *
     * @return ?string
     */
    public function getBio(): ?string
    {
        return $this->bio;
    }

    /**
     * Set the value of bio
     *
     * @param ?string $bio
     *
     * @return self
     */
    public function setBio(?string $bio): self
    {
        $this->bio = $bio;

        return $this;
    }

    /**
     * Get the value of user_picture
     *
     * @return ?string
     */
    public function getUserPicture(): ?string
    {
        return $this->user_picture;
    }

    /**
     * Set the value of user_picture
     *
     * @param ?string $user_picture
     *
     * @return self
     */
    public function setUserPicture(?string $user_picture): self
    {
        $this->user_picture = $user_picture;

        return $this;
    }
}
