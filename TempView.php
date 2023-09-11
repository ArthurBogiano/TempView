<?php

# nome do arquivo que esta sendo executado
$exe = basename($_SERVER['PHP_SELF']);

if (isset($_GET['img']) && isset($_GET['mime'])) {

    $img = $_GET['img'];
    $mime = $_GET['mime'];

    $ext = explode('/', $mime);
    $ext = $ext[1];

    // header('Content-Description: File Transfer');
    // header('Content-Type: application/octet-stream');
    // header('Content-Disposition: attachment; filename=' . basename($img).'.'.$ext);

    // readfile($img);

    header('Content-Type: ' . $mime);
    echo file_get_contents($img);

    exit;

}

if (isset($_GET['file']) && isset($_GET['mime'])) {

    $file = $_GET['file'];
    $mime = $_GET['mime'];

    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));

    readfile($file);

    exit;

}

if (isset($_GET['pasta'])) {

    $pasta = $_GET['pasta'];

} else {

    $pasta = '/tmp';

}

echo "Listando arquivos da pasta $pasta<br>";

$files = scandir($pasta);

foreach ($files as $file) {

    // identifica se é um arquivo ou pasta
    if (is_dir($pasta . '/' . $file)) {

        echo "<a href='$exe?pasta=$pasta/$file'>$file</a><br>";

    } else {

        // identifica o mimetype do arquivo
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimetype = finfo_file($finfo, $pasta . '/' . $file);
        finfo_close($finfo);

        if (substr($mimetype, 0, 5) == 'image') {

            echo "<a href='$exe?file=$pasta/$file&mime=$mimetype'>$file</a> - $mimetype<br>";

        } else {

            echo "<a href='$exe?file=$pasta/$file&mime=$mimetype'>$file</a><br>";

        }

    }

}