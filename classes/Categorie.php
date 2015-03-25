<?php
class Categorie extends SQLObject
{
    var $nom;
    var $image;
    var $description;
    
    
    function __construct ()
    {
        parent::__construct("categories");
    }
    
    function size ()
    {
        return parent::size() + 3;
    }
    
    function reset ()
    {
        $this->set(null, 0, "", "", "");
        $this->categorie = null;
    }
    function set ($session, $fid, $fnom, $fimg, $fdesc)
    {
        $this->id = intval($fid);
        $this->nom = $fnom;
        $this->image = $fimg;
        $this->description = $fdesc;
    }
    
    function setFromDB ($session, $row)
    {
        $this->set($session, $row[0], $row[1], $row[2], $row[3]);
        
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
        
        $query = trim($query, ", ");
        
        if ($this->id > 0)
            $query .= " WHERE " . createQueryInt("id", $this->id);
        
        $query = trim($query, ", ");
        
        //echo "<br>" . $query;
        
        return mysqli_query($session, $query);
    }
}