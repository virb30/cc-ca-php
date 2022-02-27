<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Product;

interface ProductRepository
{
  public function getById(int $idItem): ?Product;
}