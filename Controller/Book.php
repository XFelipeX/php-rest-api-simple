<?php

require('../DAO/DAOBook.php');
require('../Model/Book.php');

$daoBook = new DAOBook();
$method = $_SERVER['REQUEST_METHOD'];
$body = file_get_contents('php://input');

if ($method === 'GET') {
  $response = $daoBook->Select();

  echo json_encode($response);
  return;
}

if ($method === 'POST') {
  $jsonBody = json_decode($body, true);

  if (
    !isset($jsonBody["name"]) || $jsonBody == null ||
    !isset($jsonBody["author"]) || $jsonBody == null
  ) {
    echo json_encode(array("error" => true, "message" => "name || author is broken"));
    http_response_code(400);
    return;
  }

  $book = new Book(
    null,
    $jsonBody["name"],
    $jsonBody["author"]
  );

  echo json_encode($daoBook->Insert($book));
  return;
}

echo json_encode(array("error" => true, "message" => "This method is not allowed"));
http_response_code(405);
