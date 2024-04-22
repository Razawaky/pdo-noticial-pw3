<?php

// include ('../connection/conn.php'); // Inclui o arquivo de conexão com o banco de dados.

if ($_POST['operacao'] == 'create') { // Verifica se a operação é de criação.

    if (empty($_POST['nome']) || // Verifica se os campos nome e noticia_id estão vazios.
       empty($_POST['noticia_id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    } else {

        try {
            $sql = "INSERT INTO IMG_NOTICIA (NOME, NOTICIA_ID) VALUES (?,?)"; // Monta a query SQL para inserção de uma nova imagem de notícia.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['nome'],
                $_POST['noticia_id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem da notícia salva com sucesso'
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
        $sql = "SELECT * FROM IMG_NOTICIA"; // Monta a query SQL para selecionar todas as imagens de notícia.
        $resultado = $pdo->query($sql); // Executa a query SQL e recebe o resultado.
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { // Itera sobre o resultado da consulta.
            $dados[] = array_map(null, $row); // Mapeia os dados da imagem de notícia para o array de resultados.
        }

    } catch (PDOException $e) {
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e->getMessage() // Captura e trata exceções em caso de erro na consulta.
        ];
    }
}

if ($_POST['operacao'] == 'update') { // Verifica se a operação é de atualização.

    if (empty($_POST['nome']) || // Verifica se os campos nome, noticia_id e id estão vazios.
       empty($_POST['noticia_id']) ||
       empty($_POST['id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos para alterar vazios.'
        ];
    } else {

        try {
            $sql = "UPDATE IMG_NOTICIA SET NOME = ?, NOTICIA_ID = ? WHERE ID = ?"; // Monta a query SQL para atualizar os dados de uma imagem de notícia.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['nome'],
                $_POST['noticia_id'],
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem da notícia atualizada com sucesso'
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

    if (empty($_POST['id'])) { // Verifica se o ID da imagem da notícia está vazio.

        $dados = [
            'type' => 'error',
            'message' => 'ID da imagem notícia não reconhecido ou inexistente'
        ];
    } else {

        try {
            $sql = "DELETE FROM IMG_NOTICIA WHERE ID = ?"; // Monta a query SQL para deletar uma imagem de notícia.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Imagem da notícia deletada com sucesso'
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
