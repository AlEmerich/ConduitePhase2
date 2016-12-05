<?php
include 'config.php' ;
class ConnectSingleton {
    
    private static $conn;
    private static $nbConnection = 0;

    private function __construc()
    {
	self::$nbConnection = 0;
    }
    
    public static function getInstance()
    {
	if(true === is_null(self::$conn))
	{
	    global $servername,$username,$dbname,$password;
	    self::$conn = new mysqli($servername,$username,$password,$dbname);
	}
	self::$nbConnection = self::$nbConnection + 1;
	return self::$conn;
    }

    public static function close()
    {
	if(self::$nbConnection == 1)
	    self::$conn->close();
	else
	    if(self::$nbConnection > 1)
		self::$nbConnection = self::$nbConnection - 1;
    }
}

?>
