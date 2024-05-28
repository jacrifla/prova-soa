<?php

require_once './core/ConnectionDB.php';
require_once './core/ExceptionPdo.php';

class VendaModel{

    public static function show(){
        try{
            $pdo = ConnectionDB::getInstance();
            $stmt = $pdo->prepare('SELECT * FROM tb_venda ORDER BY id_venda');
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function find(int $code){
        try{
            $pdo = ConnectionDB::getInstance();
            $stmt = $pdo->prepare('SELECT * FROM tb_venda WHERE id_venda = ?');
            // o ? é um meio de parametrizar e evitar sql injections, não é seguro concatenar
            //ele saberá qual variável está sendo utilizada pois é passada no metodo execute como parametro
            $stmt->execute([$code]);

            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }

    public static function insert(array $data){

        try{
            $pdo = ConnectionDB::getInstance();
            $stmt = $pdo->prepare('INSERT INTO tb_venda (cliente, sub_total, desconto, acrescimo, total) VALUES(?,?,?,?,?)');
            // o ? é um meio de parametrizar e evitar sql injections, não é seguro concatenar
            //ele saberá qual variável está sendo utilizada pois é passada no metodo execute como parametro
            $stmt->execute([$data['cliente'], $data['sub_total'], $data['desconto'], $data['acrescimo'], $data['total']]);

            return ($stmt->rowCount() > 0);
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    public static function update(array $data){

        try{
            $pdo = ConnectionDB::getInstance();
            $stmt = $pdo->prepare('UPDATE tb_venda SET cliente = ?, sub_total = ? , desconto = ? , acrescimo = ? , total = ? WHERE id_venda = ?');
            // o ? é um meio de parametrizar e evitar sql injections, não é seguro concatenar
            //ele saberá qual variável está sendo utilizada pois é passada no metodo execute como parametro
            $stmt->execute([$data['cliente'], $data['sub_total'], $data['desconto'], $data['acrescimo'], $data['total'], $data['id_venda']]);

            return ($stmt->rowCount() > 0);
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }

    public static function delete(int $code){

        try{
            $pdo = ConnectionDB::getInstance();
            $stmt = $pdo->prepare('DELETE FROM tb_venda WHERE id_venda = ?');
            // o ? é um meio de parametrizar e evitar sql injections, não é seguro concatenar
            //ele saberá qual variável está sendo utilizada pois é passada no metodo execute como parametro
            $stmt->execute([$code]);

            return ($stmt->rowCount() > 0);
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }

    public static function lastInsertId(){

        try{
            $pdo = ConnectionDB::getInstance();
            
            return $pdo->lastInsertId();
        }catch(\PDOException $e){
            throw new \Exception(ExceptionPdo::translateError($e->getMessage()));
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }

    }

    


}