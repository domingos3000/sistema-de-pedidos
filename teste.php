<?php

require_once __DIR__ . './components/connect.php';
require_once __DIR__ . './vendor/autoload.php';

$idPedido = 'fb0342f3-6ea7-4f62-bcba-0b1ffa12d841'; //isset($_POST['idPedido']) ? $_POST['idPedido'] : false;
if(!$idPedido) return;

$stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = ? LIMIT 1");
$stmt->execute([$idPedido]);

if($stmt->rowCount() > 0){
    $dadosPedido = $stmt->fetchAll(PDO::FETCH_ASSOC);
    $dadosHTML = '';
}

foreach ($dadosPedido as $dado) {
    $dadosHTML .= "
        <tr>
            <td>{$dado['nome']}</td>
            <td>{$dado['total_preço']},00 kz</td>
        </tr>
    ";
}


// return;


use Dompdf\Dompdf;
$dompdf = new Dompdf();

$html = file_get_contents("./components/pdf-page-generator/comprovativo-text.html"); 
$dompdf->loadHtml("
<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>

    <link rel='preconnect' href='https://fonts.googleapis.com'>
    <link rel='preconnect' href='https://fonts.gstatic.com' crossorigin>
    <link href='https://fonts.googleapis.com/css2?family=Inter:wght@100;200;400;500;600;700&display=swap' rel='stylesheet'>

    <title>Comprovativo</title>

    <style>
        * {
            font-family: 'Inter', sans-serif;
            font-size: 16px;
            color: rgb(23, 26, 29);
        }

        body {
            max-width: 1120px;
            width: 100%;
        }

        li {
            list-style: none;
        }

        ul li > div:first-child {
            /* background-color: red; */
            color: rgb(42, 91, 136);
            font-weight: 700;
            text-transform: uppercase;
            font-size: 0.875rem;
        }

        ul li {
            margin-bottom: 0.5rem;
        }

        header h1 {
            text-align: center;
            font-size: 2rem;
        }

        table
        {
            border-collapse: collapse;
            min-width: 500px;
            width: fit-content;
            text-align: left;
            transform: translateX(-50%);
            left: 50%;
            position: relative;
        }

        table td,
        table th,
        table tr
        {
            padding: 0.5rem;
            border: 1px solid #000;
            font-size: 0.825rem;
            text-align: left;
        }
    </style>
</head>
<body>

       <div class='all-box'>
        <header class='header-title'>
            <h1>Comprovativo</h1>
        </header>

       
        <div class='info-important'>
            <ul>
                <li>
                    <div>Nome da empresa:</div>
                    <div>
                        Ramazani António & Pedro Mawete
                    </div>
                </li>

                <li>
                    <div>Nome do cliente:</div>
                    <div>
                        {$dado['nome']}
                    </div>
                </li>

                <li>
                    <div>Email do cliente:</div>
                    <div>
                        {$dado['email']}
                    </div>
                </li>

                <li>
                    <div>Metódo de pagamento:</div>
                    <div>
                        {$dado['metodo']}
                    </div>
                </li>

                <li>
                    <div>Endereço</div>
                    <div>
                        {$dado['endereço']}
                    </div>
                </li>

                <li>
                    <div>Data de emissão:</div>
                    <div>
                        {$dado['data']}
                    </div>
                </li>

            </ul>
        </div>
        
        <table class='table'>
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Preço</th>
                </tr>
            </thead>

            <tbody>
                $dadosHTML
            </tbody>

        </table>
    </div>
    
</body>
</html>
");

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("codexworld", array("Attachment" => 0));