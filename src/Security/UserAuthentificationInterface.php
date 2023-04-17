<?php

namespace Otopix\Security;

/**
 * Le but d'une interface est de déclarer des règles à respecter
 * par les classes qui décident d'implémenter cette interface

 * Cela est souvent utilisée par les librairies pour orienter/forcer
 * le développeur dans la bonne direction
 */
interface UserAuthentificationInterface
{
    /**
     * @return string
     */
    public function getPassword(): string;

    /**
     * @return string|NULL
     */
    public function getSalt(): ?string;
}