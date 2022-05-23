<?php 

  class Post {
    // DB stuff
    private $conn;
    private $table = 'akun';

    // Post Properties
    public $id_akun;
    public $email;
    public $no_telp;
    public $password;


    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Posts
    public function read() {
      // Create query
      $query = 'SELECT * FROM ' . $this->table;
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single Post
    public function read_single() {
      // Create query
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id_akun = ?';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Bind ID
      $stmt->bindParam(1, $this->id);

      // Execute query
      $stmt->execute();

      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      // Set properties
      $this->id_akun = $row['id_akun'];
      $this->email = $row['email'];
      $this->no_telp = $row['no_telp'];
      $this->password = $row['password'];
    }

    public function create(){
      // Create query
      $query = 'INSERT INTO ' . $this->table . ' SET id_akun = :id_akun, email = :email, no_telp = :no_telp, password = :password';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id_akun = htmlspecialchars(strip_tags($this->id_akun));
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
      $this->password = htmlspecialchars(strip_tags($this->password));

      // Bind data
      $stmt->bindParam(':id_akun', $this->id_akun);
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':no_telp', $this->no_telp);
      $stmt->bindParam(':password', $this->password);

      // Execute query
      if($stmt->execute()) {
        return true;
      }
      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }
    
    public function update(){
      // Create query
      $query = 'UPDATE ' . $this->table . '
      SET email = :email, no_telp = :no_telp, password = :password
      WHERE id_akun = :id_akun';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->email = htmlspecialchars(strip_tags($this->email));
      $this->no_telp = htmlspecialchars(strip_tags($this->no_telp));
      $this->password = htmlspecialchars(strip_tags($this->password));
      $this->id_akun = htmlspecialchars(strip_tags($this->id_akun));

      // Bind data
      $stmt->bindParam(':email', $this->email);
      $stmt->bindParam(':no_telp', $this->no_telp);
      $stmt->bindParam(':password', $this->password);
      $stmt->bindParam(':id_akun', $this->id_akun);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    public function delete(){
      // Create query
      $query = 'DELETE FROM ' . $this->table . ' WHERE id_akun = :id_akun';

      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Clean data
      $this->id_akun = htmlspecialchars(strip_tags($this->id_akun));

      // Bind data
      $stmt->bindParam(':id_akun', $this->id_akun);

      // Execute query
      if($stmt->execute()) {
        return true;
      }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

  }
