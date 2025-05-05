<?php
session_start();

$connect = mysql_connect('localhost', 'root', '');
if (!$connect) {
    die('Erro na conexão: ' . mysql_error());
}

$db = mysql_select_db('loja');
if (!$db) {
    die('Erro ao selecionar banco: ' . mysql_error());
}

if (!isset($_SESSION['carrinho'])) {
    $_SESSION['carrinho'] = array();
}

if (isset($_POST['acao'])) {
    $acao = $_POST['acao'];
    
    if ($acao == 'adicionar') {
        $codigo = $_POST['codigo'];
        
        if (isset($_SESSION['carrinho'][$codigo])) {
            $_SESSION['carrinho'][$codigo]['quantidade']++;
        } else {
            $sql = "SELECT 
                    p.codigo, p.descricao, p.cor, p.tamanho, p.preco, p.foto_1,
                    m.nome marca_nome, c.nome categoria_nome, t.nome tipo_nome
                FROM 
                    produto p, 
                    marca m, 
                    categoria c, 
                    tipo t
                WHERE p.codigo_marca = m.codigo 
                AND p.codigo_categoria = c.codigo 
                AND p.codigo_tipo = t.codigo
                AND p.codigo = '$codigo'";
                
            $resultado = mysql_query($sql);
            $produto = mysql_fetch_assoc($resultado);
            
            $_SESSION['carrinho'][$codigo] = array(
                'codigo' => $produto['codigo'],
                'descricao' => $produto['descricao'],
                'preco' => $produto['preco'],
                'foto_1' => $produto['foto_1'],
                'cor' => $produto['cor'],
                'tamanho' => $produto['tamanho'],
                'quantidade' => 1
            );
        }
        
        header("Location: carrinho.php");
        exit;
    }
    
    if ($acao == 'remover') {
        $codigo = $_POST['codigo'];
        if (isset($_SESSION['carrinho'][$codigo])) {
            unset($_SESSION['carrinho'][$codigo]);
        }
        header("Location: carrinho.php");
        exit;
    }
    
    if ($acao == 'atualizar') {
        $codigo = $_POST['codigo'];
        $quantidade = intval($_POST['quantidade']);
        
        if ($quantidade <= 0) {
            unset($_SESSION['carrinho'][$codigo]);
        } else {
            $_SESSION['carrinho'][$codigo]['quantidade'] = $quantidade;
        }
        
        header("Location: carrinho.php");
        exit;
    }
}

function calcularTotal() {
    $total = 0;
    if (isset($_SESSION['carrinho']) && count($_SESSION['carrinho']) > 0) {
        foreach ($_SESSION['carrinho'] as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
    }
    return $total;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
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
    
    <div class="carrinho-container">
        <h2>Seu Carrinho de Compras</h2>
        
        <?php if (empty($_SESSION['carrinho'])): ?>
            <div class="carrinho-vazio">
                <p>Seu carrinho está vazio.</p>
                <p><a href="home.php">Continuar Comprando</a></p>
            </div>
        <?php else: ?>
            
            <div class="carrinho-itens">
                <?php foreach ($_SESSION['carrinho'] as $codigo => $item): ?>
                    <div class="carrinho-item">
                        <img src="../images/<?php echo $item['foto_1']; ?>" alt="<?php echo $item['descricao']; ?>">
                        
                        <div class="item-info">
                            <h3><?php echo $item['descricao']; ?></h3>
                            <p>Cor: <?php echo $item['cor']; ?> | Tamanho: <?php echo $item['tamanho']; ?></p>
                        </div>
                        
                        <div class="item-quantidade">
                            <form action="carrinho.php" method="post">
                                <input type="hidden" name="acao" value="atualizar">
                                <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
                                <input type="number" name="quantidade" value="<?php echo $item['quantidade']; ?>" min="1">
                                <button type="submit" class="botao-atualizar">Atualizar</button>
                            </form>
                        </div>
                        
                        <div class="item-preco">
                            R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?>
                        </div>
                        
                        <div class="item-total">
                            R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?>
                        </div>
                        
                        <div>
                            <form action="carrinho.php" method="post">
                                <input type="hidden" name="acao" value="remover">
                                <input type="hidden" name="codigo" value="<?php echo $codigo; ?>">
                                <button type="submit" class="botao-remover">X</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            
            <div class="carrinho-total">
                Total da Compra: R$ <?php echo number_format(calcularTotal(), 2, ',', '.'); ?>
            </div>
            
            <div class="botoes-acao">
                <a href="home.php" class="botao-continuar">Continuar Comprando</a>
                <button class="botao-finalizar">Finalizar Compra</button>
            </div>
            
        <?php endif; ?>
    </div>
</body>
</html>