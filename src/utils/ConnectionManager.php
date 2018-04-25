<?php
/*
  Module                      : Database Connection in PDO
  Description                 : To establish database connection and other operation
 */

class ConnectionManager {

    private $dbtype = DBTYPE; 
    private $host = HOST;
    private $user = USER;
    private $pass = PASSWORD;
    private $dbname= DATABASE;
    private $dbh = NULL;
    public static $msConnection;
    private $stmt;
    static private $PDOInstance; 
    
    public function __construct() {
        // Set DSN
        $dsn = $this->dbtype.':host=' . $this->host . ';dbname=' . $this->dbname;
        // Set options
        $options = array(
            PDO::ATTR_PERSISTENT    => FALSE,
            PDO::ATTR_ERRMODE       => PDO::ERRMODE_EXCEPTION
          //  PDO::ATTR_EMULATE_PREPARES => FALSE //for Limit
        );

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            self::$msConnection =$this->dbh;
            // Set time zone for the connection session
            $now = new DateTime();
            $mins = $now->getOffset() / 60;
            $sgn = ($mins < 0 ? -1 : 1);
            $mins = abs($mins);
            $hrs = floor($mins / 60);
            $mins -= $hrs * 60;
            $offset = sprintf('%+d:%02d', $hrs * $sgn, $mins);
//            print_r('offset1-'.$offset);
            $this->dbh->exec("SET time_zone='$offset';");
//            
//            $offset2 = $this->dbh->exec("SELECT @@global.time_zone, @@session.time_zone;");
//print_r('offset2-'.$offset2);
            
//                $offset  = TIMEZONE;
//                        $this->dbh->exec("SET GLOBAL time_zone = 'UTC';");

            /* change character set to utf8 */
            $this->dbh->exec("set names utf8");    
        } catch (PDOException  $e) {
             print "Error!: " . $e->getMessage() . "<br/>";
             die();
        }
    }

    public function query($query){
        $this->stmt = $this->dbh->prepare($query);
    }
    
    public function bind($param,$value, $type= null){   
        if(is_null($type)){
         switch (true){
           case is_int($value):
             $type = PDO::PARAM_INT;
             break;
           case is_bool($value):
             $type = PDO::PARAM_BOOL;
             break;
           case is_null($value):
            $type = PDO::PARAM_NULL;
            break;
          default : $type = PDO::PARAM_STR;  
        }
      }
      $this->stmt->bindValue($param, $value, $type);
    }
    
    public function execute(){
        return $this->stmt->execute();
    }
     public function executeParam($params){
        return $this->stmt->execute($params);
    }
    public function executeWaitTime($waitTimeout){
          return $this->stmt->execute("SET @@session.wait_timeout = {$waitTimeout}");
    }
    public function resultSet() {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function single(){
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
	
    public function singleParam($params){
        $this->stmt->execute($params);
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function rowCount(){
       return $this->stmt->rowCount();
    }
    
    public function lastInsertId(){
        return $this->dbh->lastInsertId();
    }
    
    public function beginTransaction(){
        return $this->dbh->beginTransaction();
    }
    
    public function autoCommit(){
        return $this->stmt->setAttribute(PDO::ATTR_AUTOCOMMIT);
    }
    
    /**
    * Commits a transaction
    * @return bool
    */
    public function commit() {
        return $this->dbh->commit();
    }
    
    public function cancelTransaction(){
        return $this->dbh->rollBack();
    }
    
    public function debugDumpParams(){
        return $this->stmt->debugDumpParams();
    }
   
}
?>
