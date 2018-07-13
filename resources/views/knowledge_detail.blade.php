<!DOCTYPE html>
<html lang="en">
<head>
    <title>Knowledge Base</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css"  href="css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="font-awesome-4.2.0/css/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/jasny-bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="css/animate.css">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Style the header */
        header {
            background-color: #666;
            padding: 30px;
            text-align: center;
            font-size: 35px;
            color: white;
        }

        /* Create two columns/boxes that floats next to each other */
        nav {
            float: left;
            width: 30%;
            height: 1100px; /* only for demonstration, should be removed */
            background: #ccc;
            padding: 20px;
        }

        /* Style the list inside the menu */
        nav ul {
            list-style-type: none;
            padding: 0;
        }

        article {
            float: left;
            padding: 20px;
            width: 70%;
            background-color: #f1f1f1;
            height: 1100px; /* only for demonstration, should be removed */
        }

        /* Clear floats after the columns */
        section:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Style the footer */
        footer {
            background-color: #777;
            padding: 40px;
            text-align: center;
            color: white;
        }

        /* Responsive layout - makes the two columns/boxes stack on top of each other instead of next to each other, on small screens */
        @media (max-width: 600px) {
            nav, article {
                width: 100%;
                height: auto;
            }
        }
    </style>
</head>
<body>
<header>
    <h2>{!! $topic['title'] !!}</h2>
</header>

<section>
    <nav>
        <ul>
            <li><a href="/knowledge/1">Birthweight</a></li>
            <li><a href="/knowledge/2">Sudden Infant Death Syndrom (SIDS)</a></li>
            <li><a href="/knowledge/3">Childhood obesity</a></li>
            <li><a href="/knowledge/4">Effects on the placenta</a></li>
            <li><a href="/knowledge/5">Metabolism of Nicotine</a></li>
            <li><a href="/knowledge/6">Nicotine and Brain</a></li>
        </ul>
    </nav>

    <article>
       @foreach($topic['text'] as $text)
           <p>{!! $text!!}</p>
           @endforeach
    </article>
</section>

</body>
</html>

