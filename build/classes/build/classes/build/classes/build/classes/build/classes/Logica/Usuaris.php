<?php

class Usuaris {
    
    public function getUsuaris(){
        $sql = "SELECT * FROM usuaris";
        $result = mysql_query($sql);
        return $result;
    }
    public function getUsuariByName($usuari){ // Suposem que la ID es el camp Usuari (Nickname)
        $sql = "SELECT * FROM usuaris WHERE usuari = '".$usuari."'";
        $result = mysql_query($sql);
        return $result;
    }    
    public function getUsuariByCerca($usuari,$id){ 
        //$sql = "SELECT * FROM usuaris WHERE id <> ".$id." AND admin = 0 AND ";
        $sql = "SELECT * FROM usuaris u WHERE u.id <> ".$id." AND u.admin = 0 AND 
                (usuari LIKE '%".$usuari."%' OR nom LIKE '%".$usuari."%' OR cognom LIKE '%".$usuari."%')
                AND u.id NOT IN ( SELECT usuari_envia  FROM solicitud_amistat WHERE usuari_rep = ".$id." AND aceptada = 1)
                AND u.id NOT IN ( SELECT usuari_rep FROM solicitud_amistat WHERE usuari_envia = ".$id." AND aceptada = 1)";
       // echo $sql;
        $result = mysql_query($sql);
        return $result;
    }
    public function getUsuariByID($id){ // Suposem que la ID es el camp Usuari (Nickname)
        $sql = "SELECT * FROM usuaris WHERE id = '".$id."'";
        $result = mysql_query($sql);
        return $result;
    }    
    public function setUsuari($nom, $cognom, $dni, $usuari, $pass){
        $sql = "INSERT INTO usuaris (nom, cognom, dni, usuari, password)".
                "VALUES('".$nom."', '".$cognom."', '".$dni."', '".$usuari."', md5('".$pass."') )";
        mysql_query($sql);
    }
    
    public function validaUsuari($dni){
        $sql = "SELECT * FROM usuaris WHERE dni = '".$dni."'";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 0) return false;
        return true;
    }
    public function autentificarUsuari($nom,$password){
        
        $sql = "SELECT * FROM usuaris WHERE usuari = '".$nom."' AND password = md5('".$password."')";
        $result = mysql_query($sql);
        if(mysql_num_rows($result) == 0) return false;
        return true;
    }
    public function updateUsuari($nom, $cognom, $dni, $usuari, $pass){
        
        $sql = "UPDATE usuaris SET nom = '".$nom."', cognom = '".$cognom."', dni = '".$dni."', usuari = '".$usuari."', password = md5('".$pass."') ".
               "WHERE usuari = '".$usuari."'";
        mysql_query($sql);
    }
}

?>
