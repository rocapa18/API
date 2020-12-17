<?php
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Allow-Methodsn: PUT, GET, POST, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, Content-Type, Authorization, Accept, X-Requested-Whith, x-xsrf-token");
header("Content-Type: application/json; charset=utf-8");

include "config.php";

$postjson = json_decode(file_get_contents('php://input'), true);
$today = date('Y-m-d H:i:s');

if($postjson['aksi'] == "proses_register"){

     


          $password = md5($postjson['password']);

          $insert = mysqli_query($mysqli, "INSERT INTO usuarios  SET

               nombre     = '$postjson[nombre]',
               email      = '$postjson[email]',
               password   = '$password',
               direccion  = '$postjson[direccion]',
               telefono   = '$postjson[telefono]',
               create_at  = '$today'
     ");

     if($insert){
          $result = json_encode(array('success' => true,'msg'=>'Registro exitoso'));
     }else{
          $result = json_encode(array('success' => false, 'msg'=>'No se ha podido registrar'));
     }

     echo $result;
     }


elseif($postjson['aksi'] === "proses_login"){
     $password = md5($postjson['password']);
     $logindata = mysqli_fetch_array(mysqli_query($mysqli, "SELECT * FROM usuarios WHERE email='$postjson[email]' AND password = '$password'"));

     $data = array(
          'id_usuario' => $logindata['id_usuario'],
          'nombre'     => $logindata['nombre'],
          'email'      => $logindata['email'],
          'direccion'  => $logindata['direccion'],
          'telefono'   => $logindata['telefono'],
     );

     if($logindata){
          $result = json_encode(array('success' => true, 'result'=>$data));
     }else{
          $result = json_encode(array('success' => false));
     }
     echo $result;
}


elseif($postjson['aksi'] === "load_users"){

     $data = array();

     $query = mysqli_query($mysqli, "SELECT * FROM usuarios ORDER BY id_usuario DESC LIMIT $postjson[start], $postjson[limit]");

     while ($rows = mysqli_fetch_array($query)){

          $data[] = array(
               'id_usuario' => $rows['id_usuario'],
               'nombre'     => $rows['nombre'],
               'email'      => $rows['email'],
               'direccion'  => $rows['direccion'],
               'telefono'   => $rows['telefono']
          );
     }

     if($query){
          $result = json_encode(array('success' => true, 'result'=>$data));
     }else{
          $result = json_encode(array('success' => false));
     }
     echo $result;
}

elseif($postjson['aksi'] === "del_users"){

     $query = mysqli_query($mysqli, "DELETE FROM usuarios WHERE id_usuario='$postjson[id]'");

     if($query){
          $result = json_encode(array('success' => true));
     }else{
          $result = json_encode(array('success' => false));
     }
     echo $result;
}

elseif($postjson['aksi'] === "load_productos"){

     $data = array();

     $query = mysqli_query($mysqli, "SELECT * FROM productos ORDER BY id_producto DESC LIMIT $postjson[start], $postjson[limit]");

     while ($rows = mysqli_fetch_array($query)){

          $data[] = array(
               'id_producto' => $rows['id_producto'],
               'nombre'     => $rows['nombre'],
               'categoria'      => $rows['categoria'],
               'codigo'  => $rows['codigo'],
               'stock'   => $rows['stock'],
               'unidad'   => $rows['unidad'],
               'precio'   => $rows['precio'],
               'imagen'   => $rows['imagen'],
               'descripcion'   => $rows['descripcion'],
          );
     }

     if($query){
          $result = json_encode(array('success' => true, 'result'=>$data));
     }else{
          $result = json_encode(array('success' => false));
     }
     echo $result;
}


// $cekemail = mysqli_fetch_array(mysqli_query($mysqli, "SELECT email FROM usuarios WHERE email = '$postjson[email]' "));
     
//      if ($cekemail['email'] == $postjson['email']) {

//           $result = json_encode(array('success'=>false, 'msg'=>'Este email ya existe'));

//      } else {

//      }
// $cekemail = mysqli_fetch_array(mysqli_query($mysqli, "SELECT email FROM usuarios WHERE email = '$postjson[email]' "));
     
//      if ($cekemail['email'] == $postjson['email']) {

//           $result = json_encode(array('success'=>false, 'msg'=>'Este email ya existe'));

//      } else {}