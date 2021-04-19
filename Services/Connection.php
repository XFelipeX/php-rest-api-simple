<?php

class Connection
{
  private static $dbtype = "mysql";
  private static $host = "localhost";
  private static $port = "3308";
  private static $user = "root";
  private static $password = "";
  private static $db = "testapiphp";
  private $connection = null;

  public function __construct()
  {
  }

  public function __destruct()
  {
    $this->disconnect();
    foreach ($this as $key => $value) {
      unset($this->key);
    }
  }

  public function connect()
  {
    if ($this->connection !== null) {
      return $this->connection;
    }
    try {
      $this->connection = new PDO(
        $this->getDBType() . ":host=" .
          $this->getHost() . ";port=" .
          $this->getPort() . ";dbname=" .
          $this->getDB(),
        $this->getUser(),
        $this->getPassword()
      );
    } catch (PDOException $e) {
      die("Erro: <code>" . $e->getMessage() . "</code>");
    }
    return ($this->connection);
  }

  public function Select($sql, $params)
  {
    $query = $this->connect()->prepare($sql);
    $response = null;

    try {
      if (!$query->execute($params)) {
        $error = $query->errorInfo();
        return array("error" => true, "message" => "Select failure (" . $error[2] . ")");
      }
      $response = $query->fetchAll(PDO::FETCH_OBJ);

      if ($query->rowCount() > 0) {
        return array("error" => false, "data" => $response);
      } else {
        return array("error" => true, "message" => "No data");
      }
    } catch (PDOException $e) {
      $error = $query->errorInfo();
      return array("error" => true, "message" => "Select failure (" . $error[2] . ")");
    } finally {
      $this->__destruct();
    }
  }

  public function Insert($sql, $params)
  {
    $query = $this->connect()->prepare($sql);
    $response = null;

    try {
      $response = $query->execute($params);

      if (!$response) {
        $error = $query->errorInfo();
        return array("error" => true, "message" => "Insert failure (" . $error[2] . ")");
      }

      $lastId = $this->connect()->lastInsertId();

      return array("error" => false, "message" => "Add data success", "last_id" => $lastId);
    } catch (PDOException $e) {
      $error = $query->errorInfo();
      return array("error" => true, "message" => "Insert failure (" . $error[2] . ")");
    } finally {
      $this->__destruct();
    }

    return $response;
  }

  public function Update($sql, $params)
  {
    $query = $this->connect()->prepare($sql);

    try {
      if ($query->execute($params)) {
        if ($query->rowCount() >= 1) {
          return array("error" => false, "message" => "Update data success");
        }
        return array("error" => true, "message" => "No data to update");
      }
      $error = $query->errorInfo();
      return array("error" => true, "message" => "Update failure (" . $error[2] . ")");
    } catch (PDOException $e) {
      $error = $query->errorInfo();
      return array("error" => true, "message" => "Update failure (" . $error[2] . ")");
    } finally {
      $this->__destruct();
    }
  }

  public function Delete($sql, $params)
  {
    $query = $this->connect()->prepare($sql);

    try {
      if ($query->execute($params)) {
        if ($query->rowCount() >= 1) {
          return array("error" => false, "message" => "Delete success");
        }
        return array("error" => true, "message" => "No data to delete");
      } else {
        $error = $query->errorInfo();
        return array("error" => true, "message" => "Delete failure (" . $error[2] . ")");
      }
    } catch (PDOException $e) {
      $error = $query->errorInfo();
      return array("error" => true, "message" => "Delete failure (" . $error[2] . ")");
    } finally {
      $this->__destruct();
    }
  }

  public function disconnect()
  {
    $this->connection = null;
  }

  private function getDBType()
  {
    return self::$dbtype;
  }
  private function getHost()
  {
    return self::$host;
  }
  private function getPort()
  {
    return self::$port;
  }
  private function getUser()
  {
    return self::$user;
  }
  private function getPassword()
  {
    return self::$password;
  }
  private function getDB()
  {
    return self::$db;
  }
}
