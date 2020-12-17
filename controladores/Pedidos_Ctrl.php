<?php

class Pedidos_Ctrl {

     public $M_Pedido = null;
     public $M_Pedido_Detalle = null;

     public function __construct()
     
     {
          $this->M_Pedido = new M_Pedidos();
          $this->M_Pedido_Detalle = new M_Pedidos_Detalle();
     }

     public function crear($f3){

          $this->M_Pedido->set('usuario_id', $f3->get('POST.usuario_id'));
          $this->M_Pedido->set('fecha', $f3->get('POST.fecha'));
          $this->M_Pedido->set('estado', $f3->get('POST.estado'));
          $this->M_Pedido->save();

          echo json_encode([
               'mensaje' => 'Pedido creado',
               'info' => [
                    'id_pedido' => $this->M_Pedido->get('id_pedido')
               ]

          ]);


     }

     public function agregar_producto($f3)
     {
          $this->M_Pedido_Detalle->set('pedido_id', $f3->get('PARAMS.pedido_id'));
          $this->M_Pedido_Detalle->set('producto_id', $f3->get('POST.producto_id'));
          $this->M_Pedido_Detalle->set('cantidad', $f3->get('POST.cantidad'));
          $this->M_Pedido_Detalle->set('precio', $f3->get('POST.precio'));
          $this->M_Pedido_Detalle->save();
          
          echo json_encode([
               'mensaje' => 'Producto Agregado',
               'info' => [
                    'id_ped_det' => $this->M_Pedido_Detalle->get('id_ped_det')
               ]

          ]);

     }

     public function consultar($f3){
          $pedido_id = $f3->get('PARAMS.pedido_id');
          $this->M_Pedido->load(['id_pedido = ?', $pedido_id ]);
          $msg = "";
          $item = array();

          if($this->M_Pedido->loaded() > 0) {

               $msg ="Pedido Encontrado";
               $item = $this->M_Pedido->cast();

          } else{

               $msg = "El pedido no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => [
                    'item' => $item
               ]

          ]);
     }

     public function listado($f3){
          $result = $this->M_Pedido->find();
          $items = array();
         foreach($result as $pedido) {
              $items[] = $pedido->cast();
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
          $pedido_id = $f3->get('POST.pedido_id');
          $this->M_Pedido->load(['id_pedido = ?', $pedido_id ]);
          $msg = "";
          if($this->M_Pedido->loaded() > 0) {

               $msg ="Pedido Eliminado";
               $this->M_Pedido->erase();

          } else{

               $msg = "El pedido no existe";

          }

          echo json_encode([
               'mensaje' => $msg,
               'info' => []

          ]);
     }
}