CREATE DATABASE soa

use soa

CREATE TABLE tb_venda (
    id_venda INT AUTO_INCREMENT,
    cliente VARCHAR(100),
    sub_total DECIMAL(15,2),
    desconto DECIMAL(15,2),
    acrescimo DECIMAL(15,2),
    total DECIMAL(15,2),
    PRIMARY KEY (id_venda)
);

