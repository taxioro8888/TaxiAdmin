<?php

 

  $conexion =mysqli_connect('localhost','detrinic_hola','7IP;]E!}&0.%','detrinic_hola');
  if(!$conexion){
      echo "error en conexion";
  }


   $query = "SELECT producto.producto_id,producto.producto_nombre,unidades_has_precio.precio,lineas.nombre_linea, producto_almacen.cantidad FROM producto
            LEFT JOIN unidades_has_precio ON producto.producto_id = unidades_has_precio.id_producto
            LEFT JOIN lineas on lineas.id_linea = producto.producto_linea
            LEFT JOIN producto_almacen on producto_almacen.id_producto = producto.producto_id
            WHERE producto.producto_estatus = 1";
            
            $data = Connection::select($query); 
            
              if(count($data) === 0)
            {
                echo  "No hay Datos que Mostrar.";
            }
            else
            {
                echo json_encode($data,JSON_UNESCAPED_UNICODE); 
            }
     
?>

