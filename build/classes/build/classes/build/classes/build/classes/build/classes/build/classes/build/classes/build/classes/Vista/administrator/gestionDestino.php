<!DOCTYPE html>
<?php
    session_start();
    require_once '../../Logica/Connexio.php';
    require_once '../../Logica/Desti.php';
    require_once '../../Logica/Estat.php';
    
    $con = new Connexio();
    
    if(!$_SESSION[usuari]){
        header("Location: index.php");
    }
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        
        <script type="text/javascript">
            $(document).ready(function() {
                $(".iframes").fancybox({
                    maxWidth	: 800,
                    maxHeight	: 600,
                    fitToView	: false,
                    width		: '70%',
                    height		: '70%',
                    autoSize	: false,
                    closeClick	: false,
                    openEffect	: 'none',
                    closeEffect	: 'none',
                    onClosed: function() { window.location.href = "administrador.php"; }
                });
                $('a.idEliminar').click(function(){
                    var txt=$(this).attr("rel");
                    $("#contenedorAdmin").load("gestionDestino.php?idEliminar="+txt); 
                });
            });
        </script>
        
        <style type="text/css">
            table.hovertable {
                    font-family: verdana,arial,sans-serif;
                    font-size:11px;
                    color:#333333;
                    border-width: 1px;
                    border-color: #999999;
                    border-collapse: collapse;
                    margin-left: 30%;
            }
            table.hovertable th {
                    background-color:#c3dde0;
                    border-width: 1px;
                    padding: 8px;
                    border-style: solid;
                    border-color: #a9c6c9;
            }
            table.hovertable tr {
                    background-color:#d4e3e5;
            }
            table.hovertable td {
                    border-width: 1px;
                    padding: 8px;
                    border-style: solid;
                    border-color: #a9c6c9;
                    text-align: center;
            }
        </style>
    </head>
    <body>
        <div id="contenedor">
        <?php 
            $desti = new Desti();
            $estat = new Estat();
            
            if($_GET['idEliminar']){
                if($desti->delDesti($_GET['idEliminar'])){
                    echo "<h2>Destino eliminado!</h2>";
                }
                else{
                    echo "<h2>Error! Destino no eliminado!</h2>";
                }
            }
        ?>
        <form id="form" method="POST">
            <table class="hovertable">
                <tr>
                    <td><b>Nombre</b></td>
                    <td><b>Ubicación</b></td>
                    <td><b>Estado</b></td>
                    <td><b>Editar</b></td>
                    <td><b>Eliminar</b></td>
                </tr>
                <?php
                for($i = 0; $i < $desti->getNumDestins(); $i++){
                    echo "<tr onmouseover=\"this.style.backgroundColor='#ffff66';\" onmouseout=\"this.style.backgroundColor='#d4e3e5';\">";
                        echo "<td>".$desti->getNomDesti($i)."</td>";
                        echo "<td>".$desti->getUbicacio($i)."</td>";
                        echo "<td>".$estat->getTipusEstatByID($desti->getEstat($i))."</td>";
                        echo "<td> <a href='modificarDestino.php?id=$i' class='iframes fancybox.iframe'> <img src='../img/edit.png' height=15px /> </a> </td>";
                        echo "<td> <a class='idEliminar' href='#' rel='".$desti->getIdDesti($i)."' OnClick=\"return confirm('Seguro que quieres eliminar?');\"> <img src='../img/drop.png' /> </a> </td>";
                    echo "</tr>";
                }
                ?>
            </table>
        </form>
        <a href='anadirDestino.php' class="iframes fancybox.iframe"> <img src='../img/add.png' height=25px /> </a>
        </div>
    </body>
</html>

