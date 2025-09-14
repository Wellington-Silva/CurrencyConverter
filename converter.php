<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conversor de moeda</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <h1>Conversor de Real para Dolar</h1>

        <?php 

        $initial = date("m-d-Y", strtotime("-7 days"));
        $end = date("m-d-Y");

        $url = 'https://olinda.bcb.gov.br/olinda/servico/PTAX/versao/v1/odata/CotacaoDolarPeriodo(dataInicial=@dataInicial,dataFinalCotacao=@dataFinalCotacao)?@dataInicial=\''. $initial .'\'&@dataFinalCotacao=\''. $end .'\'&$top=1&$orderby=dataHoraCotacao%20desc&$format=json&$select=cotacaoCompra,dataHoraCotacao';
        
        $data =  json_decode(file_get_contents($url), true);

        $cotacao = $data["value"][0]["cotacaoCompra"];

        $real = $_REQUEST["din"] ?? 0;
        $dolar = $real / $cotacao;

        $padrao = numfmt_create("pt_BR", NumberFormatter::CURRENCY);

        echo "<p>Seus ". numfmt_format_currency($padrao, $real, "BRL") 
        . " equivalem a <strong> " . numfmt_format_currency($padrao, $dolar, "USD") . "</strong></p>";
        ?>
        <p><a href="javascript:history.go(-1)">Voltar</a></p>
    </main>
</body>
</html>