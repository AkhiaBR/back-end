<?php
    $conectar = mysql_connect("localhost", "root", "");
    $conectar = mysql_select_db("escola");

    // verificar se a opcao de cada botao esta setada (is set)
    if (isset($_POST['Enviar'])) {
        // adquire as variaves enviadas atraves do HTML
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $coordenador = $_POST['coordenador'];
        $codcoord = $_POST['codcoord'];

        // comando sql do banco de dados
        $sql = "insert into escola.curso (codigo, nome, codcoord, coordenador)
                values('$codigo','$nome','$codcoord','$coordenador');";

        // executar o comando sql
        $resultado = mysql_query($sql);

        // checa se o comando teve êxito
        if ($resultado==TRUE) {
            echo "Dados gravados com sucesso.";
        }
        else {
            echo "ERRO: SQL query não executado.";
        }
    }

    if (isset($_POST['Alterar'])) {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $coordenador = $_POST['coordenador'];
        $codcoord = $_POST['codcoord'];

        $sql = "update escola.curso set nome, codcoord, coordenador = '$nome','$codcoord','$coordenador'
                where codigo = '$codigo'";

        $resultado = mysql_query($sql);

        if ($resultado==TRUE) {
            echo "Dados alterados com sucesso.";
        }
        else {
            echo "ERRO: SQL query não executado.";
        }
    }

    if (isset($_POST['Excluir'])) {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $coordenador = $_POST['coordenador'];
        $codcoord = $_POST['codcoord'];

        $sql = "delete from escola.curso
        where codigo = '$codigo'";

        $resultado = mysql_query($sql);

        if ($resultado==TRUE) {
            echo "Dados excluídos com sucesso.";
        }
        else {
            echo "ERRO: SQL query não executado.";
        }
    }

    if (isset($_POST['Pesquisar'])) {
        $sql = "select * from escola.curso";

        $resultado = mysql_query($sql);
        
        if (mysql_num_rows($resultado)==0) {
            echo "Dados não encontrados...";
        }
        else {
            echo"<b>"."Pesquisa por Curso: "."</b><br><br>"; 
            
            while($dados = mysql_fetch_array($resultado)) { 
                echo "Codigo: ".$dados['codigo']."<br>".
                     "Nome: ".$dados['nome']."<br><br>".
                     "Codigo Coordenador: ".$dados['codcoord']."<br><br>".
                     "Nome Coordenador: ".$dados['coordenador'."<br><br>"];
            }
        }
    }
?>