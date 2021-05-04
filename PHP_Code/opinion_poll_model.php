<!-- This is Business Logic Layer that will handle the database connectivity.--> 

<?php
class Opinion_poll_model {

 private $db_handle; private $host = 'localhost'; private $db = 'opinion_poll';private $uid = 'root'; private $pwd = '';

// The "public function __construct()" is the class constructor method that is used to establish the database connection.

    public function __construct() {

        $this->db_handle = mysqli_connect($this->host, $this->uid, $this->pwd); //connect to MySQL server

        if (!$this->db_handle) die("Unable to connect to MySQL: " . mysqli_error());

        if (!mysqli_select_db($this->db_handle,$this->db)) die("Unable to select database: " . mysqli_error());

    }

// The "public function execute_query(…)” is the method for executing queries such as insert, update and delete

    private function execute_query($sql_stmt) {

        $result = mysqli_query($this->db_handle,$sql_stmt); //execute SQL statement

        return !$result ? FALSE : TRUE;

    }

// The "public function select” is the method for retrieving data from the database and returning a numeric array.

    public function select($sql_stmt) {

        $result = mysqli_query($this->db_handle,$sql_stmt);

        if (!$result) die("Database access failed: " . mysqli_error($this->db_handle));

        $rows = mysqli_num_rows($result);

        $data = array();

        if ($rows) {

            while ($row = mysqli_fetch_array($result)) {

                $data = $row;

            }

        }

        return $data;

    }

// The “public function insert(…)” is the insert method that calls the execute_query method.

    public function insert($sql_stmt) {

        return $this->execute_query($sql_stmt);

    }

// The "public function __destruct()” is the class destructor that closes the database connection.

    public function __destruct(){

        mysqli_close($this->db_handle);

    }

}

?>