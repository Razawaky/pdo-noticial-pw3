<?php

include ('../connection/conn.php');

// date_default_timezone_set('America/Sao_Paulo');
// $dataAtual = date('Y-m-d H:i:s', time()); //setei o horario e dia padrão, ent estrá já automatico a data


//request mesma função do REQUEST e get, mas ele ouve os dois
if($_REQUEST['operacao'] == 'create'){

    if(empty($_REQUEST['nome']) || 
       empty($_REQUEST['login']) || 
       empty($_REQUEST['senha'])){

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos obrigatórios vazios.'
        ];
    }else{

        try{
            $sql = "INSERT INTO AUTOR (NOME, LOGIN, SENHA) VALUES (?,?,?)";
            $stmt /*statement*/ = $pdo->prepare($sql); //prepare testa o sql conferindo se não há nenhum codigo malicioso
            $stmt -> execute([ //executa sql
                $_REQUEST['nome'],
                $_REQUEST['login'],
                $_REQUEST['senha']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Cadastro do autor salvo com sucesso'
            ];
        }catch(PDOException $e){
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e -> getMessage()
            ];
        }

    }
}

if($_REQUEST['operacao'] == 'read'){
    try{

        $sql = "SELECT * FROM AUTOR";
        $resultado = $pdo->query($sql); //recebe a query dos valores do banco
        while($row = $resultado->fetch(PDO::FETCH_ASSOC)){ //while pra varrer o banco linha por linha usando o FETCH e o row vai ler linha por linha do banco
            $dados[] = array_map(null, $row); //array pra mapear os dados, recebe 2 parametros
        }

    }catch(PDOException $e){
        $dados = [
            'type' => 'error',
            'message' => 'Erro de consulta: ' . $e -> getMessage()
        ];
    }
}

if($_REQUEST['operacao'] == 'update'){

    if(empty($_REQUEST['nome']) || 
       empty($_REQUEST['login']) || 
       empty($_REQUEST['senha'])  ||
       empty($_REQUEST['id'])){

        $dados = [
            'type' => 'error',
            'message' => 'Existem campos para alterar vazios.'
        ];
    }else{

        try{
            $sql = "UPDATE AUTOR SET NOME = ?, LOGIN = ?, SENHA = ? WHERE ID = ?";
            $stmt /*statement*/ = $pdo->prepare($sql); //prepare testa o sql conferindo se não há nenhum codigo malicioso
            $stmt -> execute([ //executa sql
                $_REQUEST['nome'],
                $_REQUEST['login'],
                $_REQUEST['senha'],
                $_REQUEST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Registro do autor atualizado com sucesso'
            ];
        }catch(PDOException $e){
            $dados = [
                'type' => 'error',
                'message' => 'Erro: ' . $e -> getMessage()
            ];
        }

    }
}

if($_REQUEST['operacao'] == 'delete'){

    if(empty($_REQUEST['id'])){

        $dados = [
            'type' => 'error',
            'message' => 'ID do autor não reconhecido ou inexistente'
        ];
    }else{

        try{
            $sql = "DELETE FROM AUTOR WHERE ID = ?";
            $stmt /*statement*/ = $pdo->prepare($sql); //prepare testa o sql conferindo se não há nenhum codigo malicioso
            $stmt -> execute([ //executa sql
                $_REQUEST['id']
            ]);
            $dados = [
                'type' => 'success',
                'message' => 'Autor deletado com sucesso'
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