<?php
class Database
{
  private $pdo;

  public function __construct()
  {
    $dsn = 'mysql:host=db;port=3306;dbname=yavuzlaryemek';
    $username = 'root';
    $password = 'admin';

    try {
      $this->pdo = new PDO($dsn, $username, $password);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("Connection failed: " . $e->getMessage());
    }
  }

  public function query($sql)
  {
    $this->pdo->query($sql);
  }

  public function prepare($sql)
  {
    return $this->pdo->prepare($sql);
  }

  public function exec($sql)
  {
    return $this->pdo->exec($sql);
  }

  public function escapeString($string)
  {
    return $this->pdo->quote($string);
  }
  public function lastInsertId($name = null)
  {
    return $this->pdo->lastInsertId($name);
  }
}

$db = new Database();
?>