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
    session_start(); // Necessari per poder utilitzar la funció isset() més avall

    // Declarar variables
    $id = 0;
    $numwords = 120;
    if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
        $_SESSION["lang"] = $lang;
    } else if (isset($_SESSION["lang"])) {
        $lang = $_SESSION["lang"];
    } else {
        $lang = 'ca'; // Idioma per defecte
    }
    $order = 'desc';
    $sort = 'date';
    $arrayPosts = array();

    $jsonMenu = file_get_contents('./menu.json');
    $menu = json_decode($jsonMenu);
    ?>
    <nav>
        <ul class="primary-menu">
            <li><a href="bloc.php"><?php print_r($menu->home->$lang);?></a></li>
            <li><a href="activitat_1.php"><?php print_r($menu->act1->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->api->$lang);?></a></li>
            <li><strong><a href="login.php"><?php print_r($menu->login->$lang);?></a></strong></li>
            <li><a href=""><?php print_r($menu->profile->$lang);?></a></li>
            <li><a href=""><?php print_r($menu->logout->$lang);?></a></li>
        </ul>
        <ul class="lang-selector">
            <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
            <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
        </ul>
    </nav>
    <main>
        <form action="handleForm" method="get">
            <div>
                <label for="usr">
                <span><?php if ($lang=='ca') {
                    print "Usuari";
                } else {
                    print "User";
                }
                ?></span>
                <strong><span aria-label="required">*</span></strong>
            </label>
            <input
                class="input-text"
                type="text"
                id="usr"
                name="username"
                pattern="[a-zA-Z &#39;-]{2,64}"
                required
            />
            </div>
            <div>
                <label for="pwd">
                    <span><?php if ($lang=='ca') {
                    print "Contrasenya";
                } else {
                    print "Password";
                }
                ?></span>
                    <strong><span aria-label="required">*</span></strong>
                </label>
                <input 
                    type="password"
                    id="pwd"
                    name="password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                    required
                />
            </div>
            <div class="button">
                <button type="submit" name="submit"><?php if ($lang=='ca') {
                    print "Entra";
                } else {
                    print "Log in";
                }
                ?></button>
            </div>
        </form>

        <?php 
        function handleForm() {
            $jsonUsers = file_get_contents('./users.json');
            $users = json_decode($jsonUsers);

            if (isset( $_GET['submit'])) { 
                $username = $_GET['username']; 
                $password = $_GET['password']; 
            }
            if ($username == $users->username && $password == $users->password) {
                $login = $_SESSION['login'];
            }
        }
        ?>
    </main>

</body>
</html>
