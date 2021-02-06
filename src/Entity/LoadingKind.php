<?php

namespace App\Entity;

use App\Repository\LoadingKindRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=LoadingKindRepository::class)
 * @ORM\Table (name="`loading_kinds`")
 */
class LoadingKind extends EntityKind
{
}
