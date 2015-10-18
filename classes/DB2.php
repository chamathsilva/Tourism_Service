<?php

require("myLog.php");

class DB2{
    private static $_instance = null;
    private $_pdo,
            $_query,
            $_log,
            $_parameters;

    private function ____construct(){
        $this -> _log = new Log();
        $this -> connect();
        $this ->_parameters = array();
    }

    private function connect(){
        try{
            $this->_pdo = new PDO('mysql:host=' . config::get('mysql/host').';dbname=' . config::get('mysql/db'),config::get('mysql/user_name'),config::get('mysql/password'));
            # We can now log any exceptions on Fatal error.
            $this->_pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->_pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        }catch(PDOException $e){
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }

    }

    public static function getInstance(){
        if (!isset(self::$_instance)) {
            self::$_instance = new DB2();
        }
        return self::$_instance;
    }

    private function init($query, $parameters = ""){
        //get database instance.
        $this->getInstance();
        try{
            $this ->_query = $this ->_pdo -> prepare($query);

            # Add parameters to the parameter array
            $this->bindMore($parameters);

            # Bind parameters
            if(!empty($this->parameters)) {
                foreach($this->parameters as $param)
                {
                    $parameters = explode("\x7F",$param);
                    $this->_query->bindParam($parameters[0],$parameters[1]);
                }
            }
            # Execute SQL
            $this->succes = $this->_query->execute();

        }catch (PDOException $e){
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query );
            die();
        }
        # Reset the parameters
        $this->parameters = array();
    }

    //Add the parameter to the parameter array
    public function bind($para, $value){
        $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
    }

    //Add more parameters to the parameter array
    public function bindMore($parray){
        if(empty($this->parameters) && is_array($parray)) {
            $columns = array_keys($parray);
            foreach($columns as $i => &$column)	{
                $this->bind($column, $parray[$column]);
            }
        }
    }

    /**
     * If the SQL query  contains a SELECT or SHOW statement it returns an array containing all of the result set row.
     * If the SQL statement is a DELETE, INSERT, or UPDATE statement it returns the number of affected rows.
     */

    public function query($query, $params = null, $fetchmode = PDO::FETCH_ASSOC){
        //Removes all white spaces from the beginning and ending of the string.
        $query = trim($query);
        // Split a string by string(" ") and return array of strings.
        $rawStatement = explode(" ", $query);

        # Which SQL statement is used
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this-> _query -> fetchAll($fetchmode);
        }
        elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return $this-> _query -> rowCount();
        }
        else {
            return NULL;
        }
    }

    //Returns the last inserted id
    public function lastInsertId() {
        return $this-> _pdo-> lastInsertId();
    }

    private function ExceptionLog($message , $sql = ""){
        $exception  = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if(!empty($sql)){
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : "  . $sql;
        }
        # Write into log
        $this->log->write($message);

        return $exception;
    }

}