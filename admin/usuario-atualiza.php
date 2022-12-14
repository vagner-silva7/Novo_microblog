<?php 

require "../inc/funcoes-usuarios.php";
require "../inc/cabecalho-admin.php";

verificaAcessoAdmin();

$id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

$usuario = lerUmUsuario( $conexao, $id );

if(isset($_POST['atualizar'])) {
  $nome = filter_input(INPUT_POST, 'nome', FILTER_SANITIZE_SPECIAL_CHARS);
  $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
  $tipo = filter_input(INPUT_POST, 'tipo', FILTER_SANITIZE_SPECIAL_CHARS);

  /* --------------------------------------------------------------------- */
  
  /* Lógica da senha

  1) Se o campo da senha no formulario estiver vazio,
  então siginifica que o usuario NÃO MUDOU A SENHA

    2) Caso contrario, se o usuario, preencheu alguma coisa 
  no campo de senha, precisaremos verificar a senha digitada.
  */

  /* ---------------------------------------------------------------------- */



  /* logica 1 */

  if( empty ( $_POST ['senha']) ) {
    $senha = $usuario['senha'];
  } else {

  /* logica 2 */  
    $senha = verificaSenha ( $_POST ['senha'], $usuario ['senha']);
                          /* senha formulario, senha banco de dados */

  }

  /* teste de comparação de senhas do if / else
  echo "banco de dados ".$usuario['senha'];
  echo "<br>";
  echo "formulario ".$senha; */

  atualizarUsuario($conexao, $id, $nome, $email, $senha, $tipo);
  header("location:index.php");

}

?>


       
<div class="row">
  <article class="col-12 bg-white rounded shadow my-1 py-4">
    <h2 class="text-center">Atualizar Usuário</h2>

    <form class="mx-auto w-75" action="" method="post" id="form-atualizar" name="form-atualizar">

      <div class="form-group">
        <label for="nome">Nome:</label>
        <input value="<?=$usuario['nome']?>" class="form-control" required type="text" id="nome" name="nome">
      </div>

      <div class="form-group">
        <label for="email">E-mail:</label>
        <input value="<?=$usuario['email']?>" class="form-control" required type="email" id="email" name="email">
      </div>

      <div class="form-group">
        <label for="nova-senha">Senha</label>
        <input class="form-control" type="password" id="senha" name="senha" placeholder="Preencha apenas se for alterar">
      </div>

      <div class="form-group">
        <label for="tipo">Tipo:</label>
        <select class="custom-select" name="tipo" id="tipo" required>

          <option value=""></option> 

          <option 
          <?php if( $usuario ['tipo'] == 'editor') echo " selected " ?>
          value="editor">Editor</option>  

          <option	
          <?php if( $usuario ['tipo'] == 'admin') echo " selected " ?>
          value="admin">Administrador</option>

        </select>
      </div>
      
      <button class="btn btn-primary" name="atualizar">Atualizar usuário</button>
    </form>
      
  </article>
</div>

<?php
require "../inc/rodape-admin.php"; 
?>