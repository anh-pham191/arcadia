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

        //add liver

        var unselected_liver = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var selected_liver = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var unselected_brain = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var selected_brain = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var unselected_kidney = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var selected_kidney = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.DoubleSide});
        var unselected_heart = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.BackSide});
        var selected_heart = new THREE.MeshPhongMaterial({color: 0xCCA994, opacity: items_opacity, transparent: items_transparent, side: THREE.BackSide});
        var surface_material = new THREE.MeshPhongMaterial({color: 0xBE645A, opacity: 0.3, transparent: true, side: THREE.BackSide}); //rgb(190,100,90)
        var width = window.innerWidth - 316;
        var height = window.innerHeight - 76;
        var hue_limit = 2/3;
        var max_hbco = 75;
        var color_factor = hue_limit / max_hbco;

        // var hbco = [0.0, 1.0, 1.5, 2.0, 2.6, 3.2, 3.8, 4.4, 4.9, 5.4, 5.8, 6.2, 6.6, 6.9, 7.2, 7.5, 7.7, 7.7, 7.4, 7.0, 6.4, 5.9, 5.2, 4.6, 4.1];

        var liver = [0, 60, 25, 3, 2, 1, 0.9, 0.7, 0.6, 0.5, 0.5, 0.5, 0.4, 0.4, 0.3, 0.2, 0.2, 0.2, 0.1, 0.1, 0.1, 0.09, 0.08, 0.08, 0.07];

        var brain = [0, 75, 50, 25, 20, 15, 12, 10, 9, 8, 8, 7, 6.5, 6, 6, 5.5, 5.5, 4, 4, 4, 3.5, 3.5, 3.5, 3.5, 3];

        var kidney = [0, 20, 12, 10, 7, 6, 5, 4.5, 4.5, 4.5, 4, 3.7, 3.4, 3.3, 3.2, 3, 2.5, 2, 1.5, 1, 0.7, 0.6, 0.5];

        function draw3D() {
            function setup() {

                var sloader = new THREE.STLLoader();

                // add liver

                sloader.load('../Smoke/models/brain.stl', function (geometry) {
                    var mesh = new THREE.Mesh(geometry, unselected_brain);

                    mesh.renderOrder = 1;
                    mesh.material.alphaTest = 0.1;
                    mesh.name = "brain";
                    pos["brain"] = mesh;
                    scene.add(mesh);
                    $('#items-list').append('<input type="checkbox" class="item" value="brain" checked />brain<br/>');
                });

                sloader.load('../Smoke/models/arteries.stl', function (geometry) {
                    var mesh = new THREE.Mesh(geometry, unselected_heart);
                    mesh.name = "heart";
                    pos["heart"] = mesh;
                    scene.add(mesh);
                    $('#items-list').append('<input type="checkbox" class="item" value="heart" checked />heart<br/>');
                });


                sloader.load('../Smoke/models/kidney.stl', function (geometry) {
                    var mesh = new THREE.Mesh(geometry, unselected_kidney);
                    mesh.name = "kidney";
                    pos["kidney"] = mesh;
                    scene.add(mesh);
                    $('#items-list').append('<input type="checkbox" class="item" value="kidney" checked />kidney<br/>');
                });

                //stl

                sloader.load('../Smoke/models/liver.stl', function(geometry) {
                    var mesh = new THREE.Mesh(geometry, unselected_liver);
                    mesh.name = "liver";
                    pos["liver"] = mesh;
                    scene.add(mesh);
                    $('#items-list').append('<input type="checkbox" class="item" value="liver" checked />liver<br/>');
                });



                $(document).on('change', '.item', function() {
                    var name = $(this).attr('value');
                    if ($(this).is(':checked')) {
                        pos[name].visible = true;
                    }
                    else {
                        pos[name].visible = false;
                    }
                });

                $(document).on('change', '.all-items', function() {
                    if ($(this).is(':checked')) {
                        $('.item').prop('checked', true);
                        for (var key in pos) pos[key].visible = true;
                    }
                    else {
                        $('.item').prop('checked', false);
                        for (var key in pos) pos[key].visible = false;
                    }
                });

                var sloader = new THREE.STLLoader();
                sloader.load('../Smoke/models/surface_new.stl', function(geometry) {
                    var mesh = new THREE.Mesh(geometry, surface_material);
                    mesh.renderOrder = 1;
                    mesh.name = "surface";
                    surface_mesh = mesh;
                    scene.add(mesh);

                    var box = new THREE.Box3().setFromObject(surface_mesh);
                    var center = new THREE.Vector3(box.min.x + ((box.max.x - box.min.x) / 2), box.min.y + ((box.max.y - box.min.y) / 2), box.min.z + ((box.max.z - box.min.z) / 2));

                    controls.target.set(center.x, center.y, center.z);
                    camera.position.set(0,0,Math.max(center.x*2,center.y*2,center.z*2));
                    camera.position.y = 3;
                    camera.position.z = 0.9;



                    controls.update();
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
            renderer.setClearColor(0xffffff, 1);

            var span = document.getElementById("shapecanvas");
            span.appendChild(renderer.domElement);

            controls = new THREE.OrbitControls(camera, renderer.domElement);

            span.addEventListener('mousemove', onDocumentMouseMove, false);
            span.addEventListener('mousedown', onDocumentMouseDown, false);
            span.addEventListener('mouseup', onDocumentMouseUp, false);

            setup();
            animate();

            $('.surface-item').change(function() {
                if ($(this).is(':checked')) {
                    surface_mesh.visible = false;
                }
                else {
                    surface_mesh.visible = true;
                }
            });

            $(document).on('input change', '#surface-slider', function() {
                surface_material.opacity = $(this).val();
            });

            $(document).on('input change', '#hbco-slider', function() {
                pos["brain"].material.color.setHSL((max_hbco - brain[$(this).val()]) * color_factor, 1.0, 0.5);
                pos["kidney"].material.color.setHSL((max_hbco - kidney[$(this).val()]) * color_factor, 1.0, 0.5);
                pos["liver"].material.color.setHSL((max_hbco - liver[$(this).val()]) * color_factor, 1.0, 0.5);
                pos["heart"].material.color.setHSL((max_hbco - liver[$(this).val()]) * color_factor, 1.0, 0.5);


                $("#hbco-time").html($(this).val());
                // $("#hbco-value").html(hbco[$(this).val()]);

                var dynamic_canvas = document.getElementById("hbco-chart-line");
                var dynamic_context = dynamic_canvas.getContext("2d");

                var x_pos = 25 + 11 * parseInt($(this).val());
                console.log(x_pos);
                dynamic_context.clearRect(0, 0, dynamic_canvas.width, dynamic_canvas.height);
                dynamic_context.beginPath();
                dynamic_context.moveTo(x_pos, 0);
                dynamic_context.lineTo(x_pos, 115);
                dynamic_context.strokeStyle = '#ff0000';

                dynamic_context.stroke();
            });

            var background_canvas = document.getElementById("hbco-chart");
            var background_context = background_canvas.getContext("2d");

            var imageObj = new Image();
            imageObj.onload = function() {
                background_context.drawImage(this, 0, 0, this.width, this.height, 0, 0, background_canvas.width, background_canvas.height);
            };

            imageObj.src = "../Smoke/timecourse.png";

            var dynamic_canvas = document.getElementById("hbco-chart-line");
            var dynamic_context = dynamic_canvas.getContext("2d");

            dynamic_context.beginPath();
            dynamic_context.moveTo(25, 0);
            dynamic_context.lineTo(25, 115);
            dynamic_context.strokeStyle = '#ff0000';
            dynamic_context.stroke();
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
            height: 100px !important;
        }

    </style>
</head>
<body onload="draw3D();"  >
<header class="row">
    <h2>Metabolism of Nicotine</h2>
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
        <p>Maternal smoking alters the blood flow to the placenta and changes the balance between proliferation and differentiation of the cytotrophoblast</p>
        <p>Changes seen in the placentas of smokers were present in less severe form in women exposed to secondhand smoke during pregnancy.</p>
        <p>Cadmium, a constituent of tobacco smoke known to accumulate in the placenta, has been shown to inhibit the activity of the enzyme 11-β-hydroxysteroid dehydrogenase type 2 (11-β-HSD2) as well as decrease 11-β-HSD2 mRNA and protein in cultured human trophoblast cells [49]. Reduction in 11-β-HSD2 activity in the placenta has been associated with decreased intrauterine growth</p>
        <p>Placental abruption, the premature separation of a normally implanted placenta before delivery, occurs in about 1% of pregnancies….maternal smoking has been associated with a 90% increase in risk of placental abruption (odds ratio 1.9 [95% CI 1.8–2.0])</p>
        <p>Maternal smoking has been associated with placenta previa, which is the implantation of the placenta over or near the internal os of the cervix. As labor approaches, partial detachment and severe vaginal bleeding may result.</p>
        <p>The odds ratios for increased risk of placenta previa with maternal smoking ranged from 2.6 to 4.4, despite controlling for confounders</p>


    </article>
    <div class="col-md-4" id="view-3d">
            <div id="viewer" style="background-color: black">
                <span id="shapecanvas"style="width:100%; height: 100%"></span>
            </div>
    </div>
    <div class="col-md-2">
        <div id="controls">
            <span>CONTROLS</span><br/>
            <br/>
            <span>Check to show / Uncheck to hide</span>
            <div id="all-items-container">
                <input type="checkbox" class="all-items" value="all_items" checked />All elements<br/>
            </div>
            <div id="items-list"></div>
            <br/>
            <span>Element selected:</span><br/>
            <div id="item-selected">&nbsp;</div>
            <br/>
            <input type="checkbox" class="surface-item" value="surface" />Hide surface<br/>
            <br/>
            <span>Surface opacity:</span><br/>
            <input id="surface-slider" type="range" value="0.3" min="0" max="1" step="0.05" /><br/>
            <br/>
            <span>Nicotine (24-h exposure):</span><br/>
            <input id="hbco-slider" type="range" value="0" min="0" max="24" step="1" />
            <div id="hbco-values">
                <div id="hbco-time-container">
                    Time: <span id="hbco-time">0</span> h
                </div>
                <div id="hbco-value-container">
                    {{--Fetal HbCO: <span id="hbco-value">0</span> %--}}
                </div>
                <div id="hbco-chart-container">
                    <canvas id="hbco-chart" width="290"></canvas>
                    <canvas id="hbco-chart-line" width="290"></canvas>
                </div>
            </div>
        </div>
    </div>
</section>

</body>
<script>
    $(function(){
        $('canvas').width(600);
        $('canvas').height('auto');
        console.log($('canvas').width);


    });
</script>
</html>

