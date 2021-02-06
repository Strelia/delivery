<?php

namespace App\Entity;

use App\Repository\AdrRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity(repositoryClass=AdrRepository::class)
 */
class Adr extends EntityKind
{
}
