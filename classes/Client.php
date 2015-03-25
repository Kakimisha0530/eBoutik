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
        $this->categorie = null;
    }
    function set ($session, $fid, $fnom, $fprix, $fimg, $fdesc, $fcat)
    {
        $this->id = intval($fid);
        $this->nom = $fnom;
        $this->prix = floatval($fprix);
        $this->image = $fimg;
        $this->description = $fdesc;
        $this->id_categorie = intval($fcat);
        if ($this->id_categorie > 0 && $session != null) {
            $this->categorie = new Categorie();
            $this->categorie->getById($session, $this->id_categorie);
        }
    }
    
    function setFromDB ($session, $row)
    {
        $this->set($session, $row[0], $row[1], $row[2], $row[3], $row[4], $row[5]);
        
    }
    
    
    function save ($session)
    {
        $query = "";
        if ($this->id > 0)
            $query .= "UPDATE " . $this->table . " SET ";
        else
            $query .= "INSERT INTO " . $this->table . " SET ";
        
        $query .= createQueryString("nom", $this->nom);
        $query .= createQueryString("description", $this->description);
        $query .= createQueryString("image", $this->image);
        $query .= createQueryInt("prix", $this->prix);
        $query .= createQueryInt("categorie", $this->id_categorie);
        
        $query = trim($query, ", ");
        
        if ($this->id > 0)
            $query .= " WHERE " . createQueryInt("id", $this->id);
        
        $query = trim($query, ", ");
        
        //echo "<br>" . $query;
        
        return mysqli_query($session, $query);
    }
}