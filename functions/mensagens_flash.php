<?php
@session_start();

if(isset($_SESSION["mensagens"])):

    foreach ($_SESSION["mensagens"] as $msg) {
        $mensagens[] = $msg;
    }

    unset($_SESSION["mensagens"]);

endif;