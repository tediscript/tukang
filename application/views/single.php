<?php
$title = $post->post_title;
$t = explode(" ", $title);
$titleplus = implode("+", $t);
$titlemin = implode("-", $t);
$key = "ABQIAAAAQiyrUtXN3XgjBRs0Im0c5RSQ57hx2fAFgsS909yS8p9LnqD54BQNLzTFAnwgza9pHuByZEVOdbBUrw";
$url = "https://ajax.googleapis.com/ajax/services/search/images?v=1.0&q=" . $titleplus . "&key=" . $key . "&as_filetype=jpg&rsz=8&start=0&imgsz=xxlarge";
$blogurl = get_bloginfo('home');
$imgpath = $_SERVER['DOCUMENT_ROOT'] . '/pictures/' . $titlemin . '-1.jpg';
global $wpdb;
if (file_exists($imgpath)) {
    ?>
    <div style="text-align:center;margin:10px 0 10px 0;">

    </div>
    <?php
    $sources = $wpdb->get_results("SELECT source FROM `wp_images` WHERE slug = '$titlemin'");
    $counts = count($sources);
    $countdown = count($sources);
    foreach ($sources as $source) {
        ?>
        <div style="text-align:center;margin-bottom:10px;">
            <img src="<?php echo $blogurl ?>/pictures/<?php echo $titlemin ?>-<?php echo $counts-- ?>.jpg" width="560" title="<?php echo $title ?>" alt="<?php echo $title ?>" /> <small><a href="<?php echo $blogurl ?>/pictures/<?php echo $titlemin ?>-<?php echo $countdown-- ?>.jpg" target="_blank">Download <?php echo $title ?> Wallpaper</a> |<a href="http://www.racingpic.com/goto/<?php echo $source->source ?>" rel="nofollow" target="_blank">Picture source</a></small>
        </div>
    <?php } ?>
    <div style="text-align:center;margin:10px 0 10px 0;">
    </div>
<?php
} else {
    // sendRequest
    // note how referer is set manually
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040608');
    curl_setopt($ch, CURLOPT_REFERER, "http://www.racingpic.com/");
    $body = curl_exec($ch);
    curl_close($ch);

    // now, process the JSON string
    $json = json_decode($body, true);
    // now have some fun with the results...
    $pics = $json['responseData']['results'];
    $count = count($pics);
    $countdb = $count;

    function save_image($inPath, $outPath) {
        //Download images from remote server
        $in = fopen($inPath, "rb");
        $out = fopen($outPath, "wb");
        while ($chunk = fread($in, 8192)) {
            fwrite($out, $chunk, 8192);
        }
        fclose($in);
        fclose($out);
    }

    foreach ($pics as $pic) {
        save_image($pic['unescapedUrl'], $_SERVER['DOCUMENT_ROOT'] . '/pictures/' . $titlemin . '-' . $count-- . '.jpg');
        //create database table wp_images
        //field = name, source, slug (varchar)
        $wpdb->insert('wp_images', array('name' => $titlemin . '-' . $countdb--, 'source' => $pic['originalContextUrl'], 'slug' => $titlemin), array('%s', '%s'));
    }
    ?>
    <script type="text/javascript">
        window.location = "<?php the_permalink(); ?>"
    </script>
<?php } ?>