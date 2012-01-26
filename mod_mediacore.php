<?php
//don't allow other scripts to grab and execute our file
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
$api_url = $params->get('apiurl', '');
$api_key = $params->get('apikey', '');
$items = $params->get('items', 4);
$showtitle = $params->get('showtitle', 1);
$titlelength = $params->get('titlelength', 50);
$showthumb = $params->get('showthumb', 1);
$showdesc = $params->get('showdesc', 1);
$desclength = $params->get('desclength', 180);
$linkdest = $params->get('linkdest', '');


function fetch_media_list($data, $api_url, $api_key) {

  $data['api_key'] = $api_key;
  $uri = $api_url . '?' . http_build_query($data);
  return json_decode(file_get_contents($uri));
}

function truncate($text, $lenght) {
  if($lenght == 0) {
    return '';
  }
    
  if (strlen($text) > $lenght) {
    $left = 0;
    $right = strrpos(substr($text, 0, $lenght - 1), ' ');
    $text = substr($text, $left, $right) . '&hellip;';
  }
  return $text;
}

$result = fetch_media_list(array('type' => 'video', 'limit' => $items), $api_url, $api_key);
$videos = $result->media;
?>

<?php foreach ($videos as $video): ?>
<div class="mcvideo">
  <?php if($showthumb || $showtitle): ?>
  <a href="<?php echo $video->url;?>" class="mclink" target="<?php echo $linkdest; ?>">
    <?php if($showthumb): ?>
      <img src="<?php echo $video->thumbs->m-> url;?>" alt="<?php echo $video->title; ?>" /> 
    <?php endif ?>
    <?php if($showtitle) : ?>
      <h4 class="mctitle">
        <?php echo truncate($video->title, $titlelength); ?>
      </h4>
    <?php endif ?>
  </a>
  <?php endif ?>
   <?php if($excerpt_length > 0):?>
    <p class="mcdescription"><?php echo truncate($video->description_plain, $desclength);?></p>
   <?php endif ?>
</div>
<?php endforeach?>