<?php

include ('../connection/conn.php'); // Inclui o arquivo de conexão com o banco de dados.

if ($_POST['operacao'] == 'create') { // Verifica se a operação é de criação.

    if (empty($_POST['titulo']) || // Verifica se os campos título, data, local, horário, resumo, corpo e autor_id estão vazios.
       empty($_POST['data']) ||
       empty($_POST['local']) ||
       empty($_POST['horario']) ||
       empty($_POST['resumo']) || 
       empty($_POST['corpo']) ||
       empty($_POST['autor_id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    } else {

        try {
            $sql = "INSERT INTO EVENTO (TITULO, DATA, LOCAL, HORARIO, RESUMO, CORPO, AUTOR_ID) VALUES (?,?,?,?,?,?,?)"; // Monta a query SQL para inserção de um novo evento.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['titulo'],
                $_POST['data'],
                $_POST['local'],
                $_POST['horario'],
                $_POST['resumo'],
                $_POST['corpo'],
                $_POST['autor_id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Evento salvo com sucesso'
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
        $sql = "SELECT * FROM EVENTO"; // Monta a query SQL para selecionar todos os eventos.
        $resultado = $pdo->query($sql); // Executa a query SQL e recebe o resultado.
        while ($row = $resultado->fetch(PDO::FETCH_ASSOC)) { // Itera sobre o resultado da consulta.
            $dados[] = array_map(null, $row); // Mapeia os dados do evento para o array de resultados.
        }

    } catch (PDOException $e) {
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e->getMessage() // Captura e trata exceções em caso de erro na consulta.
        ];
    }
}

if ($_POST['operacao'] == 'update') { // Verifica se a operação é de atualização.

    if (empty($_POST['titulo']) || // Verifica se os campos título, data, local, horário, resumo, corpo, autor_id e id estão vazios.
       empty($_POST['data']) ||
       empty($_POST['local']) ||
       empty($_POST['horario']) ||
       empty($_POST['resumo']) || 
       empty($_POST['corpo']) ||
       empty($_POST['autor_id']) ||
       empty($_POST['id'])) {

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos para alterar vazios.'
        ];
    } else {

        try {
            $sql = "UPDATE EVENTO SET TITULO = ?, DATA = ?, LOCAL = ?, HORARIO = ?, RESUMO = ?, CORPO = ?, AUTOR_ID = ? WHERE ID = ?"; // Monta a query SQL para atualizar os dados de um evento.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['titulo'],
                $_POST['data'],
                $_POST['local'],
                $_POST['horario'],
                $_POST['resumo'],
                $_POST['corpo'],
                $_POST['autor_id'],
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Evento atualizado com sucesso'
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

    if (empty($_POST['id'])) { // Verifica se o ID do evento está vazio.

        $dados = [
            'type' => 'error',
            'message' => 'ID do evento não reconhecido ou inexistente'
        ];
    } else {

        try {
            $sql = "DELETE FROM EVENTO WHERE ID = ?"; // Monta a query SQL para deletar um evento.
            $stmt = $pdo->prepare($sql); // Prepara a query para execução.
            $stmt->execute([ // Executa a query SQL.
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Evento deletado com sucesso'
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
