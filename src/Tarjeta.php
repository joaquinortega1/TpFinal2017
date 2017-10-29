<?php
	
class Tarjeta {	
	
protected $saldoactual, $viajeshechos;

public function saldo() {
		return $this->saldoactual;
	}
public function mostrarviajeshechos() {
		return $this->viajeshechos;
	}
public function pagar( Transporte $transporte, $tipo_boleto ) {
		
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
