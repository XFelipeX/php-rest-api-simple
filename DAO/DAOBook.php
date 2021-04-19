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

  function Delete($book_id)
  {
    try {
      $connection = new Connection();
      $response = $connection->Delete("DELETE FROM book where id = (?)", [$book_id]);

      return $response;
    } catch (Exception $e) {
      return $e;
    }
  }

  function Update($book)
  {
    try {
      $connection = new Connection();
      $response = $connection->Update("UPDATE book SET `name` = (?) ,`author` = (?) where `id` = (?) ", [
        $book->getName(),
        $book->getAuthor(),
        $book->getId(),
      ]);

      return $response;
    } catch (Exception $e) {
      return $e;
    }
  }
}
