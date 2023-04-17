<?php

namespace Otopix\Model;

/**
 * Le but d'un trait est de regrouper un "concept".
 * Ici le concept d'objet persistant dans le temps
 * avec une notion de date de création et de date de modification
 */
trait Updatable
{
    /** @var \DateTime */
    private \DateTime $updatedAt;

    /**
     * @return \DateTime
     */
    public function getUpdatedAt(): \DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param \DateTime $updatedAt
     * @return self
     */
    public function setUpdatedAt(\DateTime $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}