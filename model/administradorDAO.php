<?php
class administradorDAO
{

    private $conn;

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function getAdministradorById($id_usuario)
    {

        try {
            $query = "SELECT * FROM administrador WHERE id_usuario = :id_usuario";
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
            if ($stmt->execute()) {
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                return "ocorreu um erro {$stmt->errorInfo()} ";
            }
        } catch (PDOException $erro) {
            return "ocorreu um erro" . $erro->getMessage() . "<br>arquivo:" . $erro->getFile();
        }
    }

    public function inserirAdministrador($id_usuario)
    {
        $query = "INSERT INTO administrador(id_usuario) VALUES (:id_admin)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_admin', $id_usuario, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return TRUE;
        } else {
            return $stmt->errorInfo();
        }
    }

    public function deleteAdministradorById($id_usuario)
    {

        $query = "DELETE FROM administrador WHERE id_usuario = :id_usuario";
        $stmt = $this->conn->prepare($query);
        $stmt->bindValue(':id_usuario', $id_usuario, PDO::PARAM_INT);
        if ($stmt->execute()) {
            return TRUE;
        } else {
            return "ocorreu um erro " . $stmt->errorInfo();
        }
    }
    public function getAllUsuarioByTipo($tipo)
    {
        switch ($tipo) {
            case "cliente":
                $query = "SELECT usuario.* , cliente.telefone,id_cliente FROM usuario JOIN cliente ON usuario.id_usuario = cliente.id_usuario;";
                $stmt = $this->conn->prepare($query);
                if ($stmt->execute()) {
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "ocorreu um erro" . $stmt->errorInfo();
                }
                break;

                case "dono"://nessa consulta sql será selecionado todos os mercados combinados com a tabela usuario, onde id_dono for igual id_usuario
                $query = "SELECT * FROM mercado JOIN usuario ON mercado.id_dono = usuario.id_usuario;";
                $stmt = $this->conn->prepare($query);
                if ($stmt->execute()){
                    return $stmt->fetchAll(PDO::FETCH_ASSOC);
                } else {
                    return "ocorreu um erro" . $stmt->errorInfo();
                }break;
        }
    }
}
