<?php
namespace TpFinal;
class Tarjeta {	
	//falta funcion cargar tarjeta.
public function saldo() {
	return $this->saldo;
	}
public function mostrarviajeshechos() {
		return $this->viajeshechos;
	}
public function viajes_plus() {
		return $this->viajes_plus;
	}
public function pagar( Transporte $transporte, $tipo_boleto ) {
		if ( ! in_array( $tipo_boleto, $this->tipos_boletos ) ) {
			return;
		}
		$array_viajes = $this->viajeshechos();
		$ultimo_viaje = end( $array_viajes );
		if ( $transporte instanceof Colectivo ) {
			if ( false == $ultimo_viaje ) {
				$monto = $transporte->get_boleto( $tipo_boleto );
				$viaje = new Viaje( $transporte, $monto );
				$this->viajeshechos[] = $viaje;
				$this->descontar_de_saldo( $monto );
			} elseif ( $ultimo_viaje->es_apto_para_trasbordo( $transporte ) ) {
				$monto = $transporte->get_trasbordo( $tipo_boleto );
				$viaje = new Viaje( $transporte, $monto );
				$this->viajeshechos[] = $viaje;
				$this->descontar_de_saldo( $monto );
				} else {
					$monto = $transporte->get_boleto( $tipo_boleto );
					$viaje = new Viaje( $transporte, $monto );
					$this->viajeshechos[] = $viaje;
					$this->descontar_de_saldo( $monto );
				}
		} else {
			$flag = 1;
			foreach( $this->mostrarviajeshechos() as $viaje ) { 
				if ( 'En bicicleta' == $viaje->get_tipo() && ( $ultimo_viaje->get_fecha_y_hora() + 86400 ) <= time() ) {
					$flag = 0;
					break;
				}
			}
			if ( $flag == 1 ) {
				$monto = $transporte->get_boleto_bici();
				$viaje = new Viaje( $transporte, $monto );
				$this->viajeshechos[] = $viaje;
				$this->descontar_de_saldo( $monto );
			} else {
				$monto = 0.0;
				$viaje = new Viaje( $transporte, $monto );
				$this->viajeshechos[] = $viaje;
				$this->descontar_de_saldo( $monto );
			}
		}
	}
	protected function descontar_de_saldo( $monto ) {
		if ( 2 >= $this->viajes_plus ) {
			$this->saldo -= $monto;
			if ( 0 > $this->saldo ) {
				$this->viajes_plus++;
			}
			return true;
		} else {
			return false;
		}
	}
		protected $tipos_boletos = ['Comun','Bici','MedioBoleto'];
	protected $saldo, $viajeshechos, $viajes_plus;
}
