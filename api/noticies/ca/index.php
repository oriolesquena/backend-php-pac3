<?php

$files = scandir('../../../posts/');
foreach($files as $file) {
    if (substr($file, 0, 1) != '.') {
        $jsonData = file_get_contents('../../../posts/' . $file);
        $data = json_decode($jsonData);
        $arrayPosts[] = array("title" => $data->title->ca, "description" => $data->description->ca, "date" => $data->date, "image" => $data->image);
    }
}

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

echo json_encode($arrayPosts);
exit();

?>