<?php

namespace App\Entity;

use App\Repository\RoadTrainKindRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RoadTrainKindRepository::class)
 * @ORM\Table(name="road_train_kinds")
 */
class RoadTrainKind extends EntityKind
{
}
