<html lang="pl">
  <head>
    <title>Notatnik</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css">
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"> -->
     <!-- Link to other fonthawsome -->
    <link href="/public/style.css" rel="stylesheet">
  </head>
  <body class="body">
    <div class="wrapper">
      <div class="header">
        <h1><i class="far fa-clipboard"></i>Moje notatki</h1>
      </div>

      <div class="container">
        <div class="menu">
          <ul>
            <li><a href="/">Strona główna</a></li>
            <li><a href="/?action=create">Nowa notatka</a></li>
          </ul>
        </div>
        <div class="page">
          <?php require_once("templates/pages/$page.php"); ?>
        </div>
      </div>
    <div class="footer">
      <p>Notatki - projekt w kursie PHP</p>
    </div>
  </div>
</body>
</html>
