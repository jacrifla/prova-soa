<?php

require_once './core/Request.php';
require_once './core/Response.php';
require_once './model/VendaModel.php';

class VendaController{

    public function show(Request $request, Response $response){
        try{
            $data = VendaModel::show();

            if($data){
                $response::json([
                    'status' => 'success',
                    'dados' => $data
                ], 200);
            }else{
                $response::json([
                    'status' => 'error',
                    'dados' => []
                ], 404);
            }
        }catch (\Exception $e){
            $response::json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function find(Request $request, Response $response, array $url){
        try{
            $data = VendaModel::find($url[0]);

            if($data){
                $response::json([
                    'status' => 'success',
                    'dados' => $data
                ], 200);
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => 'Not found'
                ], 404);
            }
        }catch (\Exception $e){
            $response::json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }

    }

    public function insert(Request $request, Response $response){
        try{
            $data    = $request->body();

            $valido  = $this->camposObrigatorios($data, true);

            if($valido){
                if($this->camposVazios($data)){
                    $success = VendaModel::insert($data);
                    if($success){
                        $data['id'] = VendaModel::lastInsertId();
                        $response::json([
                            'status' => 'success',
                            'dados' => $data
                        ], 201);
                    }else{
                        $response::json([
                            'status' => 'error',
                            'msg' => 'Internal Error'
                        ], 500);
                    }

                    else{
                        $response::json([
                            'status' => 'error',
                            'msg' => 'Preencha os valores'
                        ], 406);
                    }
               
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => 'Todos os campos são obrigatórios.'
                ], 406);
            }

            
        }catch (\Exception $e){
            $response::json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, Response $response){
        try{
            $data = $request->body();
            $success = VendaModel::update($data);

            if($success){
                $response::json([
                    'status' => 'success',
                    'dados' => $data
                ], 201);
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => 'Internal Error'
                ], 500);
            }
        }catch (\Exception $e){
            $response::json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }

    }

    public function delete(Request $request, Response $response, array $url){
        try{
            $data = VendaModel::delete($url[0]);

            if($data){
                $response::json([
                    'status' => 'success',
                    'dados' => $data
                ], 200);
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => 'Not found'
                ], 404);
            }
        }catch (\Exception $e){
            $response::json([
                'status' => 'error',
                'msg' => $e->getMessage()
            ], 500);
        }
    }

    public function camposObrigatorios($campos, $insercao){

        $campos_obrigatorios = ['cliente', 'sub_total', 'desconto','acrescimo','total'];
        if(!$insercao){
            array_push($campos_obrigatorios, "id_venda");
        }

        foreach ($campos_obrigatorios as $campo) {
            if (!array_key_exists($campo, $campos)) {
                return false; // Faltam campos obrigatórios
            }
        }

        return true;

    }

    public function camposVazios($campos){

        foreach ($campos as $campo) {
            if ($campo == NULL) {
                return false; // Faltam campos preenchidos
            }
        }

        return true;

    }

    public function validateNumero($dado){

    }

    public function validateCliente($dado){

    }

    public function validateNegativo($dado){
        
    }

    public function validateDesconto($dado){

    }

    public function validateTotal($dado){

    }
}