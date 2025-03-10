<?php
    $conectar = mysql_connect("localhost", "root", "");
    $conectar = mysql_select_db("escola");

    // verificar se a opcao de cada botao esta setada (is set)
    if (isset($_POST['Enviar'])) {
        // adquire as variaves enviadas atraves do HTML
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $fone = $_POST['fone'];
        $codcurso = $_POST['codcurso'];

        // comando sql do banco de dados
        $sql = "insert into escola.aluno (codigo, nome, fone, codcurso)
                values('$codigo','$nome','$fone','$codcurso');";

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
        $fone = $_POST['fone'];
        $codcurso = $_POST['codcurso'];
    
        $sql = "UPDATE escola.aluno SET nome = '$nome', codcurso = '$codcurso', fone = '$fone' WHERE codigo = '$codigo'";
    
        $resultado = mysql_query($sql);
    
        if ($resultado) {
            echo "Dados alterados com sucesso.";
        } else {
            echo "ERRO: SQL query não executado.";
        }
    }
    

    if (isset($_POST['Excluir'])) {
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];
        $fone = $_POST['fone'];
        $codcurso = $_POST['codcurso'];

        $sql = "delete from escola.aluno
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
        $sql = "select * from escola.aluno";

        $resultado = mysql_query($sql);
        
        if (mysql_num_rows($resultado)==0) {
            echo "Dados não encontrados...";
        }
        else {
            echo"<b>"."Pesquisa por Curso: "."</b><br><br>"; 
            
            while($dados = mysql_fetch_array($resultado)) { 
                echo "Codigo: ".$dados['codigo']."<br>".
                     "Nome: ".$dados['nome']."<br><br>".
                     "Fone: ".$dados['fone']."<br><br>".
                     "Codigo Curso: ".$dados['codcurso']."<br><br>";
            }
        }
    }
?>