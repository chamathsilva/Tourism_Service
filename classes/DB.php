<?php
require("myLog.php");
class DB{
    private static $_instance = null;
    private $pdo,
        $_query,
        $settings,
        $log,
        $parameters;


    private function __construct(){
        $this->log = new Log();
        $this->Connect();
        $this->parameters = array();
    }

    private function Connect()
    {
        $this->settings = parse_ini_file("settings.ini.php");
        $dsn = 'mysql:dbname='.$this->settings["dbname"].';host='.$this->settings["host"].'';
        try
        {
            # Read settings from INI file, set UTF8
            $this->pdo = new PDO($dsn, $this->settings["user"], $this->settings["password"], array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            //$this->_pdo = new PDO('mysql:host=' . config::get('mysql/host').';dbname=' . config::get('mysql/db'),config::get('mysql/user_name'),config::get('mysql/password'));
            # We can now log any exceptions on Fatal error.
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            # Disable emulation of prepared statements, use REAL prepared statements instead.
            $this->pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        }
        catch (PDOException $e) {
            # Write into log
            echo $this->ExceptionLog($e->getMessage());
            die();
        }
    }

    public static function getInstance(){
        if (!isset(self::$_instance)) {
            self::$_instance = new DB();
        }
        return self::$_instance;
    }

    //close the PDO connection
    public function CloseConnection()
    {
        $this->pdo = null;
    }

    private function Init($query,$parameters = ""){
        //get database instance.
        $this->getInstance();
        try {
            # Prepare query
            $this->_query = $this->pdo->prepare($query);

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
            $this->succes 	= $this->_query->execute();
        }
        catch(PDOException $e)
        {
            # Write into log and display Exception
            echo $this->ExceptionLog($e->getMessage(), $query );
            die();
        }

        # Reset the parameters
        $this->parameters = array();
    }

    //Add the parameter to the parameter array
    public function bind($para, $value)
    {
        $this->parameters[sizeof($this->parameters)] = ":" . $para . "\x7F" . utf8_encode($value);
    }

    //Add more parameters to the parameter array
    public function bindMore($parray)
    {
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

    public function query($query,$params = null, $fetchmode = PDO::FETCH_ASSOC)
    {
        $query = trim($query);

        $this->Init($query,$params);

        $rawStatement = explode(" ", $query);

        # Which SQL statement is used
        $statement = strtolower($rawStatement[0]);

        if ($statement === 'select' || $statement === 'show') {
            return $this->_query->fetchAll($fetchmode);
        }
        elseif ( $statement === 'insert' ||  $statement === 'update' || $statement === 'delete' ) {
            return $this->_query->rowCount();
        }
        else {
            return NULL;
        }
    }

    //Returns the last inserted id
    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    private function ExceptionLog($message , $sql = "")
    {
        $exception  = 'Unhandled Exception. <br />';
        $exception .= $message;
        $exception .= "<br /> You can find the error back in the log.";

        if(!empty($sql)) {
            # Add the Raw SQL to the Log
            $message .= "\r\nRaw SQL : "  . $sql;
        }
        # Write into log
        $this->log->write($message);

        return $exception;
    }
}
?>
