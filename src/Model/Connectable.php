<?php

namespace Otopix\Model;

/**
 * Le but d'un trait est de regrouper un "concept".
 * Ici le concept d'objet persistant dans le temps
 * avec une notion de date de création et de date de modification
 */
trait Connectable
{
    /** @var \DateTime */
    private \DateTime $connectedAt;

    /**
     * @return \DateTime
     */
    public function getConnectedAt(): \DateTime
    {
        return $this->connectedAt;
    }

    /**
     * @param \DateTime $connectedAt
     * @return self
     */
    public function setConnectedAt(\DateTime $connectedAt): self
    {
        $this->connectedAt = $connectedAt;
        return $this;
    }

}