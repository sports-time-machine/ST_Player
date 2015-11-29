<html>
<head>
<?php
  echo $this->Html->script('three.min.js');
  echo $this->Html->script('OBJLoader.js');
  echo $this->Html->script('TrackballControls.js');
?>
  <style>
    body { margin: 0; }
    canvas { width: 100%; height: 100% }
  </style>
</head>
<body>

<script>
  // Our Javascript will go here.
  var scene = new THREE.Scene();
  var camera = new THREE.PerspectiveCamera( 75, window.innerWidth/window.innerHeight, 0.1, 1000 );
  //トラックボールオブジェクトの宣言
  var controls = new THREE.TrackballControls(camera);

  var renderer = new THREE.WebGLRenderer();
  //renderer.setClearColorHex( 0xffffff, 1 );
  renderer.setSize( window.innerWidth, window.innerHeight );
  document.body.appendChild( renderer.domElement );

  var directionalLight = new THREE.DirectionalLight('#ffffff', 1);
  directionalLight.position.set(0, 7, 10);
  scene.add(directionalLight); // シーンに追加

  //テクスチャの読み込み
  //var texture1 = new THREE.ImageUtils.loadTexture('run_01.jpg');

  var geometry = new THREE.BoxGeometry( 300, 300, 10 );
  var material = new THREE.MeshBasicMaterial( { color: 0xcccccc } );
  var cube = new THREE.Mesh( geometry, material /*, new THREE.MeshPhongMaterial({ map: texture1 })*/ );
  cube.position.set(1, 1, -200);
  scene.add( cube );

  camera.position.z = 10;

  // instantiate a loader
  var loader = new THREE.OBJLoader();

  // load a resource
  loader.load(
    // resource URL
    '<?php echo $filePath; ?>',
    // Function when resource is loaded
    function ( object ) {
      console.log(object);
      /*
      object.traverse( function ( child )
      {
          if ( child instanceof THREE.Mesh ) {
              //child.material.ambient.setRGB(0, 255, 0);
              child.material.color.setRGB(255, 255, 255);
          }
      });*/
      object.position.set(0, 0, 0);
      scene.add( object );

      var render = function () {
        requestAnimationFrame( render );

        //object.rotation.x += 0.01;
        object.rotation.y += 0.003;
        //cube.rotation.y += 0.003;
        //camera.position.z += 0.01;
        //object.position.y += 0.003;

        // trackball
        controls.update();

        renderer.render(scene, camera);
      };

      render();

    }
  );
</script>

</body>
</html>
