<?php

class Student {
    private $conn;
    private $table = "students";

    public $id;
    public $name;
    public $course;
    public $email;
    public $phone_contact;
    public $reg_number;

   
    public function __construct($db) {
        $this->conn = $db;
    }

    // CREATE (Insert student)
    public function create() {
        $sql = "INSERT INTO {$this->table} 
                (name, course, email, phone_contact, reg_number)
                VALUES (:name, :course, :email, :phone, :reg)";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name'  => $this->name,
            ':course'=> $this->course,
            ':email' => $this->email,
            ':phone' => $this->phone_contact,
            ':reg'   => $this->reg_number
        ]);
    }

    // READ ALL
    public function readAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY id DESC";
        return $this->conn->query($sql);
    }

    // READ ONE (by ID)
    public function readOne() {
        $sql = "SELECT * FROM {$this->table} WHERE id = :id LIMIT 1";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([':id' => $this->id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // UPDATE
    public function update() {
        $sql = "UPDATE {$this->table} SET
                    name = :name,
                    course = :course,
                    email = :email,
                    phone_contact = :phone,
                    reg_number = :reg
                WHERE id = :id";

        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([
            ':name'  => $this->name,
            ':course'=> $this->course,
            ':email' => $this->email,
            ':phone' => $this->phone_contact,
            ':reg'   => $this->reg_number,
            ':id'    => $this->id
        ]);
    }

    // DELETE
    public function delete() {
        $sql = "DELETE FROM {$this->table} WHERE id = :id";
        $stmt = $this->conn->prepare($sql);

        return $stmt->execute([':id' => $this->id]);
    }
}