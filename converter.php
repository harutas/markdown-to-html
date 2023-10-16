<?php
$data = file_get_contents(("php://input"));
$post_data = json_decode($data);

if ($post_data) {
  // markdownを取得
  $markdownString = $post_data->markdown;
  $isHighlight = $post_data->highlight;


  $command = "python python/main.py " . escapeshellarg($markdownString) . " " . escapeshellarg($isHighlight);

  exec($command, $output, $result_code);

  $html = "";
  foreach ($output as $line) {
    $html .= $line . "\n";
  }

  $response = array('html' => $html);

  echo json_encode($response);
} else {
  // データが不正な場合の処理
  echo json_encode(array('message' => 'POSTデータが不正です。'));
}
