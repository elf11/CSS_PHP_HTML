<!DOCTYPE html>
<html>
<head>
    <title>Un blog misto</title>
    <meta name="description" content="Pagina unui blog de comentarii">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8">
    <link href='http://fonts.googleapis.com/css?family=Vollkorn' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="style1.css"/>
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <script type="text/javascript" src="script.js"></script>
</head>
<body class="center">
<header class="giveColor headerClass">
    <h1><a>Messaging like a boss</a></h1>
    <h2>Messages, messages everywhere!</h2>
</header>

<header>
    <nav>
        <ul>
            <li><a href="comments.html">Home</a></li>
            <li><a href="page1.php?id=1">Pagina 1</a></li>
            <li><a href="page2.php?id=2">Pagina 2</a></li>
        </ul>
    </nav>
</header>

<article class="giveColor lotsSpace">
    <section id="mesList">
        <div id="mesListHere">
        </div>
    </section>


    <article>
    <section id="comentariu">
        <? include("formcode.php"); ?>
    </section>
    </article>
</article>
<footer class="giveColor lotsSpace">
    <p>Copyright &copy; 2014 <strong>Messages</strong>. Ma gasiti la adresa <a href="mailto:oana@cs.ro">oana arond cs punct ro</a></p>
</footer>
</body>
</html>