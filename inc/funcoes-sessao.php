<?php
/* Aqui programaremos futuramente
os recursos de login/logout e verificação
de permissão de acesso dos usuários */

/* Verificar se não existe sessão em 
funcionamento */

if(!isset($_SESSION)){
    session_start();
}


function verificaAcesso(){
    /* Se NÃO EXISTE uma variável de sessão relacionada
    ao id do usuário logado... */
    if(!isset($_SESSION['id'])){
        /* então significa que ele NÃO ESTÁ LOGADO, portanto
        apague qualquer resquício de sessão e force o usuário
        a ir para o login.php */
        session_destroy();
        header("location:../login.php");
        die();
    }
}


/* usado na pagina login.php */
function login(int $id, string $nome, string $email, string $tipo) {
    
    /* criando variaveis de sessão ao logar */
    $_SESSION['id'] = $id;
    $_SESSION['nome'] = $nome;
    $_SESSION['email'] = $email;
    $_SESSION['tipo'] = $tipo;
}

/* usado nas paginas administrativas quando clicamos em sair */
function logout() {
    session_start();
    session_destroy();
    header("location:../login.php?logout");
    die(); /* ou exit */

}

function verificaAcessoAdmin() {

    /* se o tipo de usuario logadoNÃO FOR admin */
    if($_SESSION['tipo'] !='admin') {

        /* redirecionar para a pagina nao-autorizado */
        header("location:nao-autorizado.php");
        die(); /* exit */
    }

}