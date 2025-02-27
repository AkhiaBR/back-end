<?php
    $conectar = mysql_connect("localhost", "root", "");
    $conectar = mysql_select_db("escola");

    // verificar se a opcao de cada botao esta setada (is set)
    if (isset($_POST['Enviar'])) {
        // adquire as variaves enviadas atraves do HTML
        $codigo = $_POST['codigo'];
        $nome = $_POST['nome'];

        // comando sql do banco de dados
        $sql = "insert into escola.coordenador (codigo, nome)
                values('$codigo','$nome');";

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

        $sql = "update escola.coordenador set nome = '$nome'
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

        $sql = "delete from escola.coordenador
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
        $sql = "select * from escola.coordenador";

        $resultado = mysql_query($sql);
        
        if (mysql_num_rows($resultado)==0) { // se o resultado do select * for igual a 0 linhas, o 'resultado' = 0, logo, não há campos cadastrados
            echo "Dados não encontrados...";
        }
        else {
            echo"<b>"."Pesquisa por Coordenador: "."</b><br><br>"; // concatenar = '.' // 
            
            while($dados = mysql_fetch_array($resultado)) { // fetch array pega uma linha da tabela, o arumento em parenteses mostra o numero de linhas puxadas
                echo "Codigo: ".$dados['codigo']."<br>".
                     "Nome: ".$dados['nome']."<br><br>";
            }
        }
    }
?>