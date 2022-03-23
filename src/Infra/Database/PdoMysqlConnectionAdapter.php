<?php declare(strict_types=1);

namespace App\Infra\Database;

use PDO;

class PdoMysqlConnectionAdapter implements Connection
{
  private PDO|null $conn;

  public function __construct()
  {
    $username = 'php';
    $password = '123456';
    $this->conn = new PDO("mysql:host=db;dbname=app", $username, $password);
    $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function query(string $statement, array $params = []): array
  {
    $stmt = $this->conn->prepare($statement);
    $stmt->execute($params);
    return $stmt->fetchAll();
  }

  public function lastInsertedId(): int|string
  {
    return $this->conn->lastInsertId();
  }

  public function close(): void
  {
    $this->conn = null;
  }
}