<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width" />
    <meta name="author" content="Oriol Esquena" />
    <meta
      name="description"
      content="Lloc web creat com a exercici de la PAC3 de l'assignatura Desenvolupament Back-End
      amb PHP del màster Desenvolupament de Llocs i Aplicacions Web de la UOC. 
      S'hi troben notícies sobre consciència ambiental."
    />
    <link rel="stylesheet" type="text/css" href="./css/styles.css" />
    <title>Notícia de Consciència Ambiental</title>
  </head>
<body>

<?php

$id = $_GET["id"];

$jsonData = file_get_contents('./posts/post_' . $id . '.json');
$data = json_decode($jsonData);
?>
<ul>
    <li>
        <h1><?php print_r($data->title->ca);?></h1>
        <p><?php print date("d/m/Y", $data->date);?></p>
        <p><?php print_r($data->description->ca);?></p>
        <img class="post" src="<?php print_r($data->image);?>">
    </li>
</ul><?php

?>

</body>
</html>