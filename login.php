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
    if (isset($_GET["lang"])) {
        $lang = $_GET["lang"];
        $_SESSION["lang"] = $lang;
    } else if (isset($_SESSION["lang"])) {
        $lang = $_SESSION["lang"];
    } else {
        $lang = 'ca'; // Idioma per defecte
    }

    if (isset($_SESSION["error"])) {
        $error = $_SESSION["error"];
    } else {
        $error = false;
    }

    $jsonMenu = file_get_contents('./menu.json');
    $menu = json_decode($jsonMenu);
    ?>
    <nav>
        <ul class="primary-menu">
            <li><a href="bloc.php"><?php print_r($menu->home->$lang);?></a></li>
            <li><a href="activitat_1.php"><?php print_r($menu->act1->$lang);?></a></li>
            <li><a href="./api/noticies/en"><?php print_r($menu->api->$lang);?></a></li>
            <li><strong><a href="login.php"><?php print_r($menu->login->$lang);?></a></strong></li>
        </ul>
        <ul class="lang-selector">
            <li class="language"><a href="?lang=ca"><img class="flag" src="./img/ca.png" alt="Català"></a></li>
            <li class="language"><a href="?lang=en"><img class="flag" src="./img/en.png" alt="Anglès"></a></li>
        </ul>
    </nav>
    <main>
    <?php
        function handleForm() {
            $jsonUsers = file_get_contents('./users.json');
            $users = json_decode($jsonUsers);

            $username = $_POST['username']; 
            $password = $_POST['password']; 
            if ($username == $users->username && password_verify($password, $users->password)) {
                $_SESSION['login'] = true;
                $_SESSION['error'] = false;
                header("Location: ./bloc.php");
                exit();
            } else {
                $_SESSION['error'] = true;
                header("Location: ./login.php");
                exit();
            }
        }
    ?>

        <form action="login.php" method="post">
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
                    pattern="[a-zA-Z &#39;-]{8,64}"
                    required
                />
            </div>
            <div class="error-msg">
                <p><?php if ($error) {
                    if ($lang=='ca') {
                        print "Usuari i/o contrasenya incorrectes";
                    } else {
                        print "Wrong user and/or password";
                    }
                }
                ?>
                </p>
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
        if (isset($_POST['submit']))
            {
            handleForm();
            } 
        ?>

    </main>

</body>
</html>
