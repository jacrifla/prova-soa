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

            if(is_numeric($url[0])){
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
        }else{
            $response::json([
                'status' => 'error',
                'msg' => 'O id deve ser numerico'
            ], 500);

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
            $valido  = $this->validateAll($data, true);
            if($valido == 'sucesso'){                   
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
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => $valido
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
            $valido  = $this->validateAll($data, false);
            if($valido == 'sucesso'){    
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
            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => $valido
                ], 406);
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
            if(is_numeric($url[0])){
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

            }else{
                $response::json([
                    'status' => 'error',
                    'msg' => 'O id deve ser numerico'
                ], 500);
              
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
            if(is_numeric($campo) && (floatval($campo) < 0)){
                return false;
            }
        }

        return true;

    }

    public function validateCliente($dado){
        if(strlen($dado) > 3){
            return true;
        }

        return false;

    }

    public function validateDesconto($desconto, $subtotal){
        if($desconto < $subtotal){
            return true;
        }
        return false;
    }

    public function validateTotal($total, $subtotal, $acrescimo, $desconto){
        if($total == (($subtotal+$acrescimo)- $desconto)){
            return true;
        }

        return false;

    }

    public function validateAll($data, $insercao){

        if($this->camposObrigatorios($data, $insercao)){
            if($this->camposVazios($data)){
                if(!$this->validateCliente($data['cliente'])){
                    return 'O nome do cliente deve conter mais de 3 caracteres';
                }
                $desconto    = floatval($data['desconto']);
                $subtotal    = floatval($data['sub_total']);
                $acrescimo   = floatval($data['acrescimo']);
                $total       = floatval($data['total']);
                if($this->validateDesconto($desconto, $subtotal)){
                    if($this->validateTotal($total, $subtotal, $acrescimo, $desconto)){
                        return 'sucesso';
                    }else{
                        return 'Total não corresponde ao valor da venda';
                    }
                }else{
                    return 'Desconto não pode ser maior que o sub total';
                }
            }else{
                return 'Os campos devem estar preenchidos corretamente';
            }
        }else{
            return 'Todos os campos são obrigatórios';
        }

    }
}