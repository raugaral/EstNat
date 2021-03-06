<?php
session_start();
require_once '../Logica/Connexio.php';
require_once '../Logica/Usuaris.php';
require_once '../Logica/SolicitudAmistat.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
        <script type="text/javascript">
	$(document).ready(function() {   
            $("#form").bind("submit", function() { 
                $.fancybox.showActivity(); 
                $.ajax({ 
                        type    : "POST", 
                        cache   : false, 
                        url     : "login.php", 
                        data    : $(this).serializeArray(), 
                        success: function(data) { 
                                $.fancybox(data); 
                        } 
                }); 
                return false; 
            });         
	});
</script>
    </head>
    <body>
        <?php
        if($_POST){
         
        $Connexio = new Connexio();
        $Connexio->connectar();
        $Connexio->selectdb("socialtravel");

        $usuari = new Usuaris();
        
            if(@$usuari->autentificarUsuari($_POST[usuario],$_POST[password])){
                @$_SESSION[usuario] = $_POST[usuario];
                $result = $usuari->getUsuariByName(@$_SESSION[usuario]);
                @$_SESSION[idUsuario] = mysql_result($result, 0,0);
                $notificacions = new SolicitudAmistat();
                $result = $notificacions->getSolicitutByUser($_SESSION[idUsuario]);
                
                echo "<p><b>Bienvenido ".@$_POST[usuario]." !</b></p>";
                echo "<p><b>Tienes ".mysql_num_rows($result)." notificaciones!</b></p>";
                echo "<meta http-equiv='Refresh' content='1;url=index.php'>";

            }else {
                echo "<img src='../Vista/img/error.png' align='center'/>";
                echo "<p class='error'>Usuario/Password incorrectos</p>";
            }
        }else {
             
    ?>
        <form id="form" method="POST" style="text-align: right">
        Usuario: <input type="text" name="usuario"/>        <br />
        Password:<input type="password" name="password" />  <br />
        <input type="submit" name="login" value="Enviar"/>
        </form>
    <?php } ?>
    </body>
</html>
