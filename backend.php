<?php

function converterParaSegundos($hora = ''){
    if($hora == ''){
        return $hora;
    }
    $segundos = list($horas, $minutos) = explode(':', $hora);
    $segundos = $horas * 3600 + $minutos * 60;
    return $segundos;
}

function converterParaHoras($segundos = ''){
    if($segundos == ''){
        return $segundos;
    }
    $horas = floor($segundos / 3600);
    $minutos = floor($segundos % 3600 / 60);

    return sprintf("%02d:%02d",$horas,$minutos);
}

function auditoriaDePonto($parametros){
    $alertas = [];

    if($parametros->horaSaidaIntervalo > ($parametros->horaEntrada + $parametros->maxHorasCorridas)){
        $alertas[] = '<strong>ALERTA! Você ultrapassou '.converterParaHoras($parametros->maxHorasCorridas).' horas corridas, até a saída para o intervalo, risco de advertência!</strong>';
    }

    if($parametros->intervaloRealizado > $parametros->maxIntervalo){
        $alertas[] = '<strong>ALERTA! Você realizou mais de '.converterParaHoras($parametros->maxIntervalo).' de intervalo, risco de advertência!</strong>';
    }

    if($parametros->intervaloRealizado < $parametros->minIntervalo){
        $alertas[] = '<strong>ALERTA! Você realizou menos de '.converterParaHoras($parametros->minIntervalo).' de intervalo, risco de advertência!</strong>';
    }

    if($parametros->horaSaida > $parametros->saidaComHorasExtras){
        $alertas[] = '<strong>ALERTA! Você ultrapassou '.converterParaHoras($parametros->maxHorasCorridas).' horas corridas até ir embora, ou estourou o limite de horas extras diárias, risco de advertência!</strong>';
    }
    
    if ($alertas != []) {
        $msg = '';
        foreach ($alertas as $chave => $alerta) {

            $msg .= '<br>->'.$alerta;
        }
        return $msg;
    }else{
        return '-> Sem alertas!';
    }
}

function calcular($parametros){

    if($parametros->horaVoltaIntervalo == '' && $parametros->horaSaida == ''){

        $voltaIntervalo = $parametros->horaSaidaIntervalo + $parametros->tempoIntervalo;

$parametros->intervaloRealizado = $parametros->tempoIntervalo;
        $parametros->saidaSemHorasExtras = $parametros->horaEntrada + $parametros->tempoIntervalo + $parametros->cargaHoraria;
        $parametros->saidaComHorasExtras = $parametros->horaEntrada + $parametros->tempoIntervalo + $parametros->cargaHoraria + $parametros->maxHorasExtras;

        if($parametros->saidaComHorasExtras <= ($voltaIntervalo + $parametros->maxHorasCorridas)){
            $parametros->saidaComHorasExtras = $parametros->saidaComHorasExtras;
        }else{
            $parametros->saidaComHorasExtras = $voltaIntervalo + $parametros->maxHorasCorridas;
        }

            $resultado = '
            <strong>'.auditoriaDePonto($parametros).'</strong>
            <br>
            -> Você deve retornar ás '.converterParaHoras($voltaIntervalo).' do intervalo;
            <br>
            -> Comprindo a carga horária de '.converterParaHoras($parametros->cargaHoraria).', poderá sair ás '.converterParaHoras($parametros->saidaSemHorasExtras).';
            <br>
            -> Poderá trabalhar até, no máximo ás '.converterParaHoras($parametros->saidaComHorasExtras).', realizando horas extras.
            ';
            
            return $resultado;
        
    }

    if($parametros->horaVoltaIntervalo != '' && $parametros->horaSaida == ''){

        $parametros->intervaloRealizado = $parametros->horaVoltaIntervalo - $parametros->horaSaidaIntervalo;

        $parametros->saidaSemHorasExtras = $parametros->horaEntrada + $parametros->intervaloRealizado + $parametros->cargaHoraria;
        $parametros->saidaComHorasExtras = $parametros->horaEntrada + $parametros->intervaloRealizado + $parametros->cargaHoraria + $parametros->maxHorasExtras;

        if($parametros->saidaComHorasExtras <= ($parametros->horaVoltaIntervalo + $parametros->maxHorasCorridas)){
            $parametros->saidaComHorasExtras = $parametros->saidaComHorasExtras;
        }else{
            $parametros->saidaComHorasExtras = $parametros->horaVoltaIntervalo + $parametros->maxHorasCorridas;
        }
            $resultado = '
            <strong>'.auditoriaDePonto($parametros).'</strong>
            <br>
            -> Você realizou '.converterParaHoras($parametros->intervaloRealizado).' de intervalo;
            <br>
            -> Comprindo a carga horária de '.converterParaHoras($parametros->cargaHoraria).', poderá sair ás '.converterParaHoras( $parametros->saidaSemHorasExtras).';
            <br>
            -> Poderá trabalhar até, no máximo ás '.converterParaHoras($parametros->saidaComHorasExtras).', realizando horas extras.
            ';
        
            return $resultado;
        
    }

    if($parametros->horaVoltaIntervalo != '' && $parametros->horaSaida != ''){

        $parametros->intervaloRealizado = $parametros->horaVoltaIntervalo - $parametros->horaSaidaIntervalo;

        $parametros->saidaSemHorasExtras = $parametros->horaEntrada + $parametros->intervaloRealizado + $parametros->cargaHoraria;
        $parametros->saidaComHorasExtras = $parametros->horaEntrada + $parametros->intervaloRealizado + $parametros->cargaHoraria + $parametros->maxHorasExtras;

        $cargaHorariaCumprida = $parametros->horaSaida - $parametros->intervaloRealizado - $parametros->horaEntrada;

        if($parametros->saidaComHorasExtras <= ($parametros->horaVoltaIntervalo + $parametros->maxHorasCorridas)){
            $parametros->saidaComHorasExtras = $parametros->saidaComHorasExtras;
        }else{
            $parametros->saidaComHorasExtras = $parametros->horaVoltaIntervalo + $parametros->maxHorasCorridas;
        }
            $resultado = '
            <strong>'.auditoriaDePonto($parametros).'</strong>
            <br>
            -> Você realizou '.converterParaHoras($parametros->intervaloRealizado).' de intervalo;
            <br>
            -> Cumpriu a carga horária de '.converterParaHoras($cargaHorariaCumprida).' horas;
            <br>
            ';
        
            return $resultado;
        
    }

    $_SESSION['alert'] = '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Ops! Faltou preencher algo.</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

if (isset($_POST['calcular']) && 
    isset($_POST['horaEntrada']) && 
    isset($_POST['horaSaidaIntervalo']) &&
    isset($_POST['tempoIntervalo']) &&
    $_POST['horaEntrada'] != '' &&
    $_POST['horaSaidaIntervalo'] != '' &&
    $_POST['tempoIntervalo'] != ''
    ){

        $parametros = json_encode(
            [
            "horaEntrada"        => converterParaSegundos($_POST['horaEntrada']),
            "horaSaidaIntervalo" => converterParaSegundos($_POST['horaSaidaIntervalo']),
            "horaVoltaIntervalo" => converterParaSegundos($_POST['horaVoltaIntervalo']),
            "horaSaida"          => converterParaSegundos($_POST['horaSaida']),
            "tempoIntervalo"     => converterParaSegundos($_POST['tempoIntervalo']),
            "intervaloRealizado" => '',
            "saidaSemHorasExtras" => '',
            "saidaComHorasExtras" => '',
            "cargaHoraria"       => converterParaSegundos('07:20'),
            "maxHorasExtras"     => converterParaSegundos('01:55'),
            "minIntervalo"       => converterParaSegundos('01:05'),
            "maxIntervalo"       => converterParaSegundos('01:55'),
            "maxHorasCorridas"   => converterParaSegundos('05:55'),
            "minDescandoEntreJornadas"   => converterParaSegundos('11:05'),
            ]
            );

        $parametros = json_decode($parametros);

        $_SESSION['parametros'] = $parametros;
        $_SESSION['jornadaCalculada'] = calcular($parametros);

}elseif(isset($_POST['calcular'])){
    $_SESSION['alert'] = '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Preencha os campos obrigatórios!</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>';
}

