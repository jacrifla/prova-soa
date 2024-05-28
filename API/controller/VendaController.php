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
            $data = $request->body();
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

    public function validateNumero(){

    }

    public function validateCliente(){

    }

    public function validateNegativo(){
        
    }

    public function validateDesconto(){

    }

    public function validateTotal(){

    }
}