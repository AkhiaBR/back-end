<?php
   // conecta ao banco de dados:
   $connect = mysql_connect('localhost', 'root', '');
   if (!$connect) {
       die('Erro na conexão: ' . mysql_error());
   }
   
   $db = mysql_select_db('loja');
   if (!$db) {
       die('Erro ao selecionar banco: ' . mysql_error());
   }
   
?>

<html>
   <head>
      <title>PAGINA INICIAL</title>
      <link rel="stylesheet" href="style.css">
   </head>
   <body>
   <header>
        <h1>PERFIL VESTIMENTAS</h1>
        <div class="header-right">
                <a href="carrinho.php">
                <img src="../images/carrinho.png" alt="Carrinho">
                </a>
            <h2><a href="login.html">LOGIN</a></h2>
        </div>
    </header>
      
      <div class="container">
         <form name="formulario" method="post" action="">
            <label>Categorias: </label>
            <select name="categoria">
               <option value="" selected="selected">Selecione...</option>
               <?php
                  $query = mysql_query("SELECT codigo, nome FROM categoria");
                  while ($categorias = mysql_fetch_array($query)) {
                     echo '<option value="' . $categorias['codigo'] . '">' . $categorias['nome'] . '</option>';
                  }
               ?>
            </select>
            
            <label>Tipo: </label>
            <select name="tipo">
               <option value="" selected="selected">Selecione...</option>
               <?php
                  $query = mysql_query("SELECT codigo, nome FROM tipo");
                  while ($tipo = mysql_fetch_array($query)) {
                     echo '<option value="' . $tipo['codigo'] . '">' . $tipo['nome'] . '</option>';
                  }
               ?>
            </select>
            
            <label>Marcas: </label>
            <select name="marca">
               <option value="" selected="selected">Selecione...</option>
               <?php
                  $query = mysql_query("SELECT codigo, nome FROM marca");
                  while ($marcas = mysql_fetch_array($query)) {
                     echo '<option value="' . $marcas['codigo'] . '">' . $marcas['nome'] . '</option>';
                  }
               ?>
            </select>
            
            <input type="submit" name="pesquisar" value="PESQUISAR">
         </form>
         
         <div id="resultados"> <!-- container para resultado do query -->
            <?php
            
            $marca = null;
            $categoria = null;
            $tipo = null;
            
            // define tudo para null depois da pesquisa
            if (isset($_POST['pesquisar'])) {
               $marca = !empty($_POST['marca']) ? $_POST['marca'] : null;
               $categoria = !empty($_POST['categoria']) ? $_POST['categoria'] : null;
               $tipo = !empty($_POST['tipo']) ? $_POST['tipo'] : null;
            }
            
            $sql = "SELECT 
                        p.codigo, p.descricao, p.cor, p.tamanho, p.preco, p.foto_1, p.foto_2,
                        m.nome marca_nome, c.nome categoria_nome, t.nome tipo_nome
                     FROM 
                        produto p, 
                        marca m, 
                        categoria c, 
                        tipo t
                     WHERE p.codigo_marca = m.codigo 
                     AND p.codigo_categoria = c.codigo 
                     AND p.codigo_tipo = t.codigo";
            
            // adiciona filtros se selecionados
            if ($marca) {
               $sql .= " AND p.codigo_marca = '$marca'";
            }
            if ($categoria) {
               $sql .= " AND p.codigo_categoria = '$categoria'";
            }
            if ($tipo) {
               $sql .= " AND p.codigo_tipo = '$tipo'";
            }
            
            $resultado = mysql_query($sql);
            
            // verifica se tem resultado
            if (mysql_num_rows($resultado) > 0) {
               // se tiver houver filtragem, a mensagem é diferente
               if (isset($_POST['pesquisar'])) {
                  echo "<h2>Resultados da pesquisa:</h2>";
               } else {
                  echo "<h2>Todos os produtos:</h2>";
               }
               
               echo '<div class="produtos-grid">';
               
               while ($produto = mysql_fetch_assoc($resultado)) {
                  echo '<div class="produto">';
                  echo '<h3>' . $produto['descricao'] . '</h3>';
                  echo '<div class="produto-info">';
                  echo '<p><strong>Marca:</strong> ' . $produto['marca_nome'] . '</p>';
                  echo '<p><strong>Categoria:</strong> ' . $produto['categoria_nome'] . ' | ';
                  echo '<strong>Tipo:</strong> ' . $produto['tipo_nome'] . '</p>';
                  echo '<p><strong>Cor:</strong> ' . $produto['cor'] . ' | ';
                  echo '<strong>Tamanho:</strong> ' . $produto['tamanho'] . '</p>';
                  echo '<p class="preco"><strong>Preço:</strong> R$ ' . number_format($produto['preco'], 2, ',', '.') . '</p>';
                  echo '</div>';
                  echo '<div class="produto-fotos">';
                  echo '<img src="../images/' . $produto['foto_1'] . '" alt="Foto 1" />';
                  echo '<img src="../images/' . $produto['foto_2'] . '" alt="Foto 2" />';
                  echo '</div>';
                  echo '<form action="carrinho.php" method="post">';
                  echo '<input type="hidden" name="acao" value="adicionar">';
                  echo '<input type="hidden" name="codigo" value="' . $produto['codigo'] . '">';
                  echo '<input type="hidden" name="descricao" value="' . $produto['descricao'] . '">';
                  echo '<input type="hidden" name="preco" value="' . $produto['preco'] . '">';
                  echo '<input type="hidden" name="foto_1" value="' . $produto['foto_1'] . '">';
                  echo '<button type="submit" class="botao-comprar">Comprar</button>';
                  echo '</form>';
                  echo '</div>';
               }
               echo '</div>';
            } else {
               echo '<h2>Nenhum produto encontrado com os filtros selecionados.</h2>';
            }
            ?>
         </div>
      </div>
   </body>
</html>