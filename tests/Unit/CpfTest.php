<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use App\Cpf;

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