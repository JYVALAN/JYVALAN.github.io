<?php

namespace Otopix\Model;

/**
 * Le but d'un trait est de regrouper un "concept".
 * Ici le concept d'objet persistant dans le temps
 * avec une notion de date de création et de date de modification
 */
trait Creatable
{
    /** @var \DateTime */
    private \DateTime $createdAt;

    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTime $createdAt
     * @return self
     */
    public function setCreatedAt(\DateTime $createdAt): self
    {
        $this->createdAt = $createdAt;
        return $this;
    }

}