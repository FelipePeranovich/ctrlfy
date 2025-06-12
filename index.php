<?php

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("1066806316509-5hhc9aro4vjqh0qve5taqk2oh4tjqlkj.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/ctrlfy/funcoes/cadastroUserGoogle.php");  

$client->addScope("email");
$client->addScope("profile");

$url= $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Login / Cadastro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="css/home.css" />
</head>
<body>

<div class="wrapper" id="wrapper">
  
  <div class="form-panel" id="formPanel">
    <div class="form-container login active" id="loginForm">
      <h3>Login</h3>
      <form action="funcoes/login.php" method="post">
      <input type="email" class="form-control mb-2" placeholder="E-mail" name="email">
      <input type="password" class="form-control mb-3" placeholder="Senha" name="senha">
      <button type="submit" class="btn btn-orange">Entrar</button>
    </form>
    <div>
      <a href="<?= $url ?>"> <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" 
         alt="Entrar com Google"></a>
    </div>
   
    </div>

    <div class="form-container cadastro" id="cadastroForm">
      <h3>Cadastre-se</h3>
      <form action="funcoes/cadastroUser.php" method="post">
      <input type="text" class="form-control mb-2" placeholder="Nome" name="nome" required>
      <input type="text" class="form-control mb-2" placeholder="Sobrenome" name="sobrenome" required>
      <input type="text" class="form-control mb-2" placeholder="CPF" name="cpf" id="cpf" maxlength="14" required>
      <input type="tel" class="form-control mb-2" placeholder="Telefone" name="telefone" id="telefone" maxlength="15" onkeyup="handlePhone(event)" required>
      <input type="email" class="form-control mb-2" placeholder="E-mail" name="email" required>
      <input type="password" class="form-control mb-3" placeholder="Senha" name="senha" required>
      <button type="submit" class="btn btn-orange">Cadastrar</button>
    </form>
    <a href="<?= $url ?>"> <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" 
         alt="Entrar com Google"></a>

  </div>

  <div class="logo-panel right" id="logoPanel">
    <div class="logo-content" id="logoHover">
      <img src="img/logo.png" alt="Logo" class="logo-img">
    </div>
  </div>

</div>

<script>
  const wrapper = document.getElementById('wrapper');
  const loginForm = document.getElementById('loginForm');
  const cadastroForm = document.getElementById('cadastroForm');
  const logoPanel = document.getElementById('logoPanel');
  const logoHover = document.getElementById('logoHover');

  let showingCadastro = false;

  logoHover.addEventListener('mouseenter', () => {
    showingCadastro = !showingCadastro;

    if (showingCadastro) {
      loginForm.classList.remove('active');
      cadastroForm.classList.add('active');
      logoPanel.classList.remove('right');
      logoPanel.classList.add('left');
    } else {
      cadastroForm.classList.remove('active');
      loginForm.classList.add('active');
      logoPanel.classList.remove('left');
      logoPanel.classList.add('right');
    }
  });

  //formatar cpf
const input = document.getElementById("cpf");

input.addEventListener("keyup", formatarCPF);

function formatarCPF(e){
  var v=e.target.value.replace(/\D/g,"");
  v=v.replace(/(\d{3})(\d)/,"$1.$2");
  v=v.replace(/(\d{3})(\d)/,"$1.$2");
  v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
  e.target.value = v;
} 

//formatar telefone
const handlePhone = (event) => {
    let input = event.target
    input.value = phoneMask(input.value)
  }
  
  const phoneMask = (value) => {
    if (!value) return ""
    value = value.replace(/\D/g,'')
    value = value.replace(/(\d{2})(\d)/,"($1) $2")
    value = value.replace(/(\d)(\d{4})$/,"$1-$2")
    return value
  }
</script>

</body>
</html>
