<?php

namespace Otopix\Model;

/**
 * Le but d'un trait est de regrouper un "concept".
 * Ici le concept d'objet persistant dans le temps
 * avec une notion de date de création et de date de modification
 */
trait Timestampable
{
    use Creatable, Updatable;
}