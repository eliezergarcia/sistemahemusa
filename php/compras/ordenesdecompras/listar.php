<?php

	include("../../conexion.php");

	$opcion = $_POST['opcion'];

	switch ($opcion) {
		case 'ordenesdecompras':
			ordenesdecompras($conexion_usuarios);
			break;

		case 'backorder':
			backorder($conexion_usuarios);
			break;

		case 'sinenviar':
			sinenviar($conexion_usuarios);
			break;

		case 'partidasoc':
			$ordencompra = $_POST['ordencompra'];
			partidasoc($ordencompra, $conexion_usuarios);
			break;

		case 'facturasoc':
			$ordencompra = $_POST['ordencompra'];
			facturasoc($ordencompra, $conexion_usuarios);
			break;

		case 'totalesocdescripcion':
			$ordencompra = $_POST['ordencompra'];
			totalesocdescripcion($ordencompra, $conexion_usuarios);
			break;

		case 'totalesoc':
			$ordencompra = $_POST['ordencompra'];
			totalesoc($ordencompra, $conexion_usuarios);
			break;

		case 'partidasocdescripcion':
			$ordencompra = $_POST['ordencompra'];
			partidasocdescripcion($ordencompra, $conexion_usuarios);
			break;
	}

	function ordenesdecompras($conexion_usuarios){
		$query = "SELECT ordendecompras.id, ordendecompras.noDePedido, ordendecompras.Fecha, ordendecompras.proveedor, ordendecompras.moneda,
		contactos.nombreEmpresa, usuarios.nombre, usuarios.apellidos FROM ordendecompras LEFT JOIN contactos on contactos.id=ordendecompras.proveedor
		INNER JOIN usuarios on usuarios.id=ordendecompras.contacto  ORDER BY id DESC LIMIT 999";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die('Error');
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$arreglo["data"][] = array(
					'ordencompra' => $data['noDePedido'],
					'proveedor' => utf8_encode($data['nombreEmpresa']),
					'contacto' => $data['nombre']." ".$data['apellidos'],
					'fecha' => $data['Fecha'],
					'moneda' => strtoupper($data['moneda']),
				);

			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function backorder($conexion_usuarios){
		$query ="SELECT cotizacionherramientas.*, contactos.nombreEmpresa FROM cotizacionherramientas INNER JOIN contactos
		 ON contactos.id = cotizacionherramientas.cliente WHERE  pedido='si' AND noDePedido != '' AND enviadoFecha != '0000-00-00'
		AND pedidoFecha > '2015-01-01' AND recibidoFecha ='0000-00-00' AND Entregado ='0000-00-00' ORDER BY Proveedor DESC, pedidoFecha DESC";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar backorder!");
		}else{
			$i = 1;
			while($data = mysqli_fetch_assoc($resultado)){

				$arreglo['data'][] = array(
					'id' => $data['id'],
					'indice' => $i,
					'cliente' => $data['nombreEmpresa'],
					'marca' => $data['marca'],
					'modelo' => $data['modelo'],
					'descripcion' => $data['descripcion'],
					'cantidad' => $data['cantidad'],
					'fechapedido' => $data['pedidoFecha'],
					'ordencompra' => $data['noDePedido'],
					'proveedor' => $data['Proveedor'],
					'fechaenviado' => $data['enviadoFecha']
				);

				$i++;
			}
		}
		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
	}

	function sinenviar($conexion_usuarios){
		$query ="SELECT cotizacionherramientas.*, contactos.nombreEmpresa FROM cotizacionherramientas INNER JOIN contactos
		 ON contactos.id = cotizacionherramientas.cliente WHERE  pedido='si' AND noDePedido != '' AND enviadoFecha = '0000-00-00'
		AND pedidoFecha > '2015-01-01' AND recibidoFecha ='0000-00-00' AND Entregado ='0000-00-00' ORDER BY Proveedor";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar backorder!");
		}else{
			$i = 1;
			while($data = mysqli_fetch_assoc($resultado)){

				$arreglo['data'][] = array(
					'id' => $data['id'],
					'indice' => $i,
					'cliente' => $data['nombreEmpresa'],
					'marca' => $data['marca'],
					'modelo' => $data['modelo'],
					'descripcion' => $data['descripcion'],
					'cantidad' => $data['cantidad'],
					'fechapedido' => $data['pedidoFecha'],
					'ordencompra' => $data['noDePedido'],
					'proveedor' => $data['Proveedor'],
					'fechaenviado' => $data['enviadoFecha']
				);

				$i++;
			}
		}
		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
	}

	function partidasoc($ordencompra, $conexion_usuarios){
		$query = "SELECT * FROM ordendecompras WHERE noDePedido = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$idproveedor = $data['proveedor'];
			$fechaoc = $data['fecha'];
			$moneda = $data['moneda'];
		}

		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$monedaproveedor = $data['moneda'];
		}

		$query = "SELECT * FROM utilidad_pedido WHERE orden_compra = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if (mysqli_num_rows($resultado) > 0) {
			if (!$resultado) {
				verificar_resultado($resultado);
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$marca = $data['marca'];
					$modelo = $data['modelo'];

					$queryalmacen = "SELECT precioBase,enReserva FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$resultadoalmacen = mysqli_query($conexion_usuarios, $queryalmacen);
					if(mysqli_num_rows($resultadoalmacen) > 0){
						while($dataalmacen = mysqli_fetch_array($resultadoalmacen)){
							$almacen = $dataalmacen['enReserva'];
						}
					}else{
						$almacen = 0;
					}

					if($moneda == "usd"){
						$precioUnitario = $data['costo_usd'];
						$precioTotal = $data['costo_usd'] * $data['cantidad'];
						$utilidad = (($data['venta_usd'] - $data['costo_usd'])/$data['venta_usd']) * 100;
					}else{
						$precioUnitario = $data['costo_mn'];
						$precioTotal = $data['costo_mn'] * $data['cantidad'];
						$utilidad = (($data['venta_mn'] - $data['costo_mn'])/$data['venta_mn']) * 100;
					}


					$arreglo["data"][] = array(
						'id' => $data['id'],
						'indice' => $i,
						'marca' => $data['marca'],
						'modelo' => $data['modelo'],
						'descripcion' => utf8_encode($data['descripcion']),
						'precioUnitario' => "$ ".round($precioUnitario,2),
						'cantidad' => $data['cantidad'],
						'precioTotal' => "$ ".round($precioTotal,2),
						'almacen' => $almacen,
						'fechaCompromiso' => "",
						'utilidad' => "% ".round($utilidad,2),
						'enviado' => $data['fecha_enviado'],
						'recibido' => $data['fecha_llegada']
					);
					$i++;
				}
			}
		}else{
			$query = "SELECT * FROM cotizacionherramientas WHERE noDePedido = '$ordencompra'";
			$resultado = mysqli_query($conexion_usuarios, $query);

			if (!$resultado) {
				verificar_resultado($resultado);
				die("Error");
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$marca = $data['marca'];
					$modelo = $data['modelo'];

					$query1 = "SELECT precioBase,enReserva,moneda FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$res1 = mysqli_query($conexion_usuarios, $query1);

					if(mysqli_num_rows($res1) > 0){
						while($data1 = mysqli_fetch_array($res1)){
							$precioBase = $data1['precioBase'];
							$almacen = $data1['enReserva'];
							$moneda = $data1['moneda'];
						}
					}else{
						$precioBase = $data['precioLista'];
						$almacen = 0;
						$moneda = $data['moneda'];
					}

					$query2 = "SELECT * FROM tipocambio WHERE fecha = '$fechaoc'";
					$res2 = mysqli_query($conexion_usuarios, $query2);
					while($data2 = mysqli_fetch_assoc($res2)){
						$tipocambio = $data2['tipocambio'];
					}

					if($monedaproveedor == "usd" && $moneda == "usd"){
						$precioUnitario = $precioBase;
						$precioTotal = $precioBase * $data['cantidad'];
						$utilidad = (($data['precioLista'] - $precioUnitario)/$data['precioLista']) * 100;
					}elseif($monedaproveedor == "usd" && $moneda == "mxn"){
						$precioUnitario = $precioBase;
						$precioTotal = ($precioBase * $data['cantidad']) / $tipocambio;
						$utilidad = (($data['precioLista'] - $precioUnitario)/$data['precioLista']) * 100;
					}

					if($monedaproveedor == "mxn" && $moneda == "mxn"){
						$precioUnitario = $precioBase;
						$precioTotal = $precioBase * $data['cantidad'];
						$utilidad = (($data['precioLista'] - $precioUnitario)/$data['precioLista']) * 100;
					}elseif($monedaproveedor == "mxn" && $moneda == "usd"){
						$precioUnitario = $precioBase;
						$precioTotal = ($precioBase * $data['cantidad']) * $tipocambio;
						$utilidad = (($data['precioLista'] - $precioUnitario)/$data['precioLista']) * 100;
					}

					$arreglo["data"][] = array(
						'id' => $data['id'],
						'indice' => $i,
						'marca' => $data['marca'],
						'modelo' => $data['modelo'],
						'descripcion' => utf8_encode($data['descripcion']),
						'precioUnitario' => "$ ".round($precioUnitario,2),
						'cantidad' => $data['cantidad'],
						'precioTotal' => "$ ".round($precioTotal,2),
						'almacen' => $almacen,
						'fechaCompromiso' => "",
						'utilidad' => "% ".round($utilidad,2),
						'enviado' => $data['enviadoFecha'],
						'recibido' => $data['recibidoFecha']
					);
					$i++;
				}
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function facturasoc($ordencompra, $conexion_usuarios){
		$query = "SELECT DISTINCT factura_proveedor, Tipo_pago, pago_factura, fecha_pago, cuenta, total_factura FROM utilidad_pedido WHERE pagada = 'si' AND orden_compra = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(mysqli_num_rows($resultado) < 1){
			$arreglo['data'] = 0;
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$idcuenta = $data['cuenta'];

				if ($data['Tipo_pago'] == "OC") {
					$referencia = $ordencompra;
				}else{
					$referencia = $data['factura_proveedor'];
				}

				$query2 = "SELECT tipo_cambio FROM pagos_oc WHERE factura='$referencia'";
				$resultado2 = mysqli_query($conexion_usuarios, $query2);
				while($data2 = mysqli_fetch_assoc($resultado2)){
					$tipocambio = $data2['tipo_cambio'];
				}

				$query3 = "SELECT nombre FROM accounts WHERE id='$idcuenta'";
				$resultado3 = mysqli_query($conexion_usuarios, $query3);
				while($data3 = mysqli_fetch_assoc($resultado3)){
					$cuenta = $data3['nombre'];
				}

				$arreglo["data"][] = array(
					'referencia' => $referencia,
					'cantidad' => "$ ".$data['total_factura'],
					'fecha' => $data['fecha_pago'],
					'cuenta' => $cuenta,
					'tipoCambio' => $tipocambio,
				);
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function totalesoc($ordencompra, $conexion_usuarios){
		$query = "SELECT * FROM ordendecompras WHERE noDePedido = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$flete = $data['flete'];
			$idproveedor = $data['proveedor'];
			$fechaoc = $data['fecha'];
			$moneda = $data['moneda'];
		}

		$query = "SELECT tipocambio FROM tipocambio WHERE fecha = '$fechaoc'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$tipocambio = $data['tipocambio'];
		}

		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$monedaproveedor = $data['moneda'];
		}

		$query = "SELECT * FROM utilidad_pedido WHERE orden_compra = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if (mysqli_num_rows($resultado) > 0) {
			$subtotal = 0;
			while($data = mysqli_fetch_assoc($resultado)){
				if($moneda == "usd"){
					// $flete = $flete / $tipocambio;
					$subtotal = $subtotal +  ($data['costo_usd'] * $data['cantidad']);
					$subtotalventa = $subtotalventa +  ($data['venta_usd'] * $data['cantidad']);
				}else{
					// $flete = $flete * $tipocambio;
					$subtotal = $subtotal + ($data['costo_mn'] * $data['cantidad']);
					$subtotalventa = $subtotalventa + ($data['venta_mn'] * $data['cantidad']);
				}
			}

			$iva = ($subtotal + $flete) * .16;
			$total = ($subtotal + $flete) * 1.16;
			$utilidad = (($subtotalventa - $subtotal)/$subtotalventa) * 100;

			$arreglo["data"][] = array(
				'subtotal' => "$ ".round($subtotal, 2),
				'flete' => "$ ".round($flete, 2),
				'iva' => "$ ".round($iva, 2),
				'total' => "$ ".round($total, 2),
				'utilidad' => "% ".round($utilidad, 2),
				'moneda' => strtoupper($moneda)
			);
		}else{
			$query = "SELECT * FROM cotizacionherramientas WHERE noDePedido = '$ordencompra'";
			$resultado = mysqli_query($conexion_usuarios, $query);

			if (!$resultado) {
				verificar_resultado($resultado);
				die("Error");
			}else{
				$i = 1;
				$subtotal = 0;
				while($data = mysqli_fetch_assoc($resultado)){
					$marca = $data['marca'];
					$modelo = $data['modelo'];

					$query1 = "SELECT precioBase,enReserva,moneda FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$res1 = mysqli_query($conexion_usuarios, $query1);

					if(mysqli_num_rows($res1) > 0){
						while($data1 = mysqli_fetch_array($res1)){
							$precioBase = $data1['precioBase'];
							$almacen = $data1['enReserva'];
							$moneda = $data1['moneda'];
						}
					}else{
						$precioBase = $data['precioLista'];
						$almacen = 0;
						$moneda = $data['moneda'];
					}

					$query2 = "SELECT * FROM tipocambio WHERE fecha = '$fechaoc'";
					$res2 = mysqli_query($conexion_usuarios, $query2);
					while($data2 = mysqli_fetch_assoc($res2)){
						$tipocambio = $data2['tipocambio'];
					}

					if($monedaproveedor == "usd" && $moneda == "usd"){
						$precioUnitario = $precioBase;
						$subtotal = $subtotal + ($precioUnitario * $data['cantidad']);
					}elseif($monedaproveedor == "usd" && $moneda == "mxn"){
						$precioUnitario = $precioBase;
						$subtotal = $subtotal + (($precioUnitario * $data['cantidad']) / $tipocambio);
					}

					if($monedaproveedor == "mxn" && $moneda == "mxn"){
						$subtotal = $subtotal + ($precioBase * $data['cantidad']);
					}elseif($monedaproveedor == "mxn" && $moneda == "usd"){
						$precioUnitario = $precioBase;
						$subtotal = $subtotal + (($precioUnitario * $data['cantidad']) * $tipocambio);
					}

				}
				$iva = ($subtotal + $flete) * .16;
				$total = ($subtotal + $flete) * 1.16;
				$utilidad = (($total - $subtotal)/$total) * 100;

				$query2 = "SELECT * FROM ordendecompras WHERE noDePedido = '$ordencompra'";
				$resultado2 = mysqli_query($conexion_usuarios, $query2);

				while($data2 = mysqli_fetch_assoc($resultado2)){
					$monedaorden = $data2['moneda'];
				}

				$arreglo["data"][] = array(
					'subtotal' => "$ ".round($subtotal, 2),
					'flete' => "$ ".round($flete, 2),
					'iva' => "$ ".round($iva, 2),
					'total' => "$ ".round($total, 2),
					'utilidad' => "% ".round($utilidad, 2),
					'moneda' => strtoupper($monedaorden)
				);
			}
		}
		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
	}

	function partidasocdescripcion($ordencompra, $conexion_usuarios){
		$query = "SELECT * FROM utilidad_pedido WHERE orden_compra = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if (mysqli_num_rows($resultado) > 0) {
			$i = 1;
			while($data = mysqli_fetch_assoc($resultado)){
				$idcliente = $data['cliente'];
				$idproveedor = $data['proveedor'];

				$querycliente = "SELECT * FROM contactos WHERE id = '$idcliente'";
				$rescliente = mysqli_query($conexion_usuarios, $querycliente);
				while($datacliente = mysqli_fetch_assoc($rescliente)){
					$cliente = $datacliente['nombreEmpresa'];
				}

				$queryproveedor = "SELECT * FROM contactos WHERE id = '$idproveedor'";
				$resproveedor = mysqli_query($conexion_usuarios, $queryproveedor);
				while($dataproveedor = mysqli_fetch_assoc($resproveedor)){
					$proveedor= $dataproveedor['nombreEmpresa'];
				}

				$check = '<input type="checkbox" class="btn btn-outline-primary" name="hcheck" value="'.$data['id_cotizacion_herramientas'].'">';

				if ($data['factura_hemusa'] != 0 || $data['remision'] != 0) {
					$cantfacturada = $data['cantidad'];
				}else{
					$cantfacturada = 0;
				}

				if ($data['moneda_pedido'] == "usd") {
					$utilidad = round((($data['venta_usd']-$data['costo_usd'])/$data['venta_usd']) * 100,2);
				}else{
					$utilidad = round((($data['venta_mn']-$data['costo_mn'])/$data['venta_mn']) * 100,2);
				}

				$arreglo["data"][] = array(
					'indice' => $i,
					'check' => $check,
					'id' => $data['id'],
					'idcotizacionherramientas' => $data['id_cotizacion_herramientas'],
					'enviado' => $data['fecha_enviado'],
					'recibido' => $data['fecha_llegada'],
					'marca' => $data['marca'],
					'modelo' => $data['modelo'],
					'cantidad' => $data['cantidad'],
					'descripcion' => $data['descripcion'],
					'proveedor' => utf8_encode($proveedor),
					'entrada' => $data['entrada'],
					'cliente' => utf8_encode($cliente),
					'pedido' => $data['orden_compra'],
					'fecha' => $data['fecha_orden_compra'],
					'tipocambio' => $data['tipo_cambio'],
					'costomxn' => "$ ".round($data['costo_mn'],2),
					'costousd' => "$ ".round($data['costo_usd'],2),
					'totalmxn' => "$ ".round($data['costo_mn'] * $data['cantidad'],2),
					'totalusd' => "$ ".round($data['costo_usd']  * $data['cantidad'],2),
					'facturap' => $data['factura_proveedor'],
					'facturah' => $data['factura_hemusa'],
					'remision' => $data['remision'],
					'cantfacturada' => $cantfacturada,
					'ventamxn' => round($data['venta_mn'],2),
					'ventausd' => round($data['venta_usd'],2),
					'totalventamxn' => round($data['venta_mn'] * $data['cantidad'],2),
					'totalventausd' => round($data['venta_usd'] * $data['cantidad'],2),
					'moneda' => strtoupper($data['moneda_pedido']),
					'utilidad' => "% ".$utilidad,
					'folio' => $data['folio'],
					'pedimento' => $data['Pedimento']

				);
				$i++;
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function totalesocdescripcion($ordencompra, $conexion_usuarios){
		$queryflete = "SELECT * FROM ordendecompras WHERE noDePedido = '$ordencompra'";
		$resultadoflete = mysqli_query($conexion_usuarios, $queryflete);
		while($dataflete = mysqli_fetch_assoc($resultadoflete)){
			$flete = $dataflete['flete'];
			$moneda = $data['moneda'];
		}
		$query = "SELECT * FROM utilidad_pedido WHERE orden_compra = '$ordencompra'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		$costo = 0;
		$venta = 0;
		while($data = mysqli_fetch_assoc($resultado)){
			if ($moneda == "usd") {
				$costo = $costo + ($data['costo_usd'] * $data['cantidad']);
				$venta = $venta + ($data['venta_usd'] * $data['cantidad']);
			}else{
				$costo = $costo + ($data['costo_mn'] * $data['cantidad']);
				$venta = $venta + ($data['venta_mn'] * $data['cantidad']);
			}
		}
		$venta = $venta + $flete;
		$utilidad = (($venta - $costo)/$venta)*100;

			$arreglo["data"][] = array(
				'costo' => "$ ".$costo,
				'flete' => "$ ".$flete,
				'venta' => "$ ".$venta,
				'utilidad' => "% ".round($utilidad)
			);
		echo json_encode($arreglo);

		// $query = "SELECT marca,modelo,cantidad FROM cotizacionherramientas WHERE noDePedido = '$ordencompra'";
		// $resultado = mysqli_query($conexion_usuarios, $query);
		// if(mysqli_num_rows($resultado) > 0){
		// 	if (!$resultado) {
		// 		verificar_resultado($resultado);
		// 	}else{
		// 		$subtotal = 0;
		// 		while($data = mysqli_fetch_array($resultado)){
		// 			$marca = $data['marca'];
		// 			$modelo = $data['modelo'];
		// 			$cantidad = $data['cantidad'];
		// 			$query2 = "SELECT precioBase FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
		// 			$resultado2 = mysqli_query($conexion_usuarios, $query2);
		// 			while($data2 = mysqli_fetch_array($resultado2)){
		// 				$subtotal = $subtotal + ($data2['precioBase'] * $cantidad);
		// 			}
		// 		}

		// 		$query = "SELECT flete FROM ordendecompras WHERE noDePedido = '$ordencompra'";
		// 		$resultado = mysqli_query($conexion_usuarios, $query);
		// 		while($data = mysqli_fetch_array($resultado)){
		// 			$flete = $data['flete'];
		// 		}

		// 		$iva = ($subtotal + $flete) * .16;
		// 		$total = $subtotal + $flete + $iva;
		// 		$utilidad = (($total - $subtotal)/$total)*100;

		// 			$arreglo["data"][] = array(
		// 				'subtotal' => "$ ".$subtotal,
		// 				'flete' => "$ ".$flete,
		// 				'iva' => "$ ".$iva,
		// 				'total' => "$ ".$total,
		// 				'utilidad' => "% ".round($utilidad)
		// 			);
		// 		echo json_encode($arreglo);
		// 	}
		// }else{
		// 	$query = "SELECT marca,modelo,cantidad FROM cotizacionherramientas WHERE ordenCompra = '$ordencompra'";
		// 	$resultado = mysqli_query($conexion_usuarios, $query);
		// 	if (!$resultado) {
		// 		verificar_resultado($resultado);
		// 	}else{
		// 		$subtotal = 0;
		// 		while($data = mysqli_fetch_array($resultado)){
		// 			$marca = $data['marca'];
		// 			$modelo = $data['modelo'];
		// 			$cantidad = $data['cantidad'];
		// 			$query2 = "SELECT precioBase FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
		// 			$resultado2 = mysqli_query($conexion_usuarios, $query2);
		// 			while($data2 = mysqli_fetch_array($resultado2)){
		// 				$subtotal = $subtotal + ($data2['precioBase'] * $cantidad);
		// 			}
		// 		}

		// 		$query = "SELECT flete FROM ordendecompras WHERE noDePedido = '$ordencompra'";
		// 		$resultado = mysqli_query($conexion_usuarios, $query);
		// 		while($data = mysqli_fetch_array($resultado)){
		// 			$flete = $data['flete'];
		// 		}

		// 		$iva = ($subtotal + $flete) * .16;
		// 		$total = $subtotal + $flete + $iva;
		// 		$utilidad = (($total - $subtotal)/$total)*100;

		// 			$arreglo["data"][] = array(
		// 				'subtotal' => "$ ".$subtotal,
		// 				'flete' => "$ ".$flete,
		// 				'iva' => "$ ".$iva,
		// 				'total' => "$ ".$total,
		// 				'utilidad' => "% ".round($utilidad)
		// 			);
		// 		echo json_encode($arreglo);
		// 	}
		// }

	}

	function verificar_resultado($resultado){
		if (!$resultado) {
			$informacion["respuesta"] = "ERROR";
		}else{
			$informacion["respuesta"] = "ERROR";
		}
	}
 ?>
