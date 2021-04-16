<?php

class Book
{
  function __construct($id, $name, $author)
  {
    $this->id = (int)$id;
    $this->name = $name;
    $this->author = $author;
  }

  public function getId()
  {
    return (int)$this->id;
  }

  public function setId($id)
  {
    $this->id = $id;
  }

  public function getName()
  {
    return $this->name;
  }
  public function getAuthor()
  {
    return $this->author;
  }
}
