<?php
	
class Tarjeta {	
	
protected $saldoactual, $viajeshechos;

public function saldo() {
		return $this->saldoactual;
	}
public function mostrarviajeshechos() {
		return $this->viajeshechos;
	}
public function pagar( Transporte $transporte) {
		$fh=new DateTime();
		$fhv = $fh->format('Y-m-d-H-i-s');
		$Viaje = new Viaje ($transporte, $fhv);
		$this->viajeshechos[] = $Viaje;
	}
public function recargar($monto){
	   if($monto == 332) {
            $this->saldoactual += 388;
        }else{
            if($monto == 500) {
                $this->saldoactual += 652;          
            }
        }else{
            $this->saldoactual += $monto;
        }
}

}

abstract class Transporte {
	public $boleto;
}
class Bicicleta extends Transporte {
	public $boleto = 14.55;
	public $patente;
	public function __construct( $patente ) {
		$this->patente = $patente;
	}
}
