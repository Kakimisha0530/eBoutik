<?php
class Adresse extends SQLObject
{
    var $nom;
    var $libelle;
    var $cp;
    var $ville;
    var $type;
    var $client;

    function __construct( )
    {
        parent::__construct( "adresses" );
    }

    function size( )
    {
        return parent::size( ) + 6;
    }

    function reset( )
    {
        $this -> set( null , 0 , "" , "" , 0 , "" , 0 , 0 );
        $this -> categorie = null;
    }

    function set( $session , $fid , $fnom , $flib , $fcp , $fvi , $fty , $fcl )
    {
        $this -> id = intval( $fid );
        $this -> nom = $fnom;
        $this -> libelle = $flib;
        $this -> cp = intval( $fcp );
        $this -> ville = $fvi;
        $this -> type = intval( $fty );
        $this -> client = intval( $fcl );

    }

    function setFromDB( $session , $row )
    {
        $this -> set( $session , $row[0] , $row[1] , $row[2] , $row[3] , $row[4] , $row[5] , $row[6] );

    }

    function save( $session )
    {
        $query = "";
        if ($this -> id > 0 )
            $query .= "UPDATE " . $this -> table . " SET ";
        else
            $query .= "INSERT INTO " . $this -> table . " SET ";

        $query .= createQueryString( "nom" , $this -> nom );
        $query .= createQueryString( "libelle" , $this -> libelle );
        $query .= createQueryString( "ville" , $this -> ville );
        $query .= createQueryInt( "cp" , $this -> cp );
        $query .= createQueryInt( "type" , $this -> type );
        $query .= createQueryInt( "client" , $this -> client );

        $query = trim( $query , ", " );

        if ($this -> id > 0 )
            $query .= " WHERE " . createQueryInt( "id" , $this -> id );

        $query = trim( $query , ", " );

        //echo "<br>" . $query;

        return mysqli_query( $session , $query );
    }

    function getAllForUser( $session , $cl )
    {
        $liste = array( );
        $query = "SELECT * FROM " . $this -> table . " WHERE ";
        $query .= createQueryInt( "client" , $cl );
        $query = trim( $query , ", " );
        $result = mysqli_query( $session , $query );
        while ( $row = mysqli_fetch_array( $result ) )
        {
            $addr = new Adresse( );
            $addr->setFromDB($session, $row);
            array_push($liste,$addr);
        }
        mysqli_free_result( $result );
        return $liste;
    }

}
?>