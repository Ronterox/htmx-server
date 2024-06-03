<?php

function view($file, $data = []) {
    $path = __DIR__ . '/html/' . $file;
    $cache = __DIR__ . '/cache/' . md5($file) . '.php';

    extract($data);
    $file = file_get_contents($path);
    $file = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo $1; ?>', $file);

    @mkdir(__DIR__ . '/cache');
    file_put_contents($cache, $file);

    require $cache;
}

view('index.html', ['count' => '1']);

?>
