<?php

namespace Otopix\Manager;

use Otopix\Model\User;
use Otopix\Repository\UserRepository;
use Otopix\Service\EmailService;

class UserManager
{
    private $emailSrv;

    public function __construct(EmailService $oEmailService)
    {
        $this->emailSrv = $oEmailService;
    }

    /**
     * @param string $password
     * @return string
     */
    public function hashUserPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User|null
     */
    public function authUser(string $email, string $password): ?User
    {
        $oUser = UserRepository::findByEmail($email);
        if ($oUser instanceof User && password_verify($password, $oUser->getPassword())) {
            return $oUser;
        }
        return NULL;
    }

    public function registration()
    {
        // TODO : Envoyer un mail à l'utilisateur
        $this->emailSrv->sendRegistrationEmail();
    }
}
