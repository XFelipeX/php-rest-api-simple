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
    !isset($jsonBody["name"]) || $jsonBody["name"] == null ||
    !isset($jsonBody["author"]) || $jsonBody["author"] == null
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

if ($method === "PUT") {
  $jsonBody = json_decode($body, true);

  if (
    !isset($jsonBody["name"]) || $jsonBody["name"] == null ||
    !isset($jsonBody["author"]) || $jsonBody["author"] == null ||
    !isset($jsonBody["id"]) || $jsonBody["id"] == null
  ) {
    echo json_encode(array("error" => true, "message" => "(name || author || id) is broken"));
    http_response_code(400);
    return;
  }

  $book = new Book(
    $jsonBody["id"],
    $jsonBody["name"],
    $jsonBody["author"]
  );

  echo json_encode($daoBook->Update($book));
  return;
}

if ($method === "DELETE") {
  $jsonBody = json_decode($body, true);

  if (!isset($jsonBody["id"]) || $jsonBody["id"] == null) {
    echo json_encode(array("error" => true, "message" => "id is broken"));
    http_response_code(400);
  }

  echo json_encode($daoBook->Delete($jsonBody["id"]));
  return;
}

echo json_encode(array("error" => true, "message" => "This method is not allowed"));
http_response_code(405);
