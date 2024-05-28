<?php

require_once 'Http.php';

Http::get('/venda', 'VendaController@show');
Http::get('/venda/find/{id}', 'VendaController@find');
Http::post('/venda/add', 'VendaController@insert');
Http::put('/venda/edit', 'VendaController@update');
Http::delete('/venda/delete/{id}', 'VendaController@delete');