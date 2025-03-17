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
        
        <!------ pesquisar Classificacao -------------->
        <label for="">Classificação: </label>
        <select name="classificacao">
        <option value="" selected="selected">Selecione...</option>

        <?php
        $query = mysql_query("SELECT codigo, nome FROM classificacao");
        while($classificacao = mysql_fetch_array($query))
        {?>
        <option value="<?php echo $classificacao['codigo']?>">
                       <?php echo $classificacao['nome']   ?></option>
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
//verifica que a opção marca e modelo foi selecionada ou não
$marca          = (empty($_POST['marca']))? 'null' : $_POST['marca'];
$categoria      = (empty($_POST['categoria']))? 'null' : $_POST['categoria'];
$classificacao  = (empty($_POST['classificacao']))? 'null' : $_POST['classificacao'];

//---------- pesquisar  marca escolhida ----------------

if (($marca <> 'null') and ($categoria == 'null') and ($classificacao == 'null'))
{
     $sql_produtos       = "SELECT produto.descricao,produto.cor,produto.tamanho,produto.preco,produto.foto1,produto.foto2
                            FROM produto, marca, categoria, classificacao
                            WHERE produto.codmarca = marca.codigo
                            and produto.codcategoria = categoria.codigo
                            and produto.codclassificacao = classificacao.codigo
                            and marca.codigo = $marca ";
                            
     $seleciona_produtos = mysql_query($sql_produtos);
}

//---------- pesquisar categoria escolhida ----------------

//---------- pesquisar marca e categoria escolhida ----------------

//---------- pesquisar classificacao escolhida ----------------

//---------- pesquisar marca e categoria e classificacao escolhido ----------------

// colocar mais filtros ?????



//---------- mostrar as informações dos produtos  ----------------
if(mysql_num_rows($seleciona_produtos) == 0)
{
   echo '<h1>Desculpe, mas sua busca nao retornou resultados ... </h1>';
}
else
{
   echo "Resultado da pesquisa de Produtos: <br><br>";
    while ($dados = mysql_fetch_object($seleciona_produtos))
	{
      echo "Descrição :".$dados->descricao." ";
      echo "  Cor       : ".$dados->cor." ";
      echo "  Tamanho   : ".$dados->tamanho." ";
      echo "  Preço R$  : ".$dados->preco."<br>";
      echo '<img src="fotos/'.$dados->foto1.'" height="100" width="150" />'." ";
      echo '<img src="fotos/'.$dados->foto2.'" height="100" width="150" />'."<br><br>";
	}
   }
}
?>
</body>

</HTML>
