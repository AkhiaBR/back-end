<?php
    $conectar = mysql_connect("localhost", "root", "");
    $conectar = mysql_select_db("escola");

    // verificar se a opcao de cada botao esta setada (is set)
    if (isset($_POST['Login'])) {
        // adquire as variaves enviadas atraves do HTML
        $login = $_POST['login'];
        $senha = $_POST['senha'];

        $sql = "select * from escola.usuario where login = '$login' and senha = '$senha'";

        $resultado = mysql_query($sql);
        
        if (mysql_num_rows($resultado)<=0) {
            echo "<script language='javascript' type='text/javascript'>
                    alert('Login e/ou senha incorretos');
                    window.location.href='pagina_login.html';
                  </script>";
        }
        else {
            setcookie('login',$login);
            header('Location:pagina_menu.html');
        }
    }
?>