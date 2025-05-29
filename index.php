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
    </div>

    <div class="form-container cadastro" id="cadastroForm">
      <h3>Cadastre-se</h3>
      <form action="funcoes/cadastroUser.php" method="post">
      <input type="text" class="form-control mb-2" placeholder="Nome" name="nome">
      <input type="text" class="form-control mb-2" placeholder="Sobrenome" name="sobrenome">
      <input type="text" class="form-control mb-2" placeholder="CPF" name="cpf">
      <input type="tel" class="form-control mb-2" placeholder="Telefone" name="telefone">
      <input type="email" class="form-control mb-2" placeholder="E-mail" name="email">
      <input type="password" class="form-control mb-3" placeholder="Senha" name="senha">
      <button type="submit" class="btn btn-orange">Cadastrar</button>
    </form>
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
</script>

</body>
</html>
