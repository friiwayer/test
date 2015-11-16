<?
    require_once 'options.php';

/*connect to DB class*/
class Conn extends Opt
{   
    var $database;
    var $connected;
    
    protected function db_conn(){
        $this->connected = mysql_connect("localhost", $this->_user, $this->_pass);
        if(!$this->connected){
            die("Error ".mysql_error());
        }else{
           $this->database = mysql_select_db($this->_dbname);
           if(!$this->database){
            die("ERROR ".mysql_error());
           }
        }
    }

    public function sql($query){
        $this->db_conn();
        $mysql = mysql_query($query);
        if(!$mysql){
            die(" ".mysql_error());
        }else{
            return $mysql;
        }
    } 
}
?>
