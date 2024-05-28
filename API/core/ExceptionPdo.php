<?php

    class ExceptionPdo{

        public static function translateError($error){
            if(empty($error) || is_array($error)){
                return 'Error unknown';
            }

            if(strpos($error, 'does not exist') != false){
                if(strpos($error, 'relation') != false){
                    return 'Table not found';
                }else if(strpos($error, 'database') != false){
                    return 'Database not found';
                }
            } else if(strpos($error, 'does not exist') != false){
                return 'Host not found';
            } else if(strpos($error, 'does not exist') != false){
                return 'Syntax error sql';
            } else if(strpos($error, 'does not exist') != false){
                return 'Credentials fail';
            } else{
                return 'Internal error';
            }
        }


    }