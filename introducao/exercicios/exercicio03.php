<?php
    // capturar dados do arquivo HTML
    $nome = $_POST['nome'];
    $nota1 = $_POST['nota1'];
    $nota2 = $_POST['nota2'];
    $nota3 = $_POST['nota3'];
    $media = ($nota1+$nota2+$nota3)/3;

    // exibir mensagem 
    echo "O aluno ".$nome." obteve média: ".$media;
?>