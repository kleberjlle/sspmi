<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            $manutencao = true;
            if($manutencao){
                echo 'em breve teremos um sistema aqui';
            }else{
                header("Location: ./App/telas/acesso/tAcessar.php");
            }
        ?>
    </body>
</html>
