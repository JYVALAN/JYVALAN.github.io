<?php

use Otopix\Model\User;
use Otopix\Repository\UserRepository;

/**
 * @param string $sEmail
 * @param string $sSubject
 * @param string $sContent
 *
 * @return bool
 */
function sendMail(string $sEmail, string $sSubject, string $sContent): bool
{
  echo 'Envoi d\'un mail' . '<br />';
  echo 'Destinataire : '. $sEmail . '<br />';
  echo 'Sujet : '. $sSubject . '<br />';
  echo 'Contenu : '. $sContent . '<br />';

  return true;
}
