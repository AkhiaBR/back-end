<?php
$connect = mysql_connect('localhost','root','');
$db      = mysql_select_db('loja');
?>

<HTML>
<HEAD>
 <TITLE> Pagina Principal</TITLE>
</HEAD>
<body>
    <form name="formulario" method="post" action="pesquisar.php">
       <img src="logo.jpg" width=200 height=150 align="left">
       <a href="login.php"><img src="login.jpg" width=130 height=60 align="right"></a>
       <br><br>
       <h1>Material Esportivo</h1><br>
       <br><br>
       <h1>Pesquisas:</h1>
       
       <!------ pesquisar Categorias -------------->
        <label for="">Categorias: </label>
        <select name="categoria">
        <option value="" selected="selected">Selecione...</option>

        <?php
        $query = mysql_query("SELECT codigo, descricao FROM categoria");
        while($categorias = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $categorias['codigo']?>">
                       <?php echo $categorias['descricao']   ?></option>
        <?php }
        ?>
        </select>
        
        <!------ pesquisar tipo -------------->
        <label for="">Classifica��o: </label>
        <select name="tipo">
        <option value="" selected="selected">Selecione...</option>

        <?php
        $query = mysql_query("SELECT codigo, nome FROM tipo");
        while($tipo = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $tipo['codigo']?>">
                       <?php echo $tipo['nome']   ?></option>
        <?php }
        ?>
        </select>
        
       <!------ pesquisar marcas -------------->
       <label for="">Marcas: </label>
        <select name="marca">
        <option value="" selected="selected">Selecione...</option>

        <?php
        $query = mysql_query("SELECT codigo, nome FROM marca");
        while($marcas = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $marcas['codigo']?>">
                       <?php echo $marcas['nome']   ?></option>
        <?php }
        ?>
        </select>

        <input  type="submit" name="pesquisar" value="Pesquisar">
    </form>
<br><br>
<?php

if (isset($_POST['pesquisar']))
{
//verifica que a op��o marca e modelo foi selecionada ou n�o
$marca          = (empty($_POST['marca']))? 'null' : $_POST['marca'];
$categoria      = (empty($_POST['categoria']))? 'null' : $_POST['categoria'];
$tipo  = (empty($_POST['tipo']))? 'null' : $_POST['tipo'];

//---------- pesquisar  marca escolhida ----------------

if (($marca <> 'null') and ($categoria == 'null') and ($tipo == 'null'))
{
     $sql_produtos       = "SELECT produto.descricao,produto.cor,produto.tamanho,produto.preco,produto.foto_1,produto.foto_2
                            FROM produto, marca, categoria, tipo
                            WHERE produto.codigo_marca = marca.codigo
                            and produto.codigo_categoria = categoria.codigo
                            and produto.codigo_tipo = tipo.codigo
                            and marca.codigo = $marca ";
                            
     $seleciona_produtos = mysql_query($sql_produtos);
}

//---------- pesquisar categoria escolhida ----------------

//---------- pesquisar marca e categoria escolhida ----------------

//---------- pesquisar tipo escolhida ----------------

//---------- pesquisar marca e categoria e tipo escolhido ----------------

// colocar mais filtros ?????



//---------- mostrar as informa��es dos produtos  ----------------
if(mysql_num_rows($seleciona_produtos) == 0)
{
   echo '<h1>Desculpe, mas sua busca nao retornou resultados ... </h1>';
}
else
{
   echo "Resultado da pesquisa de Produtos: <br><br>";
    while ($dados = mysql_fetch_object($seleciona_produtos))
	{
      echo "Descri��o :".$dados->descricao." ";
      echo "  Cor       : ".$dados->cor." ";
      echo "  Tamanho   : ".$dados->tamanho." ";
      echo "  Pre�o R$  : ".$dados->preco."<br>";
      echo '<img src="fotos/'.$dados->foto_1.'" height="100" width="150" />'." ";
      echo '<img src="fotos/'.$dados->foto_2.'" height="100" width="150" />'."<br><br>";
	}
   }
}
?>
</body>

</HTML>
