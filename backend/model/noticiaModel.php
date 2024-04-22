<?php

include ('../connection/conexao.php');

date_default_timezone_set('America/Sao_Paulo');
$dataAtual = date('Y-m-d H:i:s', time()); 


if($_POST['operacao'] == 'create'){

    if(empty($_POST['titulo']) || 
       empty($_POST['resumo']) || 
       empty($_POST['corpo'])){

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    }else{

        try{
            $sql = "INSERT INTO NOTICIA (TITULO, RESUMO, CORPO, DATA) VALUES (?,?,?,?)";
            $stmt /*statement*/ = $pdo->prepare($sql); 
            $stmt -> execute([ 
                $_POST['titulo'],
                $_POST['resumo'],
                $_POST['corpo'],
                $dataAtual
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Registro salvo com sucesso'
            ];
        }catch(PDOException $e){
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e -> getMessage()
            ];
        }

    }
}

if($_POST['operacao'] == 'read'){
    try{

        $sql = "SELECT * FROM NOTICIA";
        $resultado = $pdo->query($sql); 
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){ 
            $dados[] = array_map(null, $row); 
        }

    }catch(PDOException $e){
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e -> getMessage()
        ];
    }
}

if($_POST['operacao'] == 'update'){

    if(empty($_POST['titulo']) || 
       empty($_POST['resumo']) || 
       empty($_POST['corpo'])  ||
       empty($_POST['id'])){

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos para alterar vazios.'
        ];
    }else{

        try{
            $sql = "UPDATE NOTICIA SET TITULO = ?, RESUMO = ?, CORPO = ?, DATA = ? WHERE ID = ?";
            $stmt /*statement*/ = $pdo->prepare($sql); //prepare testa o sql conferindo se não há nenhum codigo malicioso
            $stmt -> execute([ //executa sql
                $_POST['titulo'],
                $_POST['resumo'],
                $_POST['corpo'],
                $dataAtual,
                $_POST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Registro atualizado com sucesso'
            ];
        }catch(PDOException $e){
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e -> getMessage()
            ];
        }

    }
}

if($_POST['operacao'] == 'delete'){

    if(empty($_POST['id'])){

        $dados = [
            'type' => 'error',
            'message' => 'ID não reconhecido ou inexistente'
        ];
    }else{
        try{
            $sql = "DELETE FROM NOTICIA WHERE ID = ?";
            $stmt /*statement*/ = $pdo->prepare($sql); //prepare testa o sql conferindo se não há nenhum codigo malicioso
            $stmt -> execute( $_POST['id']);
            $dados = [
                'type' => 'success',
                'message' => 'Registro deletado com sucesso'
            ];
        }catch(PDOException $e){
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e -> getMessage()
            ];
        }

    }
} 


echo json_encode($dados);

?>