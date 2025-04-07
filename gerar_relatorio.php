<?php

//Estou utilizando essa biblioteca https://mpdf.github.io/

include './config/config.php';
// Caminho ABSOLUTO para o autoload (ou seja: Exatamente o caminho que está o arquivo autoload.php instalado via composer)
require_once 'C:/xampp/htdocs/projetoETC_V02/vendor/autoload.php';

session_start();

//Vamos aqui setar o horário correto que pretendemos usar, assim como fizemos no nosso primeiro exemplo de aula
date_default_timezone_set('America/Sao_Paulo'); 

// Verificação de classe MPDF
if (!class_exists('\\Mpdf\\Mpdf')) {
    die("Erro: Bibliotecas do mPDF não carregadas!");
}

// Verifica autenticação
if (!isset($_SESSION['usuario'])) {
    header('Location: login.php');
    exit;
}

// Tipos permitidos
$tipos_permitidos = ['usuarios', 'clientes', 'produtos'];
$tipo = $_GET['tipo'] ?? '';

if (!in_array($tipo, $tipos_permitidos)) {
    die('Tipo de relatório inválido!');
}

// Configuração do mPDF
$mpdf = new \Mpdf\Mpdf([
    'mode' => 'utf-8',
    'format' => 'A4',
    'margin_top' => 25,
    'tempDir' => __DIR__ . '/tmp'
]);

// Aqui é a consulta que será feita no banco e será jogada para o PDF
try {
    global $pdo; // Certifique-se que $pdo está disponível
    
    switch ($tipo) {
        case 'usuarios':
            $sql = "SELECT id, nome, email, perfil, 
                    DATE_FORMAT(data_cadastro, '%d/%m/%Y %H:%i') as cadastro 
                    FROM usuarios";
            break;
            
        case 'clientes':
            $sql = "SELECT id, nome, email, telefone, endereco, 
                    DATE_FORMAT(data_cadastro, '%d/%m/%Y %H:%i') as cadastro 
                    FROM clientes";
            break;
            
        case 'produtos':
            $sql = "SELECT id, nome, 
                    FORMAT(preco, 2, 'pt_BR') as preco, 
                    estoque, 
                    DATE_FORMAT(data_cadastro, '%d/%m/%Y %H:%i') as cadastro 
                    FROM produtos";
            break;
    }

    $stmt = $pdo->query($sql);
    $dados = $stmt->fetchAll(PDO::FETCH_ASSOC);

    /**Formatação de como queremos nosso relatório
     * nesse caso utilizamos html para fazer a formatação.
     * lembrando que cada um pode configurar do jeito que quiser a saída do relatório OK?
    */
    
    $html = '
    <style>
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #0066cc; padding-bottom: 15px; }
        .logo {width: 150px; margin-bottom: 10px;}
        table { width: 100%; border-collapse: collapse; }
        th { background-color: #0066cc; color: white; padding: 10px; }
        td { padding: 8px; border: 1px solid #ddd; }
        .header { text-align: center; margin-bottom: 20px; }
    </style>
    
        <div class="header">
            <img src="'.__DIR__.'./assets/img/logo.png" class="logo">
            <h1 class="titulo">Relatório de '.ucfirst($tipo).'</h1>
            <div class="info-geracao">
                <small>Gerado em: '.date('d/m/Y H:i:s').'</small><br>
                <small>Por: '.$_SESSION['usuario']['nome'].'</small>
            </div>
        </div>
    
    <table>
        <tr>';
    
    foreach ($dados[0] as $chave => $valor) {
        $html .= '<th>'.ucwords(str_replace('_', ' ', $chave)).'</th>';
    }
    $html .= '</tr>';
    
    foreach ($dados as $linha) {
        $html .= '<tr>';
        foreach ($linha as $valor) {
            $html .= '<td>'.$valor.'</td>';
        }
        $html .= '</tr>';
    }
    
    $html .= '</table>';
    
    $mpdf->WriteHTML($html);
    $mpdf->Output();

} catch (Exception $e) {
    die("Erro: ".$e->getMessage());
}