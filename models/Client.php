<?php

require_once "./config/Database.php";

class Client extends Database {
    private $conn;
    private $table = 'clients';

    public $id;
    public $cpf;
    public $rg;
    public $name;
    public $nickname;
    public $birth;
    public $gender;
    public $zipcode;
    public $state;
    public $city;
    public $neighborhood;
    public $address;
    public $number;
    public $complement;
    public $reference;
    public $phone;
    public $email;
    public $created_at;

    public function __construct() {
        $db = (new Database())->connect();
        $this->conn = $db;
    }


    public function create() {
        $query = "INSERT INTO " . $this->table . " SET
            cpf=:cpf, rg=:rg, name=:name, nickname=:nickname, birth=:birth, gender=:gender, zipcode=:zipcode, state=:state, city=:city,
            neighborhood=:neighborhood, address=:address, number=:number, complement=:complement, 
            reference=:reference, phone=:phone, email=:email;";

        $stmt = $this->conn->prepare($query);

        // Bind dos dados
        $stmt->bindParam(':cpf', $this->cpf);
        $stmt->bindParam(':rg', $this->rg);
        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':nickname', $this->nickname);
        $stmt->bindParam(':birth', $this->birth);
        $stmt->bindParam(':gender', $this->gender);
        $stmt->bindParam(':zipcode', $this->zipcode);
        $stmt->bindParam(':state', $this->state);
        $stmt->bindParam(':city', $this->city);
        $stmt->bindParam(':neighborhood', $this->neighborhood);
        $stmt->bindParam(':address', $this->address);
        $stmt->bindParam(':number', $this->number);
        $stmt->bindParam(':complement', $this->complement);
        $stmt->bindParam(':reference', $this->reference);
        $stmt->bindParam(':phone', $this->phone);
        $stmt->bindParam(':email', $this->email);
   
        if ($stmt->execute()) {
            return true;
        }

        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    public function read() {
        $query = "SELECT * FROM " . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function exists($cpf) {
        $query = "SELECT COUNT(*) as count FROM clients WHERE cpf = :cpf";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':cpf', $cpf);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['count'] > 0;
    }
    


}
