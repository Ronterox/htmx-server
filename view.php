<?php

function single_line($file)
{
    return preg_replace('/\s+/s', ' ', preg_replace('/[^\S ]+/s', '', $file));
}

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

    $foreach_pattern = '/@foreach\s+(.*?)\s+as\s+(.*?)\s+(.*?)\s+@endfor/s';
    $file = preg_replace($foreach_pattern, '<?php foreach($1 as $2) { extract($2); ?>$3<?php } ?>', $file);

    $block_pattern = '/@block\s+(.*?)\s+(.*?)\s+@endblock/s';
    $matches = preg_match_all($block_pattern, $file, $blocks);

    if ($matches > 0) {
        $blocks = array_combine($blocks[1], $blocks[2]);

        for ($i = 0; $i < 2; $i++) {
            foreach ($blocks as $name => $content) {
                $file = preg_replace("/@render \b{$name}\b/", $content, $file);
            }
        }

        if (key_exists($block, $blocks)) {
            preg_match("/@block\s+{$block}\s+(.*?)\s+@endblock/s", $file, $match);
            $file = $match[1];
        } else {
            $file = preg_replace($block_pattern, '', $file);
        }
    }

    @mkdir(__DIR__ . '/cache');
    file_put_contents($cache, single_line($file));

    require $cache;
}
