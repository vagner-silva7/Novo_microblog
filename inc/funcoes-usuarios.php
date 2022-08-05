<?php
require "conecta.php";

// Função inserirUsuario: usada em usuario-insere.php

function inserirusuario($conexao, string $nome, string $email, 
string $senha, string $tipo){
    
    $sql = "INSERT INTO usuarios(nome, email, senha, tipo) 
    VALUES ('$nome','$email','$senha','$tipo')";

    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));
}

// fim inserirUsuario



// Função codificaSenha: usada em usuario-insere.php e usuario-atualiza.php

function codificaSenha(string $senha): string {
    return password_hash($senha, PASSWORD_DEFAULT);
}

// fim codificaSenha



// Função lerUsuarios: usada em usuarios.php

function lerUsuarios(mysqli $conexao):array {
    $sql = "SELECT id, nome, email, tipo FROM usuarios ORDER BY nome";

    /* demonstrar resultado com array */
    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    /*  Array PAI */
    $usuarios = [];

    while ($usuario = mysqli_fetch_assoc($resultado)) {
        array_push($usuarios, $usuario);

    }

    return $usuarios;

}

// fim lerUsuarios



// Função excluirUsuario: usada em usuario-exclui.php

function excluirUsuario (mysqli $conexao, int $id) {
    $sql = "DELETE FROM usuarios WHERE id = $id";
    /* mysqli_query($conexao, $sql) or die(mysqli_error($conexao)); */

        // Se não for possivel deletar o usuario, informar o motivo e retornar a tela usuarios.php
        if( !mysqli_query($conexao, $sql) ){
            die("<p> Não é possível deletar o usuario porque há posts associados a ele.</p>
                 <p> <a href='usuarios.php'>Voltar para usuarios</a></p>"); 
            } 
            
            
} 

// fim excluirUsuario



// Função lerUmUsuario: usada em usuario-atualiza.php

function lerUmUsuario(mysqli $conexao, int $id) {
    $sql = "SELECT id, nome, email, tipo, senha FROM usuarios
    WHERE id = $id";

    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado);

}

// fim lerUmUsuario



// Função verificaSenha: usada em usuario-atualiza.php

function verificaSenha(string $senhaFormulario, string $senhaBanco) {

    /* password_verify, compara as duas senhas, formulario e banco de dados */
    if( password_verify ($senhaFormulario, $senhaBanco)){

        /* mantendo a senha como está, ou as duas senhas estejam iguais,
        quer dizer que a pessoa NÃO QUER MUDAR A SENHA */
        return $senhaBanco; 

    } else {

        /* Sendo diferentes, então pegamos a senha digitada no formulario, 
        e codificamos antes de enviar ao banco de dados */
        return codificaSenha($senhaFormulario);

    }

}


// fim verificaSenha



// Função atualizarUsuario: usada em usuario-atualiza.php

function atualizarUsuario(mysqli $conexao, int $id, string $nome, 
string $email, string $senha, string $tipo) { 

    $sql = "UPDATE usuarios SET nome = '$nome', email = '$email',
    senha = '$senha', tipo = '$tipo' WHERE id = $id ";

    mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

}

// fim atualizarUsuario



// Função buscarUsuario: usada em login.php

function buscarUsuario(mysqli $conexao, string $email) {
    
    $sql = "SELECT id, nome, email, tipo, senha FROM usuarios 
    WHERE email = '$email'";

    $resultado = mysqli_query($conexao, $sql) or die(mysqli_error($conexao));

    return mysqli_fetch_assoc($resultado);

}

// fim buscarUsuario