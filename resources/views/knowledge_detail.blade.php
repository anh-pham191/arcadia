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
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <script src="../Smoke/Three.js"></script>
    <script src="../Smoke/OrbitControls.js"></script>
    <script src="../Smoke/STLLoader.js"></script>
    <script src="../Smoke/jquery-3.2.0.min.js"></script>
    <script type="text/javascript">
        var mouse = new THREE.Vector2(0, 0);
        var last_mouse = new THREE.Vector2(0, 0);
        var raycaster = new THREE.Raycaster();
        var jloader = new THREE.JSONLoader();
        var sloader = new THREE.STLLoader();

        var controls;
        var pos = {};
        var surface_mesh;
        var camera;
        var renderer;
        var items_opacity = 0.4;
        var items_transparent = true;
        var unselected_liver = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var selected_liver = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var unselected_left_lung = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.BackSide});
        var unselected_airways = new THREE.MeshPhongMaterial({color: 0xEFD5DC, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});

        var width = window.innerWidth - 316;
        var height = window.innerHeight - 76;
        var hue_limit = 2/3;
        var max_hbco = 7.7;
        var color_factor = hue_limit / max_hbco;

        var hbco = [0.0, 1.0, 1.5, 2.0, 2.6, 3.2, 3.8, 4.4, 4.9, 5.4, 5.8, 6.2, 6.6, 6.9, 7.2, 7.5, 7.7, 7.7, 7.4, 7.0, 6.4, 5.9, 5.2, 4.6, 4.1];

        function draw3D() {
            function setup() {

//

                 jloader.load('../Smoke/models/cord_1.json', function (geometry) {
                 	var material = new THREE.MeshPhongMaterial( {
                 		color: new THREE.Color("hsl(" + ((max_hbco - hbco[0]) * color_factor * 360) + ", 100%, 50%)"),
                 	});

                 	var mesh = new THREE.Mesh(geometry, material);
                 	mesh.name = "fetus";
                 	pos["fetus"] = mesh;
                 	mesh.renderOrder = 1;
                 	scene.add(mesh);
                 	$('#items-list').append('<input type="checkbox" class="item" value="fetus" />fetus<br/>');
                     var box = new THREE.Box3().setFromObject(mesh);
                     var center = new THREE.Vector3(box.min.x + ((box.max.x - box.min.x) / 2), box.min.y + ((box.max.y - box.min.y) / 2), box.min.z + ((box.max.z - box.min.z) / 2));

                     controls.target.set(center.x, center.y, center.z);
                     controls.update();
                 });



                 jloader.load('../Smoke/models/placenta_1.json', function (geometry) {

                 	var mesh = new THREE.Mesh(geometry, unselected_airways);
                 	mesh.name = "airways";
                 	pos["airways"] = mesh;
                 	scene.add(mesh);
                 	$('#items-list').append('<input type="checkbox" class="item" value="airways" />airways<br/>');

                 });

                 jloader.load('../Smoke/models/womb_1.json', function (geometry) {
                 	var mesh = new THREE.Mesh(geometry, unselected_left_lung);
                 	mesh.renderOrder = 0.1;
                 	mesh.name = "left_lung";
                 	pos["left_lung"] = mesh;
                 	scene.add(mesh);
                 	$('#items-list').append('<input type="checkbox" class="item" value="left_lung" />left_lung<br/>');

                 });

                jloader.load('../Smoke/models/uv_1.json', function (geometry) {
                    var mesh = new THREE.Mesh(geometry, unselected_liver);
                    mesh.renderOrder = 0.1;
                    mesh.name = "liver";
                    pos["liver"] = mesh;
                    scene.add(mesh);
                    $('#items-list').append('<input type="checkbox" class="item" value="left_lung" />left_lung<br/>');

                });


            }

            function animate() {
                requestAnimationFrame(animate);
                controls.update();
                renderer.render(scene, camera);
            }

            var scene = new THREE.Scene();

            camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 10000);

            var ambientLight = new THREE.AmbientLight(0x555555);
            scene.add(ambientLight);

            var directionalLight = new THREE.DirectionalLight(0xe0e0e0);
            directionalLight.position.set(5, 2, 5).normalize();
            scene.add(directionalLight);

            var directionalLight2 = new THREE.DirectionalLight(0xe0e0e0);
            directionalLight2.position.set(-5, -2, -5).normalize();
            scene.add(directionalLight2);

            renderer = new THREE.WebGLRenderer();
            renderer.setSize(width, height);
            renderer.setClearColor(0x000000, 1);

            var span = document.getElementById("shapecanvas");
            span.appendChild(renderer.domElement);

            controls = new THREE.OrbitControls(camera, renderer.domElement);

            span.addEventListener('mousemove', onDocumentMouseMove, false);
            span.addEventListener('mousedown', onDocumentMouseDown, false);
            span.addEventListener('mouseup', onDocumentMouseUp, false);
            setup();
            animate();
        }

        function onDocumentMouseMove(event) {
            var offset = $('#shapecanvas canvas').offset();
            mouse.x = ((event.pageX - offset.left) / width) * 2 - 1;
            mouse.y = - ((event.pageY - offset.top) / height) * 2 + 1;
        }

        function onDocumentMouseDown(event) {
            var offset = $('#shapecanvas canvas').offset();
            last_mouse.x = ((event.pageX - offset.left) / width) * 2 - 1;
            last_mouse.y = - ((event.pageY - offset.top) / height) * 2 + 1;
        }

        function onDocumentMouseUp(event) {
            var offset = $('#shapecanvas canvas').offset();
            mouse.x = ((event.pageX - offset.left) / width) * 2 - 1;
            mouse.y = - ((event.pageY - offset.top) / height) * 2 + 1;

            if (Math.sqrt((mouse.x - last_mouse.x) * (mouse.x - last_mouse.x) + (mouse.y - last_mouse.y) * (mouse.y - last_mouse.y)) < 0.005) {
                raycaster.setFromCamera(mouse, camera);
                var models = $.map(pos, function(value, key) { return value });
                var hits = raycaster.intersectObjects(models);

                for (var key in pos) pos[key].material.transparent = true;
                $('#item-selected').html('&nbsp;');

                if (hits.length > 0) {
                    var selected = hits[0].object;
                    selected.material.transparent = false;
                    $('#item-selected').html(selected.name);
                }
            }
        }

        // Function to execute when the window changes its size
        window.addEventListener('resize', function() {
            width = window.innerWidth - 316;
            height = window.innerHeight - 76;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
            renderer.setSize(width, height);
        }, false);
    </script>

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
<body onload="draw3D();" >
<header class="row">
    <h2>{!! $topic['title'] !!}</h2>
</header>

<section class="row">
    <nav class="col-md-2">
        <ul>
            <li><a href="/knowledge/1">Birthweight</a></li>
            <li><a href="/knowledge/2">Sudden Infant Death Syndrom (SIDS)</a></li>
            <li><a href="/knowledge/3">Childhood obesity</a></li>
            <li><a href="/knowledge/4">Effects on the placenta</a></li>
            <li><a href="/knowledge/5">Metabolism of Nicotine</a></li>
            <li><a href="/knowledge/6">Nicotine and Brain</a></li>
        </ul>
    </nav>

    <article class="col-md-4" >
       @foreach($topic['text'] as $text)
           <p>{!! $text!!}</p>
           @endforeach

    </article>
    <div class="col-md-6">
        <div id="viewer" style="background-color: black">
            <span id="shapecanvas"style="width:100%; height: 100%"></span>
        </div>
    </div>

</section>

</body>


</html>

