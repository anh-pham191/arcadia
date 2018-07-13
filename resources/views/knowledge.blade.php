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
            height: 700px; /* only for demonstration, should be removed */
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
            height: 700px; /* only for demonstration, should be removed */
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
    <h2>Knowledge Base</h2>
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
        <p>While approximately 13% of women reported smoking during the last 3 months of pregnancy, prevalence was in excess of 20% in women with less than 12 years of education;

        </p>
        <p>High prevalence of smoking among the uninsured and those receiving Medicaid</p>
        <p>	Reductions in smoking in many environments have resulted in lowering of blood levels of cotinine, a marker of smoke exposure, by 70% in non-smokers from 1988–1991 through 2001–2002</p>
        <p>	The Surgeon General’s Report [6] lists among its many findings that secondhand smoke causes reduced birthweight and sudden infant death syndrome (SIDS), and suggests a relationship between secondhand smoke exposure and preterm birth as well as childhood cancer</p>
        <p>	A recent review and meta-analysis of the effects of secondhand smoke on birth outcomes reported associations of exposure with reduced birthweight (by 37–40 g), and 20% increased risk of low birthweight (LBW; <2500 g)</p>
        <p>	An estimated 5.9% of U.S. high school students (10.5% of boys and 1.2% of girls) were current users of smokeless tobacco products in 2004</p>
        <p>	Studies in India, where smokeless tobacco use far exceeds smoking among women in some populations, found increases in stillbirths and lower birthweight in offspring of mothers using chewing tobacco</p>
        <p>	Gupta and Sreevidya [30] found that use of smokeless tobacco during pregnancy was associated with an average reduction of 105 g in birthweight and 6.2 days in gestation length.</p>
        <p>	Use of Nicotine replacement therapy (NRT) in pregnant women is highly controversial; there have been few studies of NRT in pregnant women, and to date there is no evidence that NRT is effective in improving cessation of smoking among pregnant women</p>
        <p>	Nicotine is arguably the most damaging chemical exposure to the embryo and fetus from maternal smoking, affecting multiple organs including the central nervous system. Scientists concerned about the developmental toxicity of nicotine have argued strongly against any use of NRT in pregnancy</p>
        <p>	Nicotine is clearly a neuroteratogen, impacting the brain at critical developmental stages [37], and is the most likely cause of cognitive, emotional and behavioral problems seen in children of smokers</p>
        <p>	Nicotine binds to receptors through which developmentally important signaling occurs in many developing organs and tissues in addition to the central nervous system</p>
    </article>
</section>

</body>
</html>

