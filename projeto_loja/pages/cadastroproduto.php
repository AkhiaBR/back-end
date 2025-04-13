<?php
// conectar com o servidor e banco
$conectar = mysql_connect('localhost','root','');
$banco    = mysql_select_db("loja");

if (isset($_POST['gravar'])) {
    $codigo = $_POST['codigo'];
    $descricao = $_POST['descricao'];
    $codigo_categoria = $_POST['codigo_categoria'];
    $codigo_tipo = $_POST['codigo_tipo'];
    $codigo_marca = $_POST['codigo_marca'];
    $cor = $_POST['cor'];
    $tamanho = $_POST['tamanho'];
    $preco = $_POST['preco'];
    $foto_1 = $_FILES['foto_1'];
    $foto_2 = $_FILES['foto_2'];

    // pasta onde será armazenada as imagens
    $diretorio = "../images/";

    // cadastro das fotos
    if ($foto_1['error'] === UPLOAD_ERR_OK) {
        $extensao1 = strtolower(substr($foto_1['name'], -4));
        $novo_nome1 = md5(uniqid() . $foto_1['name'] . $extensao1); // tem que ser uniqid para a foto2 não sobrepor a foto1
        move_uploaded_file($foto_1['tmp_name'], $diretorio . $novo_nome1);
    } else {
        echo "Erro ao fazer upload da foto 1.";
    }
    
    if ($foto_2['error'] === UPLOAD_ERR_OK) {
        $extensao2 = strtolower(substr($foto_2['name'], -4));
        $novo_nome2 = md5(uniqid() . $foto_2['name'] . $extensao2);
        move_uploaded_file($foto_2['tmp_name'], $diretorio . $novo_nome2);
    } else {
        echo "Erro ao fazer upload da foto 2.";
    }

    // insete os dados no banco de dados
    $sql = "INSERT INTO produto (codigo, descricao, cor, tamanho, preco, codigo_marca, codigo_categoria, codigo_tipo, foto_1, foto_2)
            VALUES ('$codigo', '$descricao', '$cor', '$tamanho', '$preco', '$codigo_marca', '$codigo_categoria', '$codigo_tipo', '$novo_nome1', '$novo_nome2')";
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
   $descricao         = $_POST['descricao'];
   $codigo_categoria      = $_POST['codigo_categoria'];
   $codigo_tipo  = $_POST['codigo_tipo'];
   $codigo_marca          = $_POST['codigo_marca'];
   $cor               = $_POST['cor'];
   $tamanho           = $_POST['tamanho'];
   $preco             = $_POST['preco'];
   $foto_1             = $_FILES['foto_1'];
   $foto_2             = $_FILES['foto_2'];

  $sql = "DELETE FROM produto WHERE codigo = '$codigo'";

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
   $descricao         = $_POST['descricao'];
   $codigo_categoria      = $_POST['codigo_categoria'];
   $codigo_tipo  = $_POST['codigo_tipo'];
   $codigo_marca          = $_POST['codigo_marca'];
   $cor               = $_POST['cor'];
   $tamanho           = $_POST['tamanho'];
   $preco             = $_POST['preco'];
   $foto_1             = $_FILES['foto_1'];
   $foto_2             = $_FILES['foto_2'];

  $sql = "UPDATE produto SET descricao='$descricao',preco='$preco'
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
   $sql = mysql_query("SELECT codigo, descricao, cor, tamanho, preco, codigo_marca, codigo_categoria, codigo_tipo, foto_1, foto_2 FROM produto");
   
   if (mysql_num_rows($sql) == 0)
         {echo "Desculpe, mas sua pesquisa não retornou resultados.";}
   else
        {
        echo "<b>Produtos Cadastrados:</b><br><br>";
        while ($resultado = mysql_fetch_object($sql))
 	        {
                echo "Codigo         : ".$resultado->codigo." ";
                echo "Descricao      : ".$resultado->descricao."<br>";
                echo "Cor            : ".$resultado->cor."<br>";
                echo "Tamanho        : ".$resultado->tamanho." ";
                echo "Preco          : ".$resultado->preco."<br>";
                echo "Marca          : ".$resultado->codigo_marca."";  
                echo "Categoria      : ".$resultado->codigo_categoria." ";
                echo "Tipo           : ".$resultado->codigo_tipo." ";
                echo '<img src="../images/'.$resultado->foto_1.'"height="200" width="200" />'."  ";
                echo '<img src="../images/'.$resultado->foto_2.'"height="200" width="200" />'."<br><br>  ";
            }
        }
}
?>