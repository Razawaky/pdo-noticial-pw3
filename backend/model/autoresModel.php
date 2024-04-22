<?php

include ('../connection/conn.php'); // Inclui o arquivo de conexão com o banco de dados.

if ($_POST['operacao'] == 'create') { // Verifica se a operação é de criação.

    if (empty($_POST['autor_id']) || // Verifica se os campos estao vazios
        empty($_POST['noticia_id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    } else {

        try {
            $sql = "INSERT INTO AUTORES (AUTOR_ID, NOTICIA_ID) VALUES (?,?)";
                $stmt = $pdo->prepare($sql);
                $stmt -> execute([ 
                $_POST['autor_id'],
                $_POST['noticia_id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Ligação entre autor e notícia salva com sucesso'
            ];
        } catch (PDOException $e) {
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }
}

if ($_POST['operacao'] == 'read') { // Verifica se a operação é de leitura.
    try {
        $sql = "SELECT * FROM AUTORES";
        $resultado = $pdo->query($sql);
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){ 
            $dados[] = array_map(null, $row); 
        }

    } catch (PDOException $e) {
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e->getMessage()
        ];
    }
}

if ($_POST['operacao'] == 'delete') { // Verifica se a operação é de exclusão.

    if (empty($_POST['noticia_id'])) { // Verifica se o ID da notícia está vazio.

        $dados = [
            'type' => 'error',
            'message' => 'ID da notícia não reconhecido ou inexistente'
        ];
    } else {

        try {
             $sql = "DELETE FROM AUTORES WHERE NOTICIA_ID = ?";
             $stmt = $pdo->prepare($sql); 
             $stmt -> execute([ 
                 $_POST['noticia_id']
             ]);
            $dados = [
                'type' => 'success',
                'message' => 'A notícia digitada foi deletada com sucesso'
            ];
        } catch (PDOException $e) {
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage()
            ];
        }
    }
}


echo json_encode($dados); // Converte os dados para o formato JSON e os imprime na saída.

?>
