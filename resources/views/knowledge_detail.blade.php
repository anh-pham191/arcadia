<!DOCTYPE html>
<html lang="en">
<head>

    <title>Knowledge Base</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
            display: flex;
            flex-direction: column;
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

        #view-3d {
            flex-grow: 1;
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
        html {
            overflow: hidden;
        }

        body {
            background-color: black;
        }

        #title {
            height: 60px;
            text-align: center;
            font-size: 3em;
            font-family: impact;
            color: white;
        }

        #content {
            text-align: center;
        }

        #viewer {
            float: left;
        }

        #shapecanvas {
            border: none;
        }

        #controls {
            float: left;
            width: 290px;
            margin: 5px;
            color: white;
            font-family: impact;
        }

        #all-items-container {
            text-align: left;
            border: 1px solid white;
            border-bottom: none;
            background: white;
            color: black;
        }

        #items-list {
            height: 100px;
            text-align: left;
            border: 1px solid white;
            overflow-y: scroll;
        }

        #item-selected {
            background: rgba(0,255,0,0.3);
        }

        #surface-slider, #hbco-slider {
            width: 290px;
        }

        #hbco-time-container, #hbco-value-container {
            float: left;
            width: 50%;
        }

        #hbco-chart-container {
            position: relative;
        }

        #hbco-chart, #hbco-chart-line {
            position: absolute;
            left: 0;
            top: 25px;
            width: 290px !important;
            height: 100px;
        }

    </style>
</head>
<body>
<header class="row">
    <h2>{!! $topic['title'] !!}</h2>
</header>

<section class="row">
    <nav class="col-md-1">
        <ul>
            <li><a href="/knowledge/1">Birthweight</a></li>
            <li><a href="/knowledge/2">Sudden Infant Death Syndrom (SIDS)</a></li>
            <li><a href="/knowledge/3">Childhood obesity</a></li>
            <li><a href="/knowledge/4">Effects on the placenta</a></li>
            <li><a href="/knowledge/5">Metabolism of Nicotine</a></li>
            <li><a href="/knowledge/6">Nicotine and Brain</a></li>
        </ul>
    </nav>

    <article class="col-md-11" >
       @foreach($topic['text'] as $text)
           <p>{!! $text!!}</p>
           @endforeach

    </article>

</section>

</body>

</html>

