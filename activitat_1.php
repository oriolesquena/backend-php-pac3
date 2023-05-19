<?php

$jsonData = file_get_contents('./posts/post_1.json');
$data = json_decode($jsonData);

print_r($data->title);
print_r($data->description);

?>