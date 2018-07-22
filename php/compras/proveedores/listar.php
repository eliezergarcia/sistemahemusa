<?php
	ini_set('max_execution_time', 300);
	include("../../conexion.php");

	$opcion = $_POST['opcion'];

	switch ($opcion) {
		case 'proveedores':
			$filtrotipo = $_POST['filtrotipo'];
			proveedores($filtrotipo, $conexion_usuarios);
			break;

		case 'sinpedido':
			$buscar = $_POST['buscar'];
			$idproveedor = $_POST['idproveedor'];
			sinpedido($idproveedor, $buscar, $conexion_usuarios);
			break;

		case 'sinrecibido':
			$buscar = $_POST['buscar'];
			$idproveedor = $_POST['idproveedor'];
			sinrecibido($idproveedor, $buscar, $conexion_usuarios);
			break;

		case 'sinentregar':
			$buscar = $_POST['buscar'];
			$idproveedor = $_POST['idproveedor'];
			sinentregar($idproveedor, $buscar, $conexion_usuarios);
			break;

		case 'backorder':
			$buscar = $_POST['buscar'];
			$idproveedor = $_POST['idproveedor'];
			backorder($idproveedor, $buscar, $conexion_usuarios);
			break;

		case 'ordenesdecompra':
			$buscar = $_POST['buscar'];
			$idproveedor = $_POST['idproveedor'];
			ordenes_compra($idproveedor, $buscar, $conexion_usuarios);
			break;
	}

	function proveedores($filtrotipo, $conexion_usuarios){
		switch ($filtrotipo) {
			case 'todos':
				$query = "SELECT * FROM contactos WHERE tipo = 'Proveedor' AND nombreEmpresa != '' ORDER BY nombreEmpresa";
				break;

			case 'herramientasinpedido':
				$query = "SELECT DISTINCT (Proveedor), contactos.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.nombreEmpresa = cotizacionherramientas.Proveedor WHERE Pedido = 'si' AND noDePedido = '' AND Proveedor != 'ALMACEN' AND pedidoFecha >= '2017-01-01' ORDER BY Proveedor";
				break;

			case 'herramientasinenviar':
				$query = "SELECT DISTINCT (Proveedor), contactos.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.nombreEmpresa = cotizacionherramientas.Proveedor WHERE Pedido = 'si' AND noDePedido != '' AND enviadoFecha='0000-00-00' AND Proveedor != 'ALMACEN' AND pedidoFecha >= '2017-01-01' ORDER BY Proveedor";
				break;

			case 'herramientasinrecibido':
				$query = "SELECT DISTINCT (Proveedor), contactos.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.nombreEmpresa = cotizacionherramientas.Proveedor WHERE Pedido = 'si' AND noDePedido != '' AND enviadoFecha!='0000-00-00' AND recibidoFecha='0000-00-00' AND Proveedor != 'ALMACEN' AND pedidoFecha >= '2017-01-01' ORDER BY Proveedor";
				break;

			case 'herramientasinentregar':
				$query = "SELECT DISTINCT (Proveedor), contactos.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.nombreEmpresa = cotizacionherramientas.Proveedor WHERE Pedido = 'si' AND noDePedido != '' AND enviadoFecha!='0000-00-00' AND recibidoFecha!='0000-00-00' AND Entregado='0000-00-00' AND Proveedor != 'ALMACEN' AND pedidoFecha >= '2017-01-01' ORDER BY Proveedor";
				break;

			case 'backorder':
				$query ="SELECT DISTINCT (Proveedor), contactos.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.nombreEmpresa = cotizacionherramientas.Proveedor WHERE  pedido='si' AND noDePedido != '' AND enviadoFecha != '0000-00-00' AND pedidoFecha > '2017-01-01' AND recibidoFecha ='0000-00-00' AND Entregado ='0000-00-00' ORDER BY Proveedor DESC";
				break;
		}
		$resultado = mysqli_query($conexion_usuarios, $query);

		if (!$resultado) {
			$arreglo["data"] = 0;
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$arreglo["data"][] = array(
					"id" => $data['id'],
					"nombreEmpresa" => utf8_encode($data['nombreEmpresa']),
					"personaContacto" => utf8_encode($data['personaContacto']),
					"tlf1" => $data['tlf1'],
					"correoElectronico" => $data['correoElectronico'],
					"paginaWeb" => $data['paginaWeb']
				);
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function sinpedido($idproveedor, $buscar, $conexion_usuarios){
		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar proveedor");
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$proveedor = $data['nombreEmpresa'];
				$proveedor = trim($proveedor);
			}

			$query = "SELECT contactos.*, cotizacionherramientas.* FROM cotizacionherramientas INNER JOIN contactos ON contactos.id = cotizacionherramientas.cliente WHERE (marca LIKE '%$buscar%' OR modelo LIKE '%$buscar%' OR nombreEmpresa LIKE '%$buscar%' OR pedidoFecha LIKE '%$buscar%') AND Pedido = 'si' AND noDePedido = '' AND (Proveedor LIKE '%$proveedor%' OR Proveedor ='$idproveedor')";
			$resultado = mysqli_query($conexion_usuarios, $query);

			if (mysqli_num_rows($resultado) < 1) {
				$arreglo['data'] = 0;
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$cotizacionRef = $data['cotizacionRef'];
					$marca = $data['marca'];
					$modelo = $data['modelo'];

					$queryprecio = "SELECT precioBase, enReserva, marca FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$resultadoprecio = mysqli_query($conexion_usuarios, $queryprecio);

					if(mysqli_num_rows($resultadoprecio) > 0){
						while($dataprecio = mysqli_fetch_assoc($resultadoprecio)){
							$precioLista = $dataprecio['precioBase'];
							$almacen = $dataprecio['enReserva'];
							$marca = $dataprecio['marca'];
						}
					}else{
						$precioLista = $data['precioLista'];
						$almacen = 0;
						$marca = $data['marca'];
					}

					$queryfactor = "SELECT * FROM factorescosto WHERE proveedor ='$idproveedor'";
					$resultadofactor = mysqli_query($conexion_usuarios, $queryfactor);
					if(!$resultadofactor){
						die("ERROR EN FACTORES");
					}else{
						$precioProveedor = $precioLista;
						while($datafactor = mysqli_fetch_assoc($resultadofactor)){
							$precioProveedor = $precioProveedor * $datafactor['factor_proveedor'];
						}
					}

					$querymarca = "SELECT * FROM marcadeherramientas WHERE marca = '$marca'";
					$resultadomarca = mysqli_query($conexion_usuarios, $querymarca);
					if(mysqli_num_rows($resultadomarca) > 0){
						while($datamarca = mysqli_fetch_assoc($resultadomarca)){
							$factor = $datamarca['factor'];
							$excepcion = $datamarca['excepcion'];
						}
					}else{
						$factor = 1;
						$excepcion = 0;
					}

					// if ($excepcion == 1) {
					// 	$precio = $precioLista * $factor;
					// 	$utilidad = (($precio - $precioProveedor)/$precio) * 100;
					// }else{
						$utilidad = (($precioLista - $precioProveedor)/$precioLista) * 100;
					// }

					$check = '<input type="checkbox" class="btn btn-outline-primary" name="hsinpedido" value="'.$data['id'].'">';

					$arreglo["data"][] = array(
							'id' => $data['id'],
							'check' => $check,
							'indice' => $i,
							'marca' => $data['marca'],
							'modelo' => $data['modelo'],
							'descripcion' => $data['descripcion'],
							'cantidad' => $data['cantidad'],
							'cliente' => $data['nombreEmpresa'],
							'precioProveedor' => "$ ".round($precioProveedor,2),
							'fecha' => $data['pedidoFecha'],
							'almacen' => $almacen,
							'utilidad' => "%".round($utilidad, 2)
						);
					$i++;
				}
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function sinrecibido($idproveedor, $buscar, $conexion_usuarios){
		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar proveedor");
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$proveedor = strtoupper($data['nombreEmpresa']);
			}

			$query = "SELECT cotizacionherramientas.*, contactos.nombreEmpresa FROM cotizacionherramientas INNER JOIN contactos ON contactos.id = cotizacionherramientas.cliente WHERE (enviadoFecha LIKE '%$buscar%' OR marca LIKE '%$buscar%' OR modelo LIKE '%$buscar%' OR descripcion LIKE '%$buscar%' OR nombreEmpresa LIKE '%$buscar%' OR noDePedido LIKE '%$buscar%' OR pedidoFecha LIKE '%$buscar%') AND Proveedor='$proveedor' AND recibidoFecha='0000-00-00' AND proveedorFecha!='0000-00-00' AND noDePedido != '' AND pedidoFecha >= '2017-01-01' ORDER BY modelo";
			$resultado = mysqli_query($conexion_usuarios, $query);
			$arreglo = array();

			if (mysqli_num_rows($resultado) < 1) {
				$arreglo['data'] = 0;
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$cotizacionRef = $data['cotizacionRef'];
					$marca = $data['marca'];
					$modelo = $data['modelo'];

					if($data['enviadoFecha'] == '0000-00-00'){
						$enviado = "";
					}else{
						$enviado = $data['enviadoFecha'];
					}

					if($data['recibidoFecha'] == '0000-00-00'){
						$recibido = "";
					}else{
						$recibido = $data['recibidoFecha'];
					}

					$queryprecio = "SELECT precioBase, enReserva, marca FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$resultadoprecio = mysqli_query($conexion_usuarios, $queryprecio);

					if(mysqli_num_rows($resultadoprecio) > 0){
						while($dataprecio = mysqli_fetch_assoc($resultadoprecio)){
							$precioLista = $dataprecio['precioBase'];
							$almacen = $dataprecio['enReserva'];
							$marca = $dataprecio['marca'];
						}
					}else{
						$precioLista = $data['precioLista'];
						$almacen = 0;
					}

					$queryfactor = "SELECT * FROM factorescosto WHERE proveedor ='$idproveedor'";
					$resultadofactor = mysqli_query($conexion_usuarios, $queryfactor);
					if(!$resultadofactor){
						die("ERROR EN FACTORES");
					}else{
						$precioProveedor = $precioLista;
						while($datafactor = mysqli_fetch_assoc($resultadofactor)){
							$precioProveedor = $precioProveedor * $datafactor['factor_proveedor'];
						}
					}

					// $recibido = '<input type="checkbox" class="btn btn-outline-primary" name="recibido" value="'.$data['id'].'">';;
					$check = '<input type="checkbox" class="btn btn-outline-primary" name="sel" value="'.$data['id'].'">';

					$arreglo["data"][] = array(
							'id' => $data['id'],
							'check' => $check,
							'indice' => $i,
							'enviado' => $enviado,
							'recibir' => $recibido,
							'marca' => $data['marca'],
							'modelo' => $data['modelo'],
							'cantidad' => $data['cantidad'],
							'descripcion' => utf8_encode($data['descripcion']),
							'cliente' => $data['nombreEmpresa'],
							'pedido' => $data['noDePedido'],
							'fecha' => $data['pedidoFecha'],
							'costo' => "$ ".round($precioProveedor,2)
						);
					$i++;
				}
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function sinentregar($idproveedor, $buscar, $conexion_usuarios){
		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar proveedor");
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$proveedor = strtoupper($data['nombreEmpresa']);
			}

			$query = "SELECT cotizacionherramientas.*, contactos.nombreEmpresa FROM cotizacionherramientas INNER JOIN contactos ON contactos.id = cotizacionherramientas.cliente WHERE (enviadoFecha LIKE '%$buscar%' OR recibidoFecha LIKE '%$buscar%' OR marca LIKE '%$buscar%' OR modelo LIKE '%$buscar%' OR descripcion LIKE '%$buscar%' OR nombreEmpresa LIKE '%$buscar%' OR noDePedido LIKE '%$buscar%' OR pedidoFecha LIKE '%$buscar%') AND Proveedor='$proveedor' AND recibidoFecha!='0000-00-00' AND proveedorFecha!='0000-00-00' AND Entregado='0000-00-00' AND pedidoFecha >= '2017-01-01' ORDER BY modelo";
			$resultado = mysqli_query($conexion_usuarios, $query);
			$arreglo = array();

			if (mysqli_num_rows($resultado) < 1) {
				$arreglo['data'] = 0;
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$marca = $data['marca'];
					$modelo = $data['modelo'];
					$idherramienta = $data['id'];

					$queryprecio = "SELECT precioBase, enReserva, marca FROM productos WHERE marca = '$marca' AND ref = '$modelo'";
					$resultadoprecio = mysqli_query($conexion_usuarios, $queryprecio);

					if(mysqli_num_rows($resultadoprecio) > 0){
						while($dataprecio = mysqli_fetch_assoc($resultadoprecio)){
							$precioLista = $dataprecio['precioBase'];
							$almacen = $dataprecio['enReserva'];
							$marca = $dataprecio['marca'];
						}
					}else{
						$precioLista = $data['precioLista'];
						$almacen = 0;
					}

					$queryfactor = "SELECT * FROM factorescosto WHERE proveedor ='$idproveedor'";
					$resultadofactor = mysqli_query($conexion_usuarios, $queryfactor);
					if(!$resultadofactor){
						die("ERROR EN FACTORES");
					}else{
						$precioProveedor = $precioLista;
						while($datafactor = mysqli_fetch_assoc($resultadofactor)){
							$precioProveedor = $precioProveedor * $datafactor['factor_proveedor'];
						}
					}

					$check = '<input type="checkbox" class="btn btn-outline-primary" name="sel" value="'.$idherramienta.'">';

					$arreglo["data"][] = array(
							'id' => $data['id'],
							'check' => $check,
							'indice' => $i,
							'enviado' => $data['enviadoFecha'],
							'recibir' => $data['recibidoFecha'],
							'marca' => $data['marca'],
							'modelo' => $data['modelo'],
							'cantidad' => $data['cantidad'],
							'descripcion' => utf8_encode($data['descripcion']),
							'cliente' => $data['nombreEmpresa'],
							'pedido' => $data['noDePedido'],
							'fecha' => $data['pedidoFecha'],
							'costo' => "$ ".round($precioProveedor,2)
						);
					$i++;
				}
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function backorder($idproveedor, $buscar, $conexion_usuarios){
		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar proveedor");
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$proveedor = $data['nombreEmpresa'];
				$proveedor = trim($proveedor);
			}

			$query ="SELECT cotizacionherramientas.*, contactos.nombreEmpresa FROM cotizacionherramientas INNER JOIN contactos ON contactos.id = cotizacionherramientas.cliente WHERE (nombreEmpresa LIKE '%$buscar%' OR marca LIKE '%$buscar%' OR modelo LIKE '%$buscar%' OR cantidad LIKE '%$buscar%' OR descripcion LIKE '%$buscar%' OR pedidoFecha LIKE '%$buscar%' OR noDePedido LIKE '%$buscar%' OR proveedor LIKE '%$buscar%' OR enviadoFecha LIKE '%$buscar%')
			AND pedido='si' AND noDePedido != '' AND enviadoFecha != '0000-00-00' AND pedidoFecha > '2017-01-01' AND recibidoFecha ='0000-00-00' AND Entregado ='0000-00-00' AND Proveedor='$proveedor' ORDER BY pedidoFecha DESC";
			$resultado = mysqli_query($conexion_usuarios, $query);

			if(mysqli_num_rows($resultado) < 1){
				$arreglo['data'] = 0;
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
		}
		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}

	function ordenes_compra($idproveedor, $buscar, $conexion_usuarios){
		$query = "SELECT * FROM contactos WHERE id = '$idproveedor'";
		$resultado = mysqli_query($conexion_usuarios, $query);

		if(!$resultado){
			die("Error al buscar proveedor");
		}else{
			while($data = mysqli_fetch_assoc($resultado)){
				$proveedor = strtoupper($data['nombreEmpresa']);
			}

			$query = "SELECT ordendecompras.*, usuarios.nombre FROM ordendecompras INNER JOIN usuarios ON usuarios.id = ordendecompras.contacto WHERE (noDePedido LIKE '%$buscar%' OR fecha LIKE '%$buscar%' OR nombre LIKE '%$buscar%') AND proveedor = '$idproveedor' ORDER BY id DESC";
			$resultado = mysqli_query($conexion_usuarios, $query);
			$arreglo = array();

			if (mysqli_num_rows($resultado) < 1) {
				$arreglo['data'] = 0;
			}else{
				$i = 1;
				while($data = mysqli_fetch_assoc($resultado)){
					$arreglo["data"][] = array(
							'id' => $data['id'],
							'indice' => $i,
							'ordencompra' => $data['noDePedido'],
							'proveedor' => utf8_encode($proveedor),
							'contacto' => $data['nombre'],
							'fecha' => $data['fecha'],
							'moneda' => strtoupper($data['moneda'])
						);
					$i++;
				}
			}
		}

		echo json_encode($arreglo, JSON_UNESCAPED_UNICODE | JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP | JSON_PARTIAL_OUTPUT_ON_ERROR);
		mysqli_close($conexion_usuarios);
	}
 ?>
