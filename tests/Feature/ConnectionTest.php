<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Infra\Database\PdoMysqlConnectionAdapter;
use PHPUnit\Framework\TestCase;

class ConnectionTest extends TestCase
{
  public function testShouldConnectToDatabase()
  {
    $connection = new PdoMysqlConnectionAdapter();
    $items = $connection->query('select * from item', []);
    $this->assertCount(3, $items);
  }
}