<?php

require "inc/cabecalho.php";
require "inc/funcoes-sessao.php";
require "inc/funcoes-usuarios.php";

/* Mensagens para os processos de erros no login */
if( isset($_GET['acesso_proibido']) ){
  $feedback = "Você deve logar primeiro!";
} elseif( isset($_GET['logout']) ) {
  $feedback = "Você saiu do sistema!";
} elseif( isset($_GET['nao_encontrado']) ) {
  $feedback = "Usuário não encontrado!";
} elseif( isset($_GET['senha_incorreta']) ) {
  $feedback = "A senha está errada!";          
} elseif( isset($_GET['campos_obrigatorios']) ) {
  $feedback = "Você deve preencher todos os campos!";
} else {
  $feedback = "";
}

/* botao entrar foi acionado */

if ( isset ( $_POST ['entrar'])) {
    
  /* verifica se os campos estão vazios */
  if ( empty ( $_POST ['email']) || empty ( $_POST ['senha'])) {
      
    /* redireciona para o login, com parametro campos obrigatorios */
    header("location:login.php?campos_obrigatorios");
    
  } else {
      
      /* caso contrario, pegue o email e a senha digitados */
      $email = filter_input ( INPUT_POST, 'email', FILTER_SANITIZE_EMAIL );
      $senha = $_POST ['senha'];
    
      /* Verficando no banco de dados se existe alguem com o email informado */
      $usuario = buscarUsuario ( $conexao, $email );

      /* Se for diferente de nulo é porque tem usuario ou email cadastrado */
      /* != siginifica DIFERENTE      == significa IGUAL */
      if($usuario != null) {
        /* se as senhas forem iguais */
        if(password_verify($senha, $usuario['senha'])){


          /* entao inicia o login para a area administrativa */
          login(
            $usuario['id'], $usuario['nome'], 
            $usuario['email'], $usuario['tipo']
          );

          
          header("location:admin/index.php");

        } else {

          /* caso contrario, fique no login e informa que a senha está errada */
          header("location:login.php?senha_incorreta");  /* ok */
        }

      } else {

      /* caso contrario, não existe usuario */  
      header("location:login.php?nao_encontrado"); /* linha 132 */

      }
      
  }

}

?>
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Acesso à área administrativa</h2>

    <form action="" method="post" id="form-login" name="form-login" class="mx-auto w-50">

      <p class="my-2 alert alert-warning text-center">
      <?= $feedback ?>
      </p>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input class="form-control" type="email" id="email" name="email">
      </div>
      <div class="form-group">
        <label for="senha">Senha:</label>
        <input class="form-control" type="password" id="senha" name="senha">
      </div>

      <button class="btn btn-primary btn-lg" name="entrar" type="submit">Entrar</button>

    </form>
  </article>

</div>

<?php
require "inc/rodape.php";
?>