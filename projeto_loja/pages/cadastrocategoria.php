<?php
// conectar com o servidor e banco
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("loja");

if (isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $nome = $_POST['nome'];

    // Inserir dados no banco de dados
    $sql = "INSERT INTO categoria (codigo, nome)
            VALUES ('$codigo', '$nome')";
    $resultado = mysql_query($sql);

    if ($resultado) {
        echo "Dados informados cadastrados com sucesso.";
    } else {
        echo "Falha ao gravar os dados informados.";
    }
}

if (isset($_POST['excluir']))
{
    $codigo            = $_POST['codigo'];
    $nome         = $_POST['nome'];

    $sql = "DELETE FROM categoria WHERE codigo = '$codigo'";

    $resultado = mysql_query($sql);

    if ($resultado === TRUE)
    {
        echo 'Exclusao realizada com Sucesso';
    }
    else
    {
        echo 'Erro ao excluir dados.';
    }
}

if (isset($_POST['alterar']))
{
   $codigo            = $_POST['codigo'];
   $nome         = $_POST['nome'];

  $sql = "UPDATE categoria SET nome='$nome'
          WHERE codigo = '$codigo'";
  $resultado = mysql_query($sql);

  if ($resultado === TRUE)
  {
     echo 'Dados alterados com Sucesso';
  }
  else
  {
     echo 'Erro ao alterar dados.';
  }
}

if (isset($_POST['pesquisar']))
{
   $sql = mysql_query("SELECT codigo, nome FROM categoria");
   
   if (mysql_num_rows($sql) == 0)
         {echo "Desculpe, mas sua pesquisa não retornou resultados.";}
   else
        {
        echo "<b>Categorias Cadastradas:</b><br><br>";
        while ($resultado = mysql_fetch_object($sql))
 	        {
                echo "Codigo         : ".$resultado->codigo." ";
                echo "Nome      : ".$resultado->nome."<br>";
            }
        }
}
?>
