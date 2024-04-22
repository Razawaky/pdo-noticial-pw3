<?php

// include ('../connection/conn.php'); // Inclui o arquivo de conexão com o banco de dados.

if ($_POST['operacao'] == 'create') { // Verifica se a operação é de criação.

    if (empty($_POST['nome']) || // Verifica se os campos nome e evento_id estão vazios.
       empty($_POST['evento_id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    } else {

        try {
            $sql = "INSERT INTO IMG_EVENTO (NOME, EVENTO_ID) VALUES (?,?)"; // Monta a query SQL para inserção de uma nova imagem de evento.
            $stmt  = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['nome'],
                $_POST['evento_id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem do evento salva com sucesso'
            ];
        } catch (PDOException $e) {
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage() // Captura e trata exceções em caso de erro.
            ];
        }

    }
}

if ($_POST['operacao'] == 'read') { // Verifica se a operação é de leitura.
    try {
        $sql = "SELECT * FROM IMG_EVENTO"; // Monta a query SQL para selecionar todas as imagens de evento.
        $resultado = $pdo->query($sql); // Executa a query SQL e recebe o resultado.
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { // Itera sobre o resultado da consulta.
            $dados[] = array_map(null, $row); // Mapeia os dados da imagem de evento para o array de resultados.
        }

    } catch (PDOException $e) {
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e->getMessage() // Captura e trata exceções em caso de erro na consulta.
        ];
    }
}

if ($_POST['operacao'] == 'update') { // Verifica se a operação é de atualização.

    if (empty($_POST['nome']) || // Verifica se os campos nome, evento_id e id estão vazios.
       empty($_POST['evento_id']) ||
       empty($_POST['id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos para alterar vazios.'
        ];
    } else {

        try {
            $sql = "UPDATE IMG_EVENTO SET NOME = ?, EVENTO_ID = ? WHERE ID = ?"; // Monta a query SQL para atualizar os dados de uma imagem de evento.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['nome'],
                $_POST['evento_id'],
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem do evento atualizada com sucesso'
            ];
        } catch (PDOException $e) {
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage() // Captura e trata exceções em caso de erro.
            ];
        }

    }
}

if ($_POST['operacao'] == 'delete') { // Verifica se a operação é de exclusão.

    if (empty($_POST['id'])) { // Verifica se o ID da imagem do evento está vazio.

        $dados = [
            'type' => 'error',
            'message' => 'ID da imagem evento não reconhecido ou inexistente'
        ];
    } else {

        try {
            $sql = "DELETE FROM IMG_EVENTO WHERE ID = ?"; // Monta a query SQL para deletar uma imagem de evento.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem do evento deletada com sucesso'
            ];
        } catch (PDOException $e) {
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e->getMessage() // Captura e trata exceções em caso de erro.
            ];
        }

    }
} 


echo json_encode($dados); // Converte os dados para o formato JSON e os imprime na saída.

?>
