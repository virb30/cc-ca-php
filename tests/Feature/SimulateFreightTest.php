<?php declare(strict_types=1);

namespace Tests\Feature;

use App\Application\UseCase\SimulateFreight\SimulateFreight;
use App\Application\UseCase\SimulateFreight\SimulateFreightInput;
use App\Domain\Factory\RepositoryFactory;
use App\Infra\Database\Connection;
use App\Infra\Database\PdoMysqlConnectionAdapter;
use App\Infra\Factory\MemoryRepositoryFactory;
use PHPUnit\Framework\TestCase;

class SimulateFreightTest extends TestCase
{
  private Connection $connection;
  private RepositoryFactory $repositoryFactory;

  protected function setUp(): void
  {
    // $this->connection = new PdoMysqlConnectionAdapter();
    $this->repositoryFactory = new MemoryRepositoryFactory();
  }

  public function testShouldSimulateFreight()
  {
    $simulateFreight = new SimulateFreight($this->repositoryFactory);
    $input = new SimulateFreightInput(
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
      ]
    );
    $output = $simulateFreight->execute($input);
    $this->assertEquals(260, $output->total);
  }

  public function testShouldTrhowsIfProductNotFound()
  {
    $simulateFreight = new SimulateFreight($this->repositoryFactory);
    $input = new SimulateFreightInput(
      orderItems: [
        (object) ['idItem' => 1, 'quantity' => 1],
        (object) ['idItem' => 2, 'quantity' => 1],
        (object) ['idItem' => 3, 'quantity' => 3],
        (object) ['idItem' => 4, 'quantity' => 3],
      ]
    );

    $this->expectException(Exception::class);
    $simulateFreight->execute($input);
  }
}