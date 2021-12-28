<?php

include 'database.classes.php';

class User {
  private $name;
  private $username;
  private $email;
  private $password;
  private $staff;

  public function __construct($name, $username, $email, $password, $staff) {
    $this->name = $name;
    $this->username = $username;
    $this->email = $email;
    $this->password = password_hash($password, PASSWORD_DEFAULT);
    $this->staff = $staff;
  }

  public function userSignup($repeat_password, $staff) {
    $db = new DatabaseHandler();

    if(!$this->staff) {
      $stmt = $db->run('SELECT 1 FROM users WHERE username = ? OR email = ?', [$this->username, $this->email])->fetch();
    } else {
      $stmt = $db->run('SELECT 1 FROM staffs WHERE username = ? OR email = ?', [$this->username, $this->email])->fetch();
    }

    if(empty($stmt)) {
      if(password_verify($repeat_password, $this->password)) {
        if(!$staff) {
          session_start();

          $stmt = $db->run('INSERT INTO users (name, username, email, password) VALUES (?,?,?,?)', [$this->name, $this->username, $this->email, $this->password]);
          $_SESSION['userId'] = $db->pdo->lastInsertId();
          return 0;
        } else {
          if(!$this->staff) {
            $stmt = $db->run('INSERT INTO users (name, username, email, password) VALUES (?,?,?,?)', [$this->name, $this->username, $this->email, $this->password]);
            return 0;
          } else {
            $stmt = $db->run('INSERT INTO staffs (name, username, email, password) VALUES (?,?,?,?)', [$this->name, $this->username, $this->email, $this->password]);
            return 0;
          }
        }
      } else {
        // password doesn't match
        return 2;
      }
    } else {
      // user exist
      return 1;
    }
  }

  public function userLogin($password, $staff) {
    $db = new DatabaseHandler();

    if(!$this->staff) {
      $stmt = $db->run('SELECT id, password FROM users WHERE username = ? OR email = ?', [$this->username, $this->email])->fetch();
    } else {
      $stmt = $db->run('SELECT id, password FROM staffs WHERE username = ? OR email = ?', [$this->username, $this->email])->fetch();
    }

    if(!empty($stmt)) {
      if(password_verify($password, $stmt['password'])) {
        session_start();

        if(!$staff) {
          $_SESSION['userId'] = $stmt['id'];
        } else {
          $_SESSION['staffId'] = $stmt['id'];
        }

        return 0;
      } else {
        // wrong password
        return 2;
      }
    } else {
      // user doesn't exist
      return 1; 
    }
  }

  
  public function userUpdate($id, $staff) {
    $db = new DatabaseHandler();

    if(!$staff) {
      $stmt = $db->run('UPDATE users SET name = ? WHERE id = ?', [$this->name, $id]);
      return 0;
    } else {
      if(!$this->staff) {
        $stmt = $db->run('UPDATE users SET name = ? WHERE id = ?', [$this->name, $id]);
        return 0;
      } else {
        $stmt = $db->run('UPDATE staffs SET name = ? WHERE id = ?', [$this->name, $id]);
        return 0;
      }
    }
  }

  public function userDelete($id, $staff) {
    $db = new DatabaseHandler();

    if($staff) {
      if(!$this->staff) {
        $stmt = $db->run('DELETE FROM users WHERE id = ? AND username = ? AND email = ?', [$id, $this->username, $this->email]);
        return 0;
      } else {
        $stmt = $db->run('DELETE FROM staffs WHERE id = ? AND username = ? AND email = ?', [$id, $this->username, $this->email]);
        return 0;
      }
    } else {
      return -1;
    }
  }
}

class UserHandler {
  public function getAllUser($staff) {
    $db = new DatabaseHandler();

    if(!$staff) {
      $stmt = $db->run('SELECT id, name FROM users');
      return $stmt->fetchAll();
    } else {
      $stmt = $db->run('SELECT id, name FROM staffs');
      return $stmt->fetchAll();
    }
  }

  public function getUser($id, $staff) {
    $db = new DatabaseHandler();

    if(!$staff) {
      $stmt = $db->run("SELECT id, name, username, email, date FROM users WHERE id = ?", [$id]);
      return $stmt->fetch();
    } else {
      $stmt = $db->run("SELECT id, name, username, email, date FROM staffs WHERE id = ?", [$id]);
      return $stmt->fetch();
    }
  }
}