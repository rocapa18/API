<?php
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Productos_Ctrl {

     public $M_Producto = null;

     public function __construct()
     
     {
          $this->M_Producto = new M_Productos();
     }

     public function crear($f3){
          $id= 0;

          $this->M_Producto->set('nombre', $f3->get('POST.nombre'));
          $this->M_Producto->set('categoria', $f3->get('POST.categoria'));
          $this->M_Producto->set('codigo', $f3->get('POST.codigo'));
          $this->M_Producto->set('stock', $f3->get('POST.stock'));
          $this->M_Producto->set('unidad', $f3->get('POST.unidad'));
          $this->M_Producto->set('precio', $f3->get('POST.precio'));
          $this->M_Producto->set('descripcion', $f3->get('POST.descripcion'));
          $this->M_Producto->set('color', $f3->get('POST.color'));
          $this->M_Producto->save();


          $id= $this->M_Producto->get('id_producto');

          if ($id > 0) {
               $this->M_Producto-> set('imagen', $this->Guardar_imagen($f3->get('POST.imagen')));
               $this->M_Producto->update();
               
          }

          $msg = "Producto creado.";
          
          

          echo json_encode([
               'mensaje' => 'Producto creado',
               'info' => [
                    'id_producto' => $this->M_Producto->get('id_producto')
               ]

          ]);
          


     }

     public function consultar($f3){
          $producto_id = $f3->get('PARAMS.producto_id');
          $this->M_Producto->load(['id_producto = ?', $producto_id ]);
          $msg = "";
          $item = array();

          if($this->M_Producto->loaded() > 0) {

               $msg ="Producto Encontrado";
               $item = $this->M_Producto->cast();
               $item['precio'] = round($item['precio']);
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';

          } else{

               $msg = "El producto no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => [
                    'item' => $item
               ]

          ]);
     }

     public function listado($f3){

          $result = $this->M_Producto->find(['nombre LIKE ?', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
              $item = $producto->cast();
              $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
              $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }

     public function listadoV($f3){

          $result = $this->M_Producto->find(['categoria LIKE 1', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
               $item = $producto->cast();
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
               $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }

     public function listadoP($f3){

          $result = $this->M_Producto->find(['categoria LIKE 2', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
               $item = $producto->cast();
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
               $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }

     public function listadoC($f3){

          $result = $this->M_Producto->find(['categoria LIKE 3', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
               $item = $producto->cast();
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
               $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }

     public function listadoQ($f3){

          $result = $this->M_Producto->find(['categoria LIKE 4', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
               $item = $producto->cast();
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
               $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }

     public function listadoH($f3){

          $result = $this->M_Producto->find(['categoria LIKE 5', '%' . $f3->get('POST.texto') . '%']);
          $items = array();
         foreach($result as $producto) {
               $item = $producto->cast();
               $item['imagen'] = !empty($item['imagen']) ? 'http://farinata.rocapa-proyectos.online/API/' . $item['imagen'] : 'http://via.placeholder.com/300x300';
               $items[] = $item;
         }
         echo json_encode([
          'mensaje' => count($items) > 0 ? '' : 'Aún no hay registros para mostrar.',
          'info' => [
               'items' => $items,
               'total' => count($items)
          ]
         ]);
     }


     public function eliminar($f3){
          $producto_id = $f3->get('POST.producto_id');
          $this->M_Producto->load(['id_producto = ?', $producto_id ]);
          $msg = "";
          if($this->M_Producto->loaded() > 0) {

               $msg ="Producto Eliminado";
               $this->M_Producto->erase();

          } else{

               $msg = "El producto no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => []

          ]);
     }

    
     public function actualizar($f3){
          $producto_id = $f3->get('PARAMS.producto_id');
          $this->M_Producto->load(['id_producto = ?', $producto_id ]);
          $msg = "";
          $info = array();

          if($this->M_Producto->loaded() > 0) {
               $_producto = new M_Productos();
               $_producto->load(['codigo = ? AND id_producto <> ?', $f3->get('POST.codigo'), $producto_id]);
               if ($_producto->loaded() > 0) {
                    $msg ="El registro no se pudo modificar, el codigo esta siendo usado por otro producto";
                    $info['id_producto'] = 0;
               } else {
                    $this->M_Producto-> set('nombre', $f3->get('POST.nombre'));
                    $this->M_Producto-> set('categoria', $f3->get('POST.categoria'));
                    $this->M_Producto-> set('codigo', $f3->get('POST.codigo'));
                    $this->M_Producto-> set('stock', $f3->get('POST.stock'));
                    $this->M_Producto-> set('unidad', $f3->get('POST.unidad'));
                    $this->M_Producto-> set('precio', $f3->get('POST.precio'));
                    if($f3->get('POST.imagen')){
                         $this->M_Producto-> set('imagen', $this->Guardar_imagen($f3->get('POST.imagen')));
                    }
                    $this->M_Producto-> set('descripcion', $f3->get('POST.descripcion'));
                    $this->M_Producto-> set('color', $f3->get('POST.color'));
                    $this->M_Producto->save();
                    $msg ="Producto Actualizado";
                    $info['id_producto'] = $this->M_Producto->get('id_producto');
               }
          } else{
               $msg = "El producto no existe";
               $info['id_producto'] = 0;
          }
          echo json_encode([
               'mensaje' => $msg,
               'info' => $info
          ]);
     }

     // Guarda imagen en carpeta, y devuelve el path donde se guardo
     public function Guardar_Imagen($contenido){

          $nombre_imagen = '';

          if(!empty($contenido)) {

               $contenido = explode('base64,', $contenido);
               $imagen = $contenido[1];
               $nombre_imagen = 'imagenes/' . time() . '.jpg';
               file_put_contents($nombre_imagen, base64_decode($imagen));
          }
          return $nombre_imagen;
     }
}