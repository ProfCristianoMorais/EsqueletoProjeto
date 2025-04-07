<?php
//esse arquivo só serve para testar se o mpdf está funcionando certinho!
require_once 'C:/xampp/htdocs/projetoETC_V02/vendor/autoload.php';
echo class_exists('\\Mpdf\\Mpdf') ? 'mPDF OK!' : 'Erro!';