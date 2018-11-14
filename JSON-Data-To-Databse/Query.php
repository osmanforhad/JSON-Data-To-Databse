<?php

require_once ('./config.php');

class Query {

    private $conn;

    function __construct() {
        $database = new Database();
        $db = $database->dbConnection();
        $this->conn = $db;
    }
   public function runQuery($sql)
	{
		$stmt = $this->conn->prepare($sql);
		return $stmt;
	}
    	public function lasdID()
	{
		$stmt = $this->conn->lastInsertId();
		return $stmt;
	}

    public function ShowData($table) {
        $sql = "SELECT * FROM $table";
        $result = $this->conn->query($sql) or die("failed!");
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            $data[] = $row;
        }
        return$data;
    }
   
    public function InsertData($f_name,$l_name,$section)
	{
		try
		{	
			$stmt = $this->conn->prepare("INSERT INTO students(f_name,l_name,section) 
			                                             VALUES(:f_name, :l_name,:section)");
			$stmt->bindparam(":f_name",$f_name);
			$stmt->bindparam(":l_name",$l_name);
			$stmt->bindparam(":section",$section);
			$stmt->execute();	
			return $stmt;
		}
		catch(PDOException $ex)
		{
			echo $ex->getMessage();
		}
	}

}

?>
