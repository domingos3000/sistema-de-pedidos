<?php

require_once __DIR__ . './components/connect.php';
require_once __DIR__ . './vendor/autoload.php';

$idPedido =  isset($_GET['idPedido']) ? $_GET['idPedido'] : false;

if(!$idPedido) return;

$stmt = $conn->prepare("SELECT * FROM pedidos WHERE id = ? LIMIT 1");
$stmt->execute([$idPedido]);

if($stmt->rowCount() > 0){
    $dados = $stmt->fetch(PDO::FETCH_ASSOC);
    $dadosPedido = json_decode($dados['total_produtos'], true);

} else {
    header('location: ./pedido.php');
    return false;
}

$dadosHTML = '';

foreach ($dadosPedido as $dado) {
    $dadosHTML .= 
    "
        <tr>
            <td> " . $dado['pedido']['nome'] . "</td>" .
            "<td class='inline-center'>" . $dado['pedido']['qntd'] . "</td>" .
            "<td class='inline-right'>" . number_format($dado['pedido']['preco'], 2, ',', '.') . " KZ</td>" .
            "<td class='inline-right'>" .
                number_format($dado['pedido']['subtotal'], 2, ',', '.') . " KZ
            </td>
        </tr>
    ";
}

$total_geral = number_format($dados['total_preço'], 2, ',', '.');

// PDF

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$html = file_get_contents("./components/pdf-page-generator/comprovativo-text.html"); 
$dompdf->loadHtml("
    <!DOCTYPE html>
    <html lang='pt'>
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

            .col-total {
                background-color: rgba(0,0,0, 0.8);
                font-weight: 700;
                color: #fff;
                text-transform: uppercase;
            }

            .inline-right {
                text-align: right;
            }

            .inline-center {
                text-align: center;
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
                            {$dados['nome']}
                        </div>
                    </li>

                    <li>
                        <div>Email do cliente:</div>
                        <div>
                            {$dados['email']}
                        </div>
                    </li>

                    <li>
                        <div>Metódo de pagamento:</div>
                        <div>
                            {$dados['metodo']}
                        </div>
                    </li>

                    <li>
                        <div>Endereço</div>
                        <div>
                            {$dados['endereço']}
                        </div>
                    </li>

                    <li>
                        <div>Data de emissão:</div>
                        <div>
                            {$dados['data']}
                        </div>
                    </li>

                </ul>
            </div>
            
            <table class='table'>
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th class='inline-center'>Quantidade</th>
                        <th class='inline-center'>Preço (unitário)</th>
                        <th class='inline-center'>Subtotal</th>
                    </tr>
                </thead>

                <tbody>
                $dadosHTML
                <tr>
                        <td colspan='3' class='col-total'>
                            Total
                        </td>
                        <td class='inline-right'>
                            $total_geral KZ
                        </td>
                </tr>
                </tbody>

            </table>
        </div>
        
    </body>
    </html>
");

$random_number = rand(2222, 9999);

$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream("comprovativo_$random_number", array("Attachment" => 1));