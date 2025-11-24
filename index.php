<?php

session_start();
if (!empty($_SESSION['nome'])) {
  header("location:dashboard.php");
}

require __DIR__ . "/vendor/autoload.php";

$client = new Google\Client;

$client->setClientId("1066806316509-5hhc9aro4vjqh0qve5taqk2oh4tjqlkj.apps.googleusercontent.com");
$client->setClientSecret("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");
$client->setRedirectUri("http://localhost/ctrlfy/funcoes/cadastroUserGoogle.php");

$client->addScope("email");
$client->addScope("profile");

$url = $client->createAuthUrl();

?>

<!DOCTYPE html>
<html lang="pt-br">

<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
  }

  body {
    background: #f3f3f3;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .wrapper {
    width: 900px;
    height: 520px;
    background: #ffffff;
    overflow: hidden;
    display: flex;
    position: relative;
    box-shadow: 0 0 25px rgba(0, 0, 0, 0.15);
    transition: 0.4s ease;
  }

  .form-panel {
    width: 50%;
    padding: 40px;
    display: flex;
    flex-direction: column;
    justify-content: center;
    background: #ffffff;
    position: relative;
    z-index: 2;
    transition: 0.4s ease;
  }

  .form-container {
    display: none;
  }

  .form-container.active {
    display: flex;
  }

  .form-container h3 {
    margin-bottom: 20px;
    font-size: 26px;
    color: #e56c00;
    font-weight: bold;
    text-align: center;
  }

  .form-content {
    width: 70%;
  }

  input.form-control {
    width: 100%;
    padding: 12px;
    border: 1px solid #bbb;
    border-radius: 8px;
    font-size: 15px;
    transition: 0.25s;
  }

  input.form-control:focus {
    border-color: #ff7a00;
    box-shadow: 0 0 8px rgba(255, 122, 0, 0.3);
    outline: none;
  }

  .btn-orange {
    width: 80%;
    padding: 12px;
    background: #ff7a00;
    color: white;
    border: none;
    font-size: 16px;
    border-radius: 30px;
    cursor: pointer;
    transition: 0.25s;
  }

  .btn-orange:hover {
    background: #e56c00;
  }

  .logo-panel {
    width: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    position: relative;
    overflow: hidden;
  }

  .logo-content {
    text-align: center;
    transition: 0.4s ease;
  }

  .logo-img {
    width: 250px;
    opacity: 0.95;
    transition: 0.4s;
  }

  .wrapper.toggle .form-panel {
    transform: translateX(100%);
  }

  .wrapper.toggle .logo-panel {
    transform: translateX(-100%);
  }
</style>



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
      <div class="form-container login active justify-content-center align-items-center" id="loginForm">
        <h3>Login</h3>
        <form class="form-content" action="funcoes/login.php" method="post">
          <input type="email" class="form-control mb-3" placeholder="E-mail" name="email">
          <input type="password" class="form-control mb-4" placeholder="Senha" name="senha">
          <button type="submit" class="btn btn-orange d-block mx-auto">Entrar</button>
        </form>
        <!-- <div>
      <a href="<?= $url ?>"> <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" 
         alt="Entrar com Google"></a>
    </div> -->

      </div>

      <div class="form-container cadastro justify-content-center align-items-center" id="cadastroForm">
        <h3>Cadastre-se</h3>
        <form class="form-content" action="funcoes/cadastroUser.php" method="post">
          <input type="text" class="form-control mb-3" placeholder="Nome" name="nome" required>
          <input type="text" class="form-control mb-3" placeholder="Sobrenome" name="sobrenome" required>
          <input type="text" class="form-control mb-3" placeholder="CPF" name="cpf" id="cpf" maxlength="14" required>
          <input type="tel" class="form-control mb-3" placeholder="Telefone" name="telefone" id="telefone" maxlength="15" onkeyup="handlePhone(event)" required>
          <input type="email" class="form-control mb-3" placeholder="E-mail" name="email" required>
          <input type="password" class="form-control mb-4" placeholder="Senha" name="senha" required>
          <button type="submit" class="btn btn-orange d-block mx-auto">Cadastrar</button>
        </form>
        <!-- <a href="<?= $url ?>"> <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png" 
         alt="Entrar com Google"></a> -->
      </div>
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

    function formatarCPF(e) {
      var v = e.target.value.replace(/\D/g, "");
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d)/, "$1.$2");
      v = v.replace(/(\d{3})(\d{1,2})$/, "$1-$2");
      e.target.value = v;
    }

    //formatar telefone
    const handlePhone = (event) => {
      let input = event.target
      input.value = phoneMask(input.value)
    }

    const phoneMask = (value) => {
      if (!value) return ""
      value = value.replace(/\D/g, '')
      value = value.replace(/(\d{2})(\d)/, "($1) $2")
      value = value.replace(/(\d)(\d{4})$/, "$1-$2")
      return value
    }
  </script>

</body>

</html>