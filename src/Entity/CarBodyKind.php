<?php

namespace App\Entity;

use App\Repository\CarBodyKindRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CarBodyKindRepository::class)
 * @ORM\Table (name="car_body_kinds")
 */
class CarBodyKind extends EntityKind
{
}
