<?php

include 'database.classes.php';

class Book {
  private $title;
  private $author;
  private $publisher;
  private $date;

  public function __construct($title, $author, $publisher, $date) {
    $this->title = $title;
    $this->author = $author;
    $this->publisher = $publisher;
    $this->date = $date;
  }

  public function bookAdd() {
    $db = new DatabaseHandler();

    $stmt = $db->run('INSERT INTO books (title, author, publisher, date) VALUES (?,?,?,?)', [$this->title, $this->author, $this->publisher, $this->date]);
    return 0;
  }

  public function bookUpdate($id) {
    $db = new DatabaseHandler();

    $stmt = $db->run('UPDATE books SET title = ?, author = ?, publisher = ?, DATE = ? WHERE id = ?', [$this->title, $this->author, $this->publisher, $this->date, $id]);
    return 0;
  }

  public function bookDelete($id, $staff) {
    $db = new DatabaseHandler();

    if($staff) {
      $stmt = $db->run('DELETE FROM books where id = ? AND title = ?', [$id, $this->title]);
      return 0;
    } else {
      return -1;
    }
  }
}

class BookHandler {
  public function getAllBook($title = '', $author = '') {
    $db = new DatabaseHandler();
    $stmt = $db->run("SELECT * FROM books WHERE title LIKE ? AND author LIKE ?", [('%'.$title.'%'), ('%'.$author.'%')]);
    return $stmt->fetchAll();
  }

  public function getBook($bookId) {
    $db = new DatabaseHandler();
    $stmt = $db->run("SELECT * FROM books WHERE id = ?", [$bookId]);
    return $stmt->fetch();
  }
}