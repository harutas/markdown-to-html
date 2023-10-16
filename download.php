<?php
// Content-Typeをテキスト形式に設定
header('Content-Type: text/html');
header('Content-Disposition: attachment; filename="markdown.html"');

$data = file_get_contents(("php://input"));
$post_data = json_decode($data);

if ($post_data) {
  $htmlString = $post_data->html;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Markdown</title>
</head>

<body>
  <?php echo $htmlString; ?>
</body>

</html>