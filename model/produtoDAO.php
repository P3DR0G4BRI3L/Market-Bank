<?php
class produtoDAO
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function inserirProduto($nome, $preco, $fotoProduto, $descricao, $id_mercado)
    {
        $img = $this->lidarImagem($fotoProduto);
        $query = "INSERT INTO produto (nome, preco, fotoProduto, descricao, id_mercado) VALUES (:nome, :preco, :fotoProduto, :descricao,:id_mercado);";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindValue(':preco', $preco);
        $stmt->bindValue(':fotoProduto', $img, PDO::PARAM_STR);
        $stmt->bindValue(':descricao', $descricao, PDO::PARAM_STR);
        $stmt->bindValue(':id_mercado', $id_mercado, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return TRUE;

        } else {
            return "ocorreu um erro" . $stmt->errorInfo();
        }
    }

    public function lidarImagem($filesimagem)
    {
        if(is_array($filesimagem) && isset($filesimagem['name']) && isset($filesimagem['type'])
         && isset($filesimagem['tmp_name']) && isset($filesimagem['error']) && isset($filesimagem['size'])){
        if ($filesimagem['error'] === UPLOAD_ERR_OK) {
            //este trecho if cuida para que a imagem seja copiada para a pasta cadastro/uploads no servidor local e o caminho fique armazenado no banco de dados
// Verifica se o arquivo foi enviado com sucesso

            // Diretório onde você deseja armazenar as imagens
            $diretorioDestino = '../cadastro/uploads/';
            $fileInfo = pathinfo($filesimagem['name']);
            // Nome do arquivo original
            $filesimagem['name'] = uniqid();
            $imagem = $filesimagem['name'] . '.' . $fileInfo['extension'];

            // Caminho completo para onde o arquivo será movido
            $caminhoDestino = $diretorioDestino . $imagem;

            // Move o arquivo enviado para o diretório de destino
            if (move_uploaded_file($filesimagem['tmp_name'], $caminhoDestino)) {
                //Arquivo enviado com sucesso.
                return $imagem;
            } else {
                echo "Erro ao mover o arquivo para o diretório de destino.";
            }
        } else {
            echo "Erro no envio do arquivo: " . $_FILES['imagem']['error'];
        }
    }else{
        $imagem = $filesimagem;
        return $imagem;
    }

}
    public function getAllProdutoByIdMercado($id_mercado){
            $stmt = $this->conn->prepare("SELECT * FROM produto WHERE id_mercado = :id_mercado ;");
            $stmt->bindValue(':id_mercado', $id_mercado, PDO::PARAM_INT);
            if($stmt->execute()){
                return $stmt->fetchAll(PDO::FETCH_ASSOC);
            }else{
                return "ocorreu um erro " . $stmt->errorInfo();
            }

    }

    public function excluirproduto($id_produto){
        $query = "DELETE FROM produto WHERE id_produto = :id_produto ;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_produto',$id_produto,PDO::PARAM_INT);
        if($stmt->execute()){
            return TRUE;
        }else{
            return "ocorreu um erro" . $stmt->errorInfo();
        }
    }
    public function getProdutoById($id_produto){
        $query = "SELECT * FROM produto WHERE id_produto = :id_produto";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_produto',$id_produto,PDO::PARAM_INT);
        if($stmt->execute()){
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }else{
            return "ocorreu um erro" . $stmt->errorInfo();
        }
    }
    public function getAllProdutoByIdFiltro($id_filtro){
        $query = "SELECT * FROM produto WHERE id_filtro = :id_filtro;";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_filtro',$id_filtro,PDO::PARAM_INT);
        if($stmt->execute()){
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }else{
            return "ocorreu um erro" . $stmt->errorInfo();
        }
    }


}

