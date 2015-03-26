<?php
class Client extends SQLObject
{
    var $nom;
    var $prenom;
    var $mail;
    var $code;
    var $adresses;        
    
    
    function __construct ()
    {
        parent::__construct("clients");
        $this->adresses = array();
    }
    
    function size ()
    {
        return parent::size() + 4;
    }
    
    function reset ()
    {
        $this->set(null, 0, "", "", "", "");
        $this->adresses = array();
    }
    
    function set ($session, $fid, $fnom, $fpre, $fmai, $fcode)
    {
        $this->id = intval($fid);
        $this->nom = $fnom;
        $this->prenom = $fprix;
        $this->mail = $fmai;
        $this->setCode($fcode);
        if ($this->id > 0 && $session != null) {
            $addr = new Adresse();
            $this->adresses = $addr->getAllForUser($session, $this->id);
        }
    }
    
    function setFromDB ($session, $row)
    {
        $this->set($session, $row[0], $row[1], $row[2], $row[3], $row[4]);
        
    }
    
    function setCode($str){
        $this->code = md5($str);
    }
    
    function save ($session)
    {
        $query = "";
        if ($this->id > 0)
            $query .= "UPDATE " . $this->table . " SET ";
        else
            $query .= "INSERT INTO " . $this->table . " SET ";
        
        $query .= createQueryString("nom", $this->nom);
        $query .= createQueryString("prenom", $this->prenom);
        $query .= createQueryString("mail", $this->mail);
        $query .= createQueryString("code", $this->code);
        
        $query = trim($query, ", ");
        
        if ($this->id > 0)
            $query .= " WHERE " . createQueryInt("id", $this->id);
        
        $query = trim($query, ", ");
        
        //echo "<br>" . $query;
        
        return mysqli_query($session, $query);
    }
}