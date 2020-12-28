<?php
header('Content-type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

class Usuarios_Ctrl {

     public $M_Usuario = null;

     public function __construct()
     
     {
          $this->M_Usuario = new M_Usuarios();
     }

     public function crear($f3){

          $this->M_Usuario->load(['email = ? or telefono = ?', $f3->get('POST.email'), $f3->get('POST.telefono')]);

          if ($this->M_Usuario->loaded() > 0) {

               echo json_encode([
                    'mensaje' => 'Usuario ya existe con este correo o teléfono',
                    'info' => [
                         'id_usuario' => 0
                    ]
     
               ]);


          } else {

               $this->M_Usuario->set('nombre', $f3->get('POST.nombre'));
               $this->M_Usuario->set('email', $f3->get('POST.email'));
               $this->M_Usuario->set('password', $f3->get('POST.password'));
               $this->M_Usuario->set('confirm_pass', $f3->get('POST.confirm_pass'));
               $this->M_Usuario->set('direccion', $f3->get('POST.direccion'));
               $this->M_Usuario->set('telefono', $f3->get('POST.telefono'));
               $this->M_Usuario->set('activo', $f3->get('POST.activo'));
               $this->M_Usuario->save();

               echo json_encode([
                    'mensaje' => 'Usuario creado',
                    'info' => [
                         'id_usuario' => $this->M_Usuario->get('id_usuario')
                    ]

               ]);

          }

          


     }

     public function consultar($f3){
          $usuario_id = $f3->get('PARAMS.usuario_id');
          $this->M_Usuario->load(['id_usuario = ?', $usuario_id ]);
          $msg = "";
          $item = array();

          if($this->M_Usuario->loaded() > 0) {

               $msg ="Usuario Encontrado";
               $item = $this->M_Usuario->cast();

          } else{

               $msg = "El usuario no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => [
                    'item' => $item
               ]

          ]);
     }

     public function listado($f3){
          $result = $this->M_Usuario->find();
          $items = array();
         foreach($result as $usuario) {
              $items[] = $usuario->cast();
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
          $usuario_id = $f3->get('POST.usuario_id');
          $this->M_Usuario->load(['id_usuario = ?', $usuario_id ]);
          $msg = "";
          if($this->M_Usuario->loaded() > 0) {

               $msg ="Usuario Eliminado";
               $this->M_Usuario->erase();

          } else{

               $msg = "El usuario no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => []

          ]);
     }

     public function actualizar($f3){
          $usuario_id = $f3->get('PARAMS.usuario_id');
          $this->M_Usuario->load(['id_usuario = ?', $usuario_id ]);
          $msg = "";
          if($this->M_Usuario->loaded() > 0) {
               $_usuario = new M_Usuarios();
               $_usuario->load(['email = ? AND id_usuario <> ?', $f3->get('POST.email'), $usuario_id]);
               if ($_usuario->loaded() > 0) {
                    $msg ="El Usuario no se pudo modificar, el correo esta siendo usado por otro usuario";
                    $info['id_usuario'] = 0;
               } else {

                    $this->M_Usuario-> set('nombre', $f3->get('POST.nombre'));
                    $this->M_Usuario-> set('telefono', $f3->get('POST.telefono'));
                    $this->M_Usuario-> set('direccion', $f3->get('POST.direccion'));
                    $this->M_Usuario-> set('email', $f3->get('POST.email'));
                    $this->M_Usuario->save();
                    $msg ="Usuario Actualizado";
                    $info['id_usuario'] = $this->M_Usuario->get('id_usuario');
               }
          } else{
               $msg = "El usuario no existe";
               $info['id_usuario'] = 0;

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => []

          ]);
     }


}