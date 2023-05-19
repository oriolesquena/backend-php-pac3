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
    <title>Consciència Ambiental</title>
  </head>
<body>

<?php

$id = 0;
$numwords = 120;

function truncateWords($input, $numwords, $padding="") {
    $output = strtok($input, " \n");
    while(--$numwords > 0) $output .= " " . strtok(" \n");
    if($output != $input) $output .= $padding;
    return $output;
}

$files = scandir('./posts/');
foreach($files as $file) {

    /* S'afegeix el següent 'if' ja que sinó la funció scandir retorna 
       també '.' i '..' que són el mateix directori i el directori pare */
    if (substr($file, 0, 1) != '.') {

        $id = $id + 1;
        $link = 'post.php?id=' . $id;
        $jsonData = file_get_contents('./posts/' . $file);
        $data = json_decode($jsonData);
        ?>
        <ul>
            <li>
                <h1><a href="<?php print $link ?>"><?php print_r($data->title->ca);?></a></h1>
                <p><?php print date("d/m/Y", $data->date);?></p>
                <p><?php print truncateWords($data->description->ca, $numwords, '...');?></p>
                <img class="bloc" src="<?php print_r($data->image);?>">
            </li>
        </ul>
        <hr><?php
    }
}

?>

</body>
</html>
