<?php

function pegarEstado($numero_do_estado){

    if($numero_do_estado == '0'):
        return "cancelado";
    endif;

    if($numero_do_estado == '1'):
        return "pendente";
    endif;

    if($numero_do_estado == '2'):
        return "processando";
    endif;

    if($numero_do_estado == '3'):
        return "completado";
    endif;

}