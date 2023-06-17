<?php
    class Model{
        private $host = "localhost";
        private $user = "root";
        private $password = "";
        private $db = "db_panduevakuasi"; 
        private $link = NULL;
        private $database = NULL;
        
        public function __construct(){
            try{
                $this->database = new PDO("mysql:host=".$this->getHost().";dbname=".$this->getDb(),$this->getUser(),$this->getPassword());  
                $this->database->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$data = $this->database->query("SET time_zone = '+8:00';"); 
            }catch(PDOException $ex){
                echo "Terjadi kesalahan koneksi/akses database";
                die();
            }
        }
        
        public function getHost(){
            return $this->host;
        }
        public function getUser(){
            return $this->user;
        }
        public function getPassword(){
            return $this->password;
        }
        public function getDb(){
            return $this->db;
        } 
		
        public function getQuery($q){
            try{
		$data = $this->database->query($q);
		return $data;
            }catch(PDOException $ex){
                echo "Terjadi kesalahan koneksi/akses database";
                die();
            }
        }
        
        public function getQuote($var){
            try{
		$tmp = $this->database->quote($var);
		return $tmp;
            }catch(PDOException $ex){
		echo "Terjadi kesalahan koneksi/akses database.";
		die();
            }
        }
        
        public function getListQuery($query, $arrField){
            try{
		$data = $this->database->query($query);
		$data_ = array();
		$r=0;
		while ($row = $data->fetch()){
                    for ($i=0;$i<count($arrField);$i++){
			$data_[$r][$arrField[$i]] = str_replace("'","\'",$row[$i]);
                    }
                    $data_[$r] = (object) $data_[$r];
                    $r++;
		}
                return $data_;
            }catch(PDOException $ex){
		echo "Terjadi kesalahan koneksi/akses database.".$query;
		die();
            }
        }
        public function getListQueryArray($query, $arrField){
            try{
		$data = $this->database->query($query);
		$data_ = array();
		$r=0;
		while ($row = $data->fetch()){
                    for ($i=0;$i<count($arrField);$i++){
			$data_[$r][$arrField[$i]] = $row[$i];
                    }
                    $r++;
		}
                return $data_;
            }catch(PDOException $ex){
		echo "Terjadi kesalahan koneksi/akses database.";
		die();
            }
        }
        
        public function getExeQuery($q){
            try{
		$exec = $this->database->exec($q);
		if ($exec < 0) return false; else return true;
            }catch(PDOException $ex){
                return FALSE;
                die();
            }
        }
        
        public function setStartTransaction(){
            try{
		$this->database->beginTransaction();
            }catch(PDOException $ex){
                echo $ex;
		die();
            }
        }
        
        public function setCommit(){
            try{
		$this->database->commit();
            }catch(PDOException $ex){
		die();
            }
        }
        
        public function setRollBack(){
            try{
                $this->database->rollBack();
            }catch(PDOException $ex){
		die();
            }
        }
        
        public function setClose(){
            try{
                $this->database = null;
            }catch(PDOException $ex){
		die();
            }
        }
    }    
?>