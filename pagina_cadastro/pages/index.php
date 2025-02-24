<?php
    $conectar = mysql_connect("localhost", "root", "");
    $conectar = mysql_select_db("escola");

    // verificar se a opcao de cada botao esta setada (is set)
    if (isset($_POST['enviar'])) {
        // adquire as variaves enviadas atraves do HTML
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $coordenador = $_POST['coordenador'];

        // comando sql do banco de dados
        $sql = "insert into escola.curso (codigo,nome,coordenador)
                values('$codigo','$nome','$coordenador');";

        // executar o comando sql
        $resultado = mysql_query($sql);

        // checa se o comando teve êxito
        if ($resultado==TRUE) {
            echo "Dados gravados com sucesso.";
        }
        else {
            echo "Erro ao gravar os dados.";
        }
    }
?>