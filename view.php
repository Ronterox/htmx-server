<?php

function view($file, $block = 'all', $data = [])
{
    $path = __DIR__ . '/html/' . $file;
    $cache = __DIR__ . '/cache/' . md5($file . $block) . '.php';

    extract($data);
    if (file_exists($cache) && filemtime($cache) > filemtime($path)) {
        require $cache;
        return;
    }

    $file = file_get_contents($path);
    $file = preg_replace('/{{\s*(.*?)\s*}}/', '<?php echo $1; ?>', $file);
    $matches = preg_match_all('/@block\s+(.*?)\s+(.*?)\s+@end/s', $file, $blocks);

    if ($matches > 0) {
        $blocks = array_combine($blocks[1], $blocks[2]);

        if (key_exists($block, $blocks)) {
            $file = $blocks[$block];
        } else {
            $file = preg_replace('/@block\s+(.*?)\s+(.*?)\s+@end/s', '', $file);
            foreach ($blocks as $name => $content) {
                $file = str_replace("@render {$name}", $content, $file);
            }
        }
    }

    @mkdir(__DIR__ . '/cache');
    file_put_contents($cache, $file);

    require $cache;
}

