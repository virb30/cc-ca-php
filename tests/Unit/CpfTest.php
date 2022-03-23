<?php declare(strict_types=1);

namespace Tests\Unit;

use App\Domain\Entity\Cpf;
use PHPUnit\Framework\TestCase;

class CpfTest extends TestCase
{
  /**
   * @dataProvider invalidCpfProvider
   */
  public function testShouldNotCreateInvalidCpf(string $cpf): void
  {
    $this->expectException(DomainException::class);
    new Cpf($cpf);
  }

  public function testShouldCreateCpf(): void
  {
    $cpf = new Cpf("935.411.347-80");

    $this->assertInstanceOf(Cpf::class, $cpf);
    $this->assertEquals("935.411.347-80", $cpf->getValue());
  }

  public function invalidCpfProvider(): array
  {
    return [
      "all digits equal" => ["111.111.111-11"],
      "invalid verifying digit" => ["123.456.789-99"],
      "empty cpf" => [""],
      "letters" => ["abc.def.ghi-jk"],
    ];
  }
}