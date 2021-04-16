<?php

require('../Services/Connection.php');

class DAOBook
{
  function Select(): array
  {
    try {
      $connection = new Connection();
      $response = $connection->Select(
        "SELECT * FROM book",
        []
      );
      return $response;
    } catch (Exception $e) {
      return $e;
    }
  }

  function Insert($book)
  {
    try {
      $connection = new Connection();
      $response = $connection->Insert("INSERT INTO book (`name`,`author`) values (?,?)", [
        $book->getName(),
        $book->getAuthor()
      ]);

      return $response;
    } catch (Exception $e) {
      return $e;
    }
  }
}
