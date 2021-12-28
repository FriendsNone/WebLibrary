<?php

include 'database.classes.php';

class Record {
  private $record_id;
  private $patron_id;
  private $book_id;
  private $hold_date;
  private $borrow_date;
  private $due_date;
  private $return_date;
  private $status;

  public function __construct($record_id, $patron_id, $book_id) {
    $this->record_id = $record_id;
    $this->patron_id = $patron_id;
    $this->book_id = $book_id;
  }

  public function placeHold($staff) {
    $db = new DatabaseHandler();

    $stmt = $db->run('SELECT 1 FROM records WHERE users = ? AND books = ? AND status = "hold" OR status = "borrowed"', [$this->patron_id, $this->book_id])->fetch();

    if(empty($stmt)) {
      $stmt = $db->run('INSERT INTO records (users, books, hold_date, status) VALUES (?,?,?,?)', [$this->patron_id, $this->book_id, date_format(new DateTime('now'), 'Y-m-d H:i:s'), 'hold']);
      return 0;
    } else {
      return 4;
    }
  }

  public function markBorrowed($staff) {
    $db = new DatabaseHandler();

    if($staff) {
      $stmt = $db->run('UPDATE records SET status = "borrowed", borrow_date = ?, due_date = ? WHERE id = ?', [date_format(new DateTime('now'), 'Y-m-d H:i:s'), date_format(date_add(new DateTime('now'), new DateInterval('P7D')), 'Y-m-d H:i:s'), $this->record_id]);
      return 0;
    } else {
      return -1;
    }
  }

  public function markReturned($staff) {
    $db = new DatabaseHandler();

    if($staff) {
      $stmt = $db->run('UPDATE records SET status = "returned", return_date = ? WHERE id = ?', [date_format(new DateTime('now'), 'Y-m-d H:i:s'), $this->record_id]);
      return 0;
    } else {
      return -1;
    }
  }

  public function markCanceled($staff) {
    $db = new DatabaseHandler();

    if(!$staff) {
      $stmt = $db->run('SELECT id FROM records WHERE users = ? AND books = ? AND STATUS = "hold"', [$this->patron_id, $this->book_id])->fetch();

      if(!empty($stmt)) {
        $stmt = $db->run('UPDATE records SET status = "canceled", return_date = ? WHERE id = ?', [date_format(new DateTime('now'), 'Y-m-d H:i:s'), $stmt['id']]);
        return 0;
      } else {
        return 5;
      }
    } else {
      $stmt = $db->run('UPDATE records SET status = "canceled", return_date = ? WHERE id = ?', [date_format(new DateTime('now'), 'Y-m-d H:i:s'), $this->record_id]);
      return 0;
    }
  }
}

class RecordHandler {
  public function getAllRecord() {
    $db = new DatabaseHandler();

    $stmt = $db->run('SELECT r.id, u.name, b.title, r.status FROM records r LEFT JOIN users u on r.users = u.id LEFT JOIN books b ON r.books = b.id ORDER BY r.id DESC');
    return $stmt->fetchAll();
  }

  public function getRecord($recordId) {
    $db = new DatabaseHandler();

    $stmt = $db->run('SELECT r.id, u.id AS user_id, u.name AS user_name, b.id AS book_id, b.title AS book_title, r.hold_date, r.borrow_date, r.due_date, r.return_date, r.status FROM records r LEFT JOIN users u on r.users = u.id LEFT JOIN books b ON r.books = b.id WHERE r.id = ?', [$recordId]);
    return $stmt->fetch();
  }
}