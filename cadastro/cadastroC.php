<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$database = "marketbank";

$conn = new mysqli($servername, $username, $password, $database);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Obtem os dados do formulário
$nome = $_POST['nome'];
$email = $_POST['email'];
$senha = $_POST['senha'];


//verifica se o email inserido na hora do cadastro já está cadastrado no sistema, se estiver retorna erro
$sqlverify = "SELECT * FROM usuario WHERE email = '$email';";
$result = $conn->query($sqlverify);
if ($result->num_rows > 0) {
    echo "<script>
             alert('O email inserido já está em uso');
             window.location.href = 'cadastrarCliente.php';
           </script>";
    exit;
}

// Insere os dados na tabela de usuários
$sql = "INSERT INTO usuario (nome, email, senha, tipo) 
VALUES 
('$nome', '$email', '$senha', 'cliente');";


if ($conn->query($sql) === TRUE) {

    
    $infusuario = $conn->query("SELECT * FROM usuario WHERE email = '$email' ");
    $id_usuario = $infusuario->fetch_assoc();
    $id_usuariof = $id_usuario['id_usuario'];
    
    $sqlcliente = "INSERT INTO cliente (id_usuario) 
    VALUES 
    ('$id_usuariof');";
    
    if ($conn->query($sqlcliente) === TRUE)
        // Usuário autenticado com sucesso
        echo "<script>alert('Cadastro realizado com sucesso!');</script>";
    echo "<script>window.location.href = '../index.php';</script>";
    exit; // Certifique-se de sair do script após o redirecionamento
} else {
    echo "Erro ao cadastrar: " . $conn->error;
}


$conn->close();

