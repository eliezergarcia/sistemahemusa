<?php 
	include('../../conexion.php');	
	
	$opcion = $_POST["opcion"];	
	$informacion = [];

	switch ($opcion) {
		case 'agregarcotizacion':
			$usuariologin = $_POST["usuariologin"];
			$dplogin = $_POST["dplogin"];
			$numeroCotizacion = $_POST['numeroCotizacion'];
			$fechaCotizacion = $_POST['fechaCotizacion'];
			$vendedor = $_POST['vendedor'];
			$cliente = $_POST['cliente'];
			$contactoCliente = $_POST['contactoCliente'];
			$moneda = $_POST['moneda'];
			$tiempoEntrega = $_POST['tiempoEntrega'];
			$condicionesPago = $_POST['condicionesPago'];
			$comentarios = $_POST['comentarios'];
			agregar_cotizacion($usuariologin, $dplogin, $numeroCotizacion, $fechaCotizacion, $vendedor, $cliente, $contactoCliente, $moneda, $tiempoEntrega, $condicionesPago, $comentarios, $conexion_usuarios);
			break;

		case 'agregarcontacto':
			$idcliente = $_POST['idcliente'];
			$contacto = $_POST['contacto'];
			$puesto = $_POST['puesto'];
			$calle = $_POST['calle'];
			$colonia = $_POST['colonia'];
			$ciudad = $_POST['ciudad'];
			$estado = $_POST['estado'];
			$cp = $_POST['cp'];
			$pais = $_POST['pais'];
			$tlf = $_POST['tlf'];
			$movil = $_POST['movil'];
			$correoElectronico = $_POST['correoElectronico'];
			agregar_contacto($idcliente, $contacto, $puesto, $calle, $colonia, $ciudad, $estado, $cp, $pais, $tlf, $movil, $correoElectronico, $conexion_usuarios);
			break;

		case 'agregarClas':
			$idCliente = $_POST['id'];
			$clas = $_POST['clasificacion'];
			agregarClas($idCliente, $clas, $conexion_usuarios);
			break;

		case 'agregar':
			$idproducto= $_POST['idproducto'];
			$noExisteProducto = $_POST['noExisteProducto'];
			$valorClaseE = $_POST['valorClaseE'];
			$refCotizacion = $_POST['refCotizacion'];
			if(isset($_POST["marca"])){
				$marca = $_POST["marca"];
			}else{
				$marca = $_POST["marca2"];
			}
			if(isset($_POST["modificarPrecioLista"])){
				$modificar = "si";
			}else{
				$modificar = "no";
			}
			$modelo = $_POST["modelo"];
			$descripcion = $_POST["descripcion"];
			$precioUnitario = str_replace("$ ", "", $_POST["precioUnitario"]);
			$cantidad = $_POST["cantidad"];
			$claveSat = $_POST["claveSat"];
			$unidad = $_POST["unidad"];
			$tedias = $_POST["tedias"];
			$refInterna = $_POST["refInterna"];
			$cotizadoEn = $_POST["cotizadoEn"];
			agregar($idproducto, $modificar, $noExisteProducto, $valorClaseE, $modelo, $marca, $descripcion, $claveSat, $precioUnitario, $cantidad, $unidad, $tedias, $refInterna, $cotizadoEn, $refCotizacion, $conexion_usuarios);
			break;

		case 'editar':
			$refCotizacion = $_POST['refCotizacion'];
			$idherramienta = $_POST["idherramienta"];
			$descripcion = $_POST["descripcion"];
			$precioUnitario = str_replace("$ ", "", $_POST["precioUnitario"]);
			$cantidad = $_POST["cantidad"];
			$claveSat = $_POST["claveSat"];
			$tedias = $_POST["tedias"];
			$refInterna = $_POST["refInterna"];
			$cotizadoEn = $_POST["cotizadoEn"];
			$proveedorFlete = $_POST['proveedorFlete'];
			editar($refCotizacion, $descripcion, $precioUnitario, $cantidad, $claveSat, $tedias, $refInterna, $cotizadoEn, $proveedorFlete, $idherramienta, $conexion_usuarios);
			break;
		
		case 'eliminar':
			$idherramienta = $_POST["idherramienta"];
			$refCotizacion = $_POST['refCotizacion'];
			eliminar($refCotizacion, $idherramienta, $conexion_usuarios);
			break;

		case 'agregarFlete':
			$refCotizacion = $_POST['refCotizacion'];
			$proveedor = $_POST['proveedor'];
			$totalFlete = $_POST['totalFlete'];
			agregarFlete($refCotizacion, $proveedor, $totalFlete, $conexion_usuarios);
			break;

		case 'editarFlete':
			$idflete = $_POST['idflete'];
			$proveedor = $_POST['proveedor'];
			$costoFlete = $_POST['totalFlete'];
			$refCotizacion = $_POST['refCotizacion'];
			editarFlete($idflete, $proveedor, $costoFlete, $refCotizacion, $conexion_usuarios);
			break;

		case 'eliminarFlete':
			$idflete = $_POST['idflete'];
			eliminarFlete($idflete, $conexion_usuarios);
			break;

		case 'acutalizarTotalFlete':
			$refCotizacion = $_POST['refCotizacion'];
			acutalizarTotalFlete($refCotizacion, $conexion_usuarios);
			break;

		case 'cambiarPedido':
			$data = json_decode($_POST['herramienta']);
			$refCotizacion = $_POST['refCotizacion'];
			$numeroPedido = $_POST['numeroPedido'];
			$numeroPartidas = $_POST['numeroPartidas'];
			cambiarPedido($data, $refCotizacion, $numeroPedido, $numeroPartidas, $conexion_usuarios);
			break;

		default:
			$informacion["respuesta"] = "OPCION_VACIA";
			echo json_encode($informacion);
			break;
	}

	function agregar_cotizacion($usuariologin, $dplogin, $numeroCotizacion, $fechaCotizacion, $vendedor, $cliente, $contactoCliente, $moneda, $tiempoEntrega, $condicionesPago, $comentarios, $conexion_usuarios){
		$query = "SELECT id FROM contactos WHERE nombreEmpresa LIKE '%$cliente%' LIMIT 1";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			verificar_resultado($resultado);
		}else{
			while($data = mysqli_fetch_array($resultado)){
				$idCliente = $data['id'];
			}
			$fecha = date("Y", strtotime($fechaCotizacion)).'-'.date("m", strtotime($fechaCotizacion)).'-'.date("d", strtotime($fechaCotizacion));
			$query = "INSERT INTO cotizacion (ref, cliente, contacto, vendedor, fecha, moneda, TiempoEntrega, CondPago, Otra) VALUES ('$numeroCotizacion', '$idCliente', '$contactoCliente', '$vendedor', '$fecha', '$moneda', '$tiempoEntrega', '$condicionesPago', '$comentarios')";
			$resultado = mysqli_query($conexion_usuarios, $query);
			if (!$resultado) {
				verificar_resultado($resultado);
			}else{
				$informacion["respuesta"] = "BIEN";
				$informacion["cotizacion"] = $numeroCotizacion;
				echo json_encode($informacion);
				// $descripcion = "Se creo la cotizacion ".$numeroCotizacion;
				// $fechahora = date("Y-m-d G:i:s");
				// $query = "INSERT INTO movimientosusuarios (cotizacion, departamento, usuario, tipomovimiento, descripcion, fechahora) VALUES ('$numeroCotizacion','$dplogin', '$usuariologin', 'Registro', '$descripcion', '$fechahora')";
				// $resultado = mysqli_query($conexion_usuarios, $query);
				// if (!$resultado) {
				// 	verificar_resultado($resultado);
				// }else{
				// 	$informacion["respuesta"] = "BIEN";
				// 	$informacion["cotizacion"] = $numeroCotizacion;
				// 	echo json_encode($informacion);
				// }
			}
		}
		cerrar($conexion_usuarios);		
	}

	function agregar_contacto($idcliente, $contacto, $puesto, $calle, $colonia, $ciudad, $estado, $cp, $pais, $tlf, $movil, $correoElectronico, $conexion_usuarios){
		$query = "INSERT INTO contactospersonas (empresa,personaContacto,puesto,calle,colonia,ciudad,estado,cp,pais,tlf1,movil,correoElectronico) VALUES ('$idcliente', '$contacto', '$puesto', '$calle', '$colonia', '$ciudad', '$estado', '$cp', '$pais', '$tlf', '$movil', '$correoElectronico')";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			verificar_resultado($resultado);
		}else{	
			$informacion["guardar"] = "contacto";
			$informacion["respuesta"] = "BIEN";
			$informacion["idcliente"] = $idcliente;
			echo json_encode($informacion);
			// $query = "SELECT nombreEmpresa FROM contactos WHERE id = '$idcliente'";
			// $resultado = mysqli_query($conexion_usuarios, $query);
			// while ($data = mysqli_fetch_assoc($resultado)) {
			// 	$cliente = $data['nombreEmpresa'];
			// }

			// $descripcion = "Se agrego el contacto ".$contacto." al cliente".$cliente;
			// $fechahora = date("Y-m-d G:i:s");
			// $query = "INSERT INTO movimientosusuarios (departamento, usuario, tipomovimiento, descripcion, fechahora) VALUES ('$dplogin', '$usuariologin', 'Registro', '$descripcion', '$fechahora')";
			// $resultado = mysqli_query($conexion_usuarios, $query);
			// verificar_resultado($resultado);
		}
		mysqli_close($conexion_usuarios);
	}

	function agregarClas($idCliente, $clas, $conexion_usuarios){
		switch ($clas) {
			case 'clas1':
				$clas = 1.20;
				break;

			case 'clas2':
				$clas = 1.25;
				break;
			
			case 'clas3':
				$clas = 1.33;
				break;
			
			case 'clas4':
				$clas = 1.42;
				break;
		}

		$query = "UPDATE contactos SET clasificacion='$clas' WHERE id=$idCliente";
		$resultado = mysqli_query($conexion_usuarios, $query);
		verificar_resultado($resultado);
		cerrar($conexion_usuarios);
	}

	function agregar($idproducto, $modificar, $noExisteProducto, $valorClaseE, $modelo, $marca, $descripcion, $claveSat, $precioUnitario, $cantidad, $unidad, $tedias, $refInterna, $cotizadoEn, $refCotizacion, $conexion_usuarios){
		$proveedorFlete = "Ninguno";
		$query = "SELECT * FROM cotizacion WHERE ref = '$refCotizacion'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			$cotizacionNo = $data['id'];
			$cliente = $data['cliente'];
			$moneda = $data['moneda'];
		}

		$query = "INSERT INTO cotizacionherramientas (cliente, cotizacionNo, modelo, marca, descripcion, ClaveProductoSAT, precioLista, cantidad, Unidad, Tiempo_Entrega, referencia_interna, lugar_cotizacion, cotizacionRef, moneda) VALUES ('$cliente', '$cotizacionNo', '$modelo', '$marca', '$descripcion', '$claveSat', '$precioUnitario', '$cantidad', '$unidad', '$tedias', '$refInterna', '$cotizadoEn', '$refCotizacion', '$moneda')";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			// verificar_resultado($resultado);
			echo json_encode("ERROR 1");
		}else{
			$query = "SELECT DISTINCT partidaCantidad FROM cotizacion WHERE ref='".$refCotizacion."'";
			$resultado = mysqli_query($conexion_usuarios, $query);
			if(!$resultado){
				// verificar_resultado($resultado);	
				echo json_encode("ERROR 1.5");
			}else{
				while($data = mysqli_fetch_array($resultado)){
					$numPartidas = $data['partidaCantidad'];
				}
				$numPartidas++;
				$query = "UPDATE cotizacion SET partidaCantidad='".$numPartidas."' WHERE ref='".$refCotizacion."'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				if (!$resultado) {
					// verificar_resultado($resultado);
					echo json_encode("ERROR 2");
				}else{
					$query = "SELECT precioLista,cantidad FROM cotizacionherramientas WHERE cotizacionRef = '".$refCotizacion."'";
					$resultado = mysqli_query($conexion_usuarios, $query);
					if (!$resultado) {
						// verificar_resultado($resultado);
						echo json_encode("ERROR 3");
					}else{
						$precioTotal = 0;
						while ($data = mysqli_fetch_array($resultado)) {

							$precioTotal = $precioTotal + ( $data['precioLista'] * $data['cantidad'] );
						}
						$query = "UPDATE cotizacion SET precioTotal ='".$precioTotal."' WHERE ref ='".$refCotizacion."'";
						$resultado = mysqli_query($conexion_usuarios, $query);
						if (!$resultado) {
							// verificar_resultado($resultado);
							echo json_encode("ERROR 4");
						}else{
							if ($valorClaseE != "none") {
								$fecha = date("Y-m-d H:i:s");
								switch ($valorClaseE) {
									case 'nacional':
										$factorClaseE = 1.20;
										break;
									case 'americano':
										$factorClaseE = 1.40;
										break;
									case 'otro':
										$factorClaseE = 1.60;
										break;
								}
								if ($noExisteProducto == "noExisteProducto") {
									$enReserva = 0;
									$clase = "E";
									$moneda = "usd";
									$cantidadMinima = 1;
									$query = "INSERT INTO productos (marca, ref, descripcion, ClaveProductoSAT, precioBase, enReserva, clase, fecha, factor, moneda, CantidadMinima, Unidad) VALUES ('$marca', '$modelo', '$descripcion', '$claveSat', '$precioUnitario', '$enReserva', '$clase', '$fecha', '$factorClaseE', '$moneda', '$cantidadMinima', '$unidad')";
									$resultado = mysqli_query($conexion_usuarios, $query);
									verificar_resultado($resultado);
									// echo json_encode("ERROR 5");
								}else{
									$query = "UPDATE productos SET factor ='".$factorClaseE."' WHERE ref ='".$modelo."'";
									$resultado = mysqli_query($conexion_usuarios, $query);
									if (!$resultado) {
										$informacion["respuesta"] = "ERROR 1.6";
										echo json_encode($informacion);
									}else{
										if($modificar == "si"){
											$query ="UPDATE productos SET marca='$marca', ref='$modelo', descripcion='$descripcion', precioBase='$precioUnitario', ClaveProductoSAT='$claveSat', Unidad='$unidad' WHERE IdProducto='$idproducto'";
											$resultado = mysqli_query($conexion_usuarios, $query);
											if(!$resultado){
												$informacion["respuesta"] = "ERROR 2";
												echo json_encode($informacion);											
											}else{
												verificar_resultado($resultado);
											}
										}else{
											verificar_resultado($resultado);
										}
									}
								}
							}else{
								if($modificar == "si"){
									$query ="UPDATE productos SET marca='$marca', ref='$modelo', descripcion='$descripcion', precioBase='$precioUnitario', ClaveProductoSAT='$claveSat', Unidad='$unidad' WHERE IdProducto='$idproducto'";
									$resultado = mysqli_query($conexion_usuarios, $query);
									if(!$resultado){
										$informacion["respuesta"] = "ERROR 4";
										echo json_encode($informacion);
									}else{
										verificar_resultado($resultado);
									}
								}else{
									verificar_resultado($resultado);
								}
							}
						}
					}
				}
			}
		}
		$query = "SELECT TiempoEntrega FROM cotizacion WHERE ref = '$refCotizacion'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			if($tedias > $data['TiempoEntrega']){
				$query2 = "UPDATE cotizacion SET TiempoEntrega = '$tedias' WHERE ref = '$refCotizacion'";
				$res2 = mysqli_query($conexion_usuarios, $query2);
			}
		}
		cerrar($conexion_usuarios);
	}

	function editar($refCotizacion, $descripcion, $precioUnitario, $cantidad, $claveSat, $tedias, $refInterna, $cotizadoEn, $proveedorFlete, $idherramienta, $conexion_usuarios){
		$query ="UPDATE cotizacionherramientas SET descripcion='$descripcion', precioLista='$precioUnitario', cantidad='$cantidad', ClaveProductoSAT='$claveSat', Tiempo_Entrega='$tedias', referencia_interna='$refInterna', lugar_cotizacion='$cotizadoEn', proveedorFlete ='$proveedorFlete' WHERE id=$idherramienta";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			verificar_resultado($resultado);
		}else{
			$query = "SELECT precioLista, flete, cantidad FROM cotizacionherramientas WHERE cotizacionRef = '".$refCotizacion."'";
			$resultado = mysqli_query($conexion_usuarios, $query);
			if (!$resultado) {
				verificar_resultado($resultado);
			}else{
				$precioTotal = 0;
				while ($data = mysqli_fetch_array($resultado)) {

					$precioTotal = $precioTotal + ( ($data['precioLista'] + $data['flete']) * $data['cantidad'] );
				}
				$query = "UPDATE cotizacion SET precioTotal ='".$precioTotal."' WHERE ref ='".$refCotizacion."'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				if(!$resultado){
					verificar_resultado($resultado);
				}else{
					if($proveedorFlete == "Ninguno" || $proveedorFlete == "ninguno"){
						verificar_resultado($resultado);
						// $query = "UPDATE cotizacionherramientas SET flete = 0.0000 WHERE id='".$idherramienta."'";
						// $resultado = mysqli_query($conexion_usuarios, $query);
						// if (!$resultado) {
						// 	verificar_resultado($resultado);
						// }else{
						// 	$query = "SELECT proveedor FROM fletescotizacion WHERE refCotizacion ='$refCotizacion'";
						// 	$resultado = mysqli_query($conexion_usuarios, $query);
						// 	if (!$resultado) {
						// 		verificar_resultado($resultado);
						// 	}else{
						// 		while($data2 = mysqli_fetch_array($resultado)){
						// 			$proveedorFlete = $data2['proveedor'];
						// 			$query = "SELECT costoFlete FROM fletescotizacion WHERE refCotizacion ='$refCotizacion' AND proveedor = '$proveedorFlete'";
						// 			$resultado = mysqli_query($conexion_usuarios, $query);
						// 			while($data = mysqli_fetch_array($resultado)){
						// 				$costoFlete = $data['costoFlete'];
						// 			}
						// 			$query = "SELECT precioLista, cantidad FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
						// 			$resultado = mysqli_query($conexion_usuarios, $query);
						// 			if (!$resultado) {
						// 				verificar_resultado($resultado);
						// 			}else{
						// 				$costoTotal = 0;
						// 				while($data = mysqli_fetch_array($resultado)){
						// 					$precioLista = $data['precioLista'];
						// 					$cantidad = $data['cantidad'];
						// 					$costoTotal = $costoTotal + ($precioLista * $cantidad);
						// 				}
						// 				$costoFleteTotal = $costoFlete / $costoTotal;
						// 				$info['costoFlete'] = $costoFlete;
						// 				$info['costoTotal'] = $costoTotal;
						// 				$info['costoFleteTotal'] = $costoFleteTotal;

						// 				$query = "SELECT id, precioLista, cantidad, marca FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
						// 				$resultado = mysqli_query($conexion_usuarios, $query);
						// 				if (!$resultado) {
						// 					verificar_resultado($resultado);
						// 				}else{
						// 					$flete = 0;
						// 					$costoTotal = 0;
						// 					while($data = mysqli_fetch_array($resultado)){
						// 						$id = $data['id'];
						// 						$precioLista = $data['precioLista'];
						// 						$cantidad = $data['cantidad'];
						// 						$marca = $data['marca'];
						// 						$flete = $flete + (($precioLista * $cantidad) * $costoFleteTotal);
						// 						$flete = $flete / $cantidad;
						// 						$fleteHerramienta = $flete;
						// 						$info['flete'.$marca] = $fleteHerramienta;
						// 						$precioListaTotal = $precioLista + $fleteHerramienta;
						// 						$info['Total'.$marca] = $precioListaTotal;
						// 						$query = "UPDATE cotizacionherramientas SET flete ='".$fleteHerramienta."' WHERE id='".$id."'";
						// 						$resultado2 = mysqli_query($conexion_usuarios, $query);
						// 						$flete = 0;
						// 						$fleteHerramienta = 0;
						// 						$precioListaTotal = 0;
						// 					}
						// 					verificar_resultado($resultado2);
						// 				}
						// 			}
						// 		}
						// 	}
						// }
					}else{
						$query = "SELECT costoFlete FROM fletescotizacion WHERE refCotizacion ='$refCotizacion' AND proveedor = '$proveedorFlete'";
						$resultado = mysqli_query($conexion_usuarios, $query);
						while($data = mysqli_fetch_array($resultado)){
							$costoFlete = $data['costoFlete'];
						}
						$query = "SELECT precioLista, cantidad FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
						$resultado = mysqli_query($conexion_usuarios, $query);
						if (!$resultado) {
							verificar_resultado($resultado);
						}else{
							$costoTotal = 0;
							while($data = mysqli_fetch_array($resultado)){
								$precioLista = $data['precioLista'];
								$cantidad = $data['cantidad'];
								$costoTotal = $costoTotal + ($precioLista * $cantidad);
							}
							$costoFleteTotal = $costoFlete / $costoTotal;
							$info['costoFlete'] = $costoFlete;
							$info['costoTotal'] = $costoTotal;
							$info['costoFleteTotal'] = $costoFleteTotal;

							$query = "SELECT id, precioLista, cantidad, marca FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
							$resultado = mysqli_query($conexion_usuarios, $query);
							if (!$resultado) {
								verificar_resultado($resultado);
							}else{
								$flete = 0;
								$costoTotal = 0;
								while($data = mysqli_fetch_array($resultado)){
									$id = $data['id'];
									$precioLista = $data['precioLista'];
									$cantidad = $data['cantidad'];
									$marca = $data['marca'];
									$flete = $flete + (($precioLista * $cantidad) * $costoFleteTotal);
									$flete = $flete / $cantidad;
									$fleteHerramienta = $flete;
									$info['flete'.$marca] = $fleteHerramienta;
									$precioListaTotal = $precioLista + $fleteHerramienta;
									$info['Total'.$marca] = $precioListaTotal;
									$query = "UPDATE cotizacionherramientas SET flete ='".$fleteHerramienta."' WHERE id='".$id."'";
									$resultado2 = mysqli_query($conexion_usuarios, $query);
									$flete = 0;
									$fleteHerramienta = 0;
									$precioListaTotal = 0;
								}
								verificar_resultado($resultado2);
							}
						}
					}
				}
			}
		}
		$query = "SELECT TiempoEntrega FROM cotizacion WHERE ref = '$refCotizacion'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		while($data = mysqli_fetch_assoc($resultado)){
			if($tedias > $data['TiempoEntrega']){
				$query2 = "UPDATE cotizacion SET TiempoEntrega = '$tedias' WHERE ref = '$refCotizacion'";
				$res2 = mysqli_query($conexion_usuarios, $query2);
			}
		}
		cerrar($conexion_usuarios);
	}

	function eliminar($refCotizacion, $idherramienta, $conexion_usuarios){
		$query = "DELETE FROM cotizacionherramientas WHERE id =$idherramienta";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			verificar_resultado($resultado);
		}else{
			$query = "SELECT DISTINCT partidaCantidad FROM cotizacion WHERE ref='".$refCotizacion."'";
			$resultado = mysqli_query($conexion_usuarios, $query);
			if(!$resultado){
				verificar_resultado($resultado);	
			}else{
				while($data = mysqli_fetch_array($resultado)){
					$numPartidas = $data['partidaCantidad'];
				}
				$numPartidas--;
				$query = "UPDATE cotizacion SET partidaCantidad='".$numPartidas."' WHERE ref='".$refCotizacion."'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				if (!$resultado) {
					verificar_resultado($resultado);
				}else{
					$query = "SELECT precioLista,cantidad FROM cotizacionherramientas WHERE cotizacionRef = '".$refCotizacion."'";
					$resultado = mysqli_query($conexion_usuarios, $query);
					if (!$resultado) {
						verificar_resultado($resultado);
					}else{
						$precioTotal = 0;
						while ($data = mysqli_fetch_array($resultado)) {

							$precioTotal = $precioTotal + ( $data['precioLista'] * $data['cantidad'] );
						}
						$query = "UPDATE cotizacion SET precioTotal ='".$precioTotal."' WHERE ref ='".$refCotizacion."'";
						$resultado = mysqli_query($conexion_usuarios, $query);
						verificar_resultado($resultado);
						// acutalizarTotalFlete($refCotizacion, $conexion_usuarios);
					}
				}
			}
		}
		cerrar($conexion_usuarios);
	}

	function agregarFlete($refCotizacion, $proveedor, $totalFlete, $conexion_usuarios){
		$query = "INSERT INTO fletescotizacion (refCotizacion, proveedor, costoFlete) VALUES ('$refCotizacion', '$proveedor', '$totalFlete')";
		$resultado = mysqli_query($conexion_usuarios, $query);
		verificar_resultado($resultado);
		cerrar($conexion_usuarios);
	}

	function eliminarFlete($idflete, $conexion_usuarios){
		$query = "DELETE FROM fletescotizacion WHERE id =$idflete";
		$resultado = mysqli_query($conexion_usuarios, $query);
		verificar_resultado($resultado);
		cerrar($conexion_usuarios);
	}

	function editarFlete($idflete, $proveedor, $costoFlete, $refCotizacion, $conexion_usuarios){
		$query ="UPDATE fletescotizacion SET proveedor='$proveedor', costoFlete='$costoFlete' WHERE id=$idflete";
		$resultado = mysqli_query($conexion_usuarios, $query);
		verificar_resultado($resultado);
		cerrar($conexion_usuarios);
	}

	function acutalizarTotalFlete($refCotizacion, $conexion_usuarios){
		$query = "SELECT proveedor FROM fletescotizacion WHERE refCotizacion ='$refCotizacion'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			verificar_resultado($resultado);
		}else{
			while($data2 = mysqli_fetch_array($resultado)){
				$proveedorFlete = $data2['proveedor'];
				$query = "SELECT costoFlete FROM fletescotizacion WHERE refCotizacion ='$refCotizacion' AND proveedor = '$proveedorFlete'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				while($data = mysqli_fetch_array($resultado)){
					$costoFlete = $data['costoFlete'];
				}
				$query = "SELECT precioLista, cantidad FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				if (!$resultado) {
					verificar_resultado($resultado);
				}else{
					$costoTotal = 0;
					while($data = mysqli_fetch_array($resultado)){
						$precioLista = $data['precioLista'];
						$cantidad = $data['cantidad'];
						$costoTotal = $costoTotal + ($precioLista * $cantidad);
					}
					$costoFleteTotal = $costoFlete / $costoTotal;
					$info['costoFlete'] = $costoFlete;
					$info['costoTotal'] = $costoTotal;
					$info['costoFleteTotal'] = $costoFleteTotal;

					$query = "SELECT id, precioLista, cantidad, marca FROM cotizacionherramientas WHERE cotizacionRef='$refCotizacion' AND proveedorFlete = '$proveedorFlete'";
					$resultado = mysqli_query($conexion_usuarios, $query);
					if (!$resultado) {
						verificar_resultado($resultado);
					}else{
						$flete = 0;
						$costoTotal = 0;
						while($data = mysqli_fetch_array($resultado)){
							$id = $data['id'];
							$precioLista = $data['precioLista'];
							$cantidad = $data['cantidad'];
							$marca = $data['marca'];
							$flete = $flete + (($precioLista * $cantidad) * $costoFleteTotal);
							$flete = $flete / $cantidad;
							$fleteHerramienta = $flete;
							$info['flete'.$marca] = $fleteHerramienta;
							$precioListaTotal = $precioLista + $fleteHerramienta;
							$info['Total'.$marca] = $precioListaTotal;
							$query = "UPDATE cotizacionherramientas SET flete ='".$fleteHerramienta."' WHERE id='".$id."'";
							$resultado2 = mysqli_query($conexion_usuarios, $query);
							$flete = 0;
							$fleteHerramienta = 0;
							$precioListaTotal = 0;
						}
						verificar_resultado($resultado2);
					}
				}
			}
		}
	}

	function cambiarPedido($data, $refCotizacion, $numeroPedido, $numeroPartidas, $conexion_usuarios){
		$fecha = date("Y").'-'.date("m").'-'.date("d");
		$query = "SELECT * FROM cotizacion WHERE ref='$refCotizacion'";
		$resultado = mysqli_query($conexion_usuarios, $query);
		if (!$resultado) {
			$respuesta['respuesta'] = "ERROR 1";
		}else{
			while($datos = mysqli_fetch_assoc($resultado)){
				$idcliente = $datos['cliente'];
				$contacto = $datos['contacto'];
				$vendedor = $datos['vendedor'];
				$moneda = $datos['moneda'];
			}

			$total = 0.000;
			foreach ($data as &$valor) {
				$id = $valor;
				$query = "SELECT precioLista,flete,cantidad FROM cotizacionherramientas WHERE id='$id'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				while($precio = mysqli_fetch_assoc($resultado)){
					$total = $total + (($precio['precioLista'] + $precio['flete']) * $precio['cantidad']);
				}
			}	

			foreach ($data as &$valor) {
				$id = $valor;
				$pedido = "si";
				$query = "UPDATE cotizacionherramientas SET numeroPedido='$numeroPedido', fechaPedido='$fecha', pedidoFecha='$fecha', Pedido ='$pedido' WHERE cotizacionRef='$refCotizacion' AND id=$id";
				$resultado = mysqli_query($conexion_usuarios, $query);
			}

			if (!$resultado) {	
				$respuesta['respuesta'] = "ERROR 2";			
			}else{
				$query = "UPDATE cotizacion SET Pedido = '$fecha', NoPedClient = '$numeroPedido' WHERE ref='$refCotizacion'";
				$resultado = mysqli_query($conexion_usuarios, $query);
				if (!$resultado) {
					$respuesta['respuesta'] = "ERROR 3";
				}else{
					$entregado = "0000-00-00";
					$query = "INSERT INTO pedidos (cotizacionRef, numeroPedido, cliente, contacto, vendedor, fecha, partidas, total, entregado, moneda) VALUES ('$refCotizacion', '$numeroPedido', '$idcliente', '$contacto', '$vendedor', '$fecha', '$numeroPartidas', '$total', '$entregado', '$moneda')";
					$resultado = mysqli_query($conexion_usuarios, $query);
					if (!$resultado) {
						$respuesta['respuesta'] = "ERROR 4";
					}else{
						$respuesta['respuesta'] = "OK";
					}
				}
			}
		}
		
		echo json_encode($respuesta);
	}

	function verificar_resultado($resultado){
		if(!$resultado){
			$informacion["respuesta"] = "ERROR";
		}else{ 
			$informacion["respuesta"] = "BIEN";
		}
		echo json_encode($informacion);
	}

	function cerrar($conexion_usuarios){
		mysqli_close($conexion_usuarios);
	}

?>