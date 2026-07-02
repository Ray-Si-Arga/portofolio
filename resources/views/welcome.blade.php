<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3D Magic Lens Website</title>
    @vite('resources/js/app.js')
    <style>
        body,
        html {
            margin: 0;
            padding: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            background-color: #000;
            /* Menyembunyikan cursor asli agar digantikan oleh efek bola */
            cursor: none;
        }

        #canvas-container {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
        }
    </style>
</head>

<body>

    <!-- Container tempat Three.js merender gambar -->
    <div id="canvas-container"></div>

</body>

</html>