<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">

    <title>reveal.js - The HTML Presentation Framework</title>

    <meta name="description" content="A framework for easily creating beautiful presentations using HTML">
    <meta name="author" content="Hakim El Hattab">

    <meta name="apple-mobile-web-app-capable" content="yes"/>
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>

    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    <link rel="stylesheet" href="css/reveal.min.css">
    <link rel="stylesheet" href="css/theme/night.css" id="theme">

    <!-- For syntax highlighting -->
    <link rel="stylesheet" href="lib/css/zenburn.css">

    <!-- If the query includes 'print-pdf', use the PDF print sheet -->
    <script>
        document.write('<link rel="stylesheet" href="css/print/' + ( window.location.search.match(/print-pdf/gi) ? 'pdf' : 'paper' ) + '.css" type="text/css" media="print">');
    </script>

    <!--[if lt IE 9]>
    <script src="lib/js/html5shiv.js"></script>
    <![endif]-->
</head>

<body>

<div class="reveal">

<!-- Any section element inside of this container is displayed as a slide -->
<div class="slides">
<section>
    <h1>Willem-Jan Zijderveld</h1>
    <h2>RevealJS presentations</h2>

</section>

<section>
    <h2>Heads Up</h2>

    <p>
        This is a generated list of the talks I gave with the use of RevealJS slides.
    </p>

</section>

    <?php

        $directories = array('010php');

        foreach ($directories as $directory) {
            $talks = glob(__DIR__ . '/' . $directory . '/*.html');
            foreach ($talks as $talkFilename) {
                if (preg_match('/^(\d{4}\-\d{2}\-\d{2})\-\-(.*?)\.html$/', basename($talkFilename), $matches)) {

                    $date = new \DateTime($matches[1]);

                    $html = new DOMDocument();
                    $html->strictErrorChecking = false;
                    libxml_use_internal_errors(true);
                    $html->loadHTMLFile($talkFilename);
                    libxml_clear_errors();
                    $xpath = new DOMXPath($html);
                    $slide = $xpath->query('//section[position()=1]')->item(0);
                    $title = $subtitle = '';
                    if (!$slide->hasChildNodes()) {
                        $title = ucwords(str_replace('-', ' ', $matches[2]));
                    } else {
                        $titleVar = 'title';
                        foreach ($slide->childNodes as $childNode) {
                            switch ($childNode->nodeName) {
                                case 'img':
                                    ${$titleVar} = $childNode->getAttribute('title');
                                    break;
                                case 'h1':
                                case 'h2':
                                case 'h3':
                                case 'h4':
                                    ${$titleVar} = $childNode->nodeValue;
                                    break;
                                default:
                                    continue;
                            }

                            if ($title) {
                                $titleVar = 'subtitle';
                            }

                            if ($subtitle) {
                                break;
                            }
                        }
                    }


                ?>
                    <section>
                        <h1><?php echo $title; ?></h1>
                        <?php if ($subtitle): ?>
                            <h2><?php echo $subtitle; ?></h2>
                        <?php endif; ?>

                        <p><?php echo $directory; ?> - <?php echo $date->format('l, d-m-Y'); ?></p>
                        <a href="<?php echo $directory; ?>/<?php echo basename($talkFilename); ?>">Watch slides</a>
                    </section>

                <?php
                }
            }
        }

    ?>

</div>

</div>

<script src="lib/js/head.min.js"></script>
<script src="js/reveal.min.js"></script>

<script>

    // Full list of configuration options available here:
    // https://github.com/hakimel/reveal.js#configuration
    Reveal.initialize({
        controls: true,
        progress: true,
        history: true,
        center: true,

        theme: Reveal.getQueryHash().theme, // available themes are in /css/theme
        transition: Reveal.getQueryHash().transition || 'fade', // default/cube/page/concave/zoom/linear/fade/none

        // Optional libraries used to extend on reveal.js
        dependencies: [
            { src: 'lib/js/classList.js', condition: function () {
                return !document.body.classList;
            } },
            { src: 'plugin/markdown/marked.js', condition: function () {
                return !!document.querySelector('[data-markdown]');
            } },
            { src: 'plugin/markdown/markdown.js', condition: function () {
                return !!document.querySelector('[data-markdown]');
            } },
            { src: 'plugin/highlight/highlight.js', async: true, callback: function () {
                hljs.initHighlightingOnLoad();
            } },
            { src: 'plugin/zoom-js/zoom.js', async: true, condition: function () {
                return !!document.body.classList;
            } }
        ]
    });

</script>

</body>
</html>