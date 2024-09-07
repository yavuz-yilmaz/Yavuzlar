<?php
class Database
{
  private $pdo;

  public function __construct($file)
  {
    try {
      $this->pdo = new PDO("sqlite:" . $file);
      $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      die("" . $e->getMessage());
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
}

$db = new Database('db.sqlite');
?>