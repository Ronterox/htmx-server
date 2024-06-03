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
    $file = preg_replace('/{{\s*(.*?)\s*}}/', '<?= $1 ?>', $file);

    $block_pattern = '/@block\s+(.*?)\s+(.*?)\s+@end/s';
    $matches = preg_match_all($block_pattern, $file, $blocks);

    if ($matches > 0) {
        $blocks = array_combine($blocks[1], $blocks[2]);

        if (key_exists($block, $blocks)) {
            $file = $blocks[$block];
        } else {
            $file = preg_replace($block_pattern, '', $file);
            foreach ($blocks as $name => $content) {
                $file = str_replace("@render {$name}", $content, $file);
            }
        }
    }

    $foreach_pattern = '/@foreach\s+(.*?)\s+as\s+(.*?)\s+(.*?)\s+@end/s';
    $matches = preg_match_all($foreach_pattern, $file, $loops);
    $file = preg_replace($foreach_pattern, '<?php foreach($1 as $2) { extract($2); ?>$3<?php } ?>', $file);

    @mkdir(__DIR__ . '/cache');
    file_put_contents($cache, $file);

    require $cache;
}
