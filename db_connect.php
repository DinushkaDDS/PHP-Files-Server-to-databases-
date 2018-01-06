<?php
 
/**
 * A class file to connect to database
 */
class DB_CONNECT {
	 
	 /**
     * Function to connect with database
     */
    function connect($userName, $password, $database) {
        // import database connection variables
		
        // Connecting to mysql database
        $con = mysqli_connect("localhost", $userName, $password, $database);
        		
        // returing connection cursor
        return $con;
    }
 
    /**
     * Function to close db connection	
     */
    function close() {
        // closing db connection
        mysqli_close();
    }
    
    function getCon() {
        // closing db connection
        return $mycon;
    }
 
    // constructor
    function __construct() {
        // connecting to database
        //$this->connect();
    }
 
    // destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }
 
   
 
}
 
?>
