<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>ACTA DE VERIFICACIÓN DE OFICIO</title>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; font-size: 12px; margin: 30px; }
        .center { text-align: center; }
        .bold { font-weight: bold; }
        .underline { text-decoration: underline; }
        .border { border: 1px solid #000; }
        .border-bottom { border-bottom: 1px solid #000; }
        .mb-2 { margin-bottom: 8px; }
        .mb-1 { margin-bottom: 4px; }
        .mt-2 { margin-top: 8px; }
        .mt-4 { margin-top: 16px; }
        .w-100 { width: 100%; }
        .w-33 { width: 33%; }
        .w-50 { width: 50%; }
        .w-20 { width: 20%; }
        .w-80 { width: 80%; }
        .text-xs { font-size: 10px; }
        .text-xxs { font-size: 8px; }
        .firma-box { border: 1px solid #000; height: 40px; }
        .huella-box { border: 1px solid #000; height: 40px; width: 60px; display: inline-block; }
        .firma-label { font-size: 9px; text-align: center; }
        .observaciones { min-height: 40px; border: 1px solid #000; padding: 4px; }
        .footer-table td { font-size: 9px; text-align: center; }
        .advertencia { border: 1px solid #000; font-size: 9px; padding: 4px; margin-top: 10px; }
        .subrayado { border-bottom: 1px solid #000; min-width: 60px; display: inline-block; }
    </style>
</head>
<body>
    <div class="center mb-1" style="position: relative; min-height: 80px;">
        <img src="{{ public_path('images/IUTV.png') }}" alt="Logo IUTV" style="position: absolute; left: 0; top: 0; height: 60px; width: auto;">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo" style="position: absolute; right: 0; top: 0; height: 60px; width: auto;">
        <span class="bold">ASESORÍA LEGAL</span><br>
        <span class="bold underline">ACTA DE VERIFICACIÓN DE OFICIO</span><br>
        <span class="bold">Fecha de emisión:</span> {{ date('d/m/Y') }}
    </div>
    @php
        $abogado = $registro->solicitud->abogado ?? null;
        $personaAbogado = $abogado ? ($abogado->persona ?? null) : null;
        $nombreAbogado = trim(
            ($personaAbogado->primer_nombre ?? '') . ' '
            . ($personaAbogado->segundo_nombre ?? '') . ' '
            . ($personaAbogado->primer_apellido ?? '') . ' '
            . ($personaAbogado->segundo_apellido ?? '')
        );
        $nombreAbogado = mb_strtoupper($nombreAbogado);
        $cedulaAbogado = mb_strtoupper($personaAbogado->cedula ?? '-');
        $credencialAbogado = mb_strtoupper($abogado->credencial ?? '-');
        $cargoAbogado = 'ABOGADO';
    @endphp
        Caracas, <span class="subrayado">&nbsp;</span> de <span class="subrayado">&nbsp;</span> de 2024.
    </div>
    <div class="mb-2">
        <div style="text-align: justify;">
            Siendo las <span class="subrayado">{{ $registro->hora ?? '' }}</span> horas de la <span class="subrayado">{{ $registro->momento ?? '' }}</span> del día de hoy, se trasladó al <span class="bold">CIRCUITO JUDICIAL PENAL MILITAR TRIBUNAL MILITAR 2º DE CONTROL CON SEDE CARACAS</span>, el abogado encargado <span class="bold">{{ $nombreAbogado }}</span>, titular de la Cédula de Identidad Nº V-<span class="bold">{{ $cedulaAbogado }}</span>, Credencial Nº <span class="bold">{{ $credencialAbogado }}</span>, Cargo: <span class="bold">{{ $cargoAbogado }}</span>, adscrito a Asesoría Legal Nacional, cumpliendo instrucciones del ciudadano Asesor Legal Nacional, Comisario General Juan De La Cruz Pereira, a fin de llevar a cabo la verificación de la Oficio Nº <span class="bold">{{ $registro->oficio_numero ?? '585-2024' }}</span>, de fecha <span class="bold">{{ $registro->oficio_fecha ?? '28/04/2024' }}</span>, dictado a favor del ciudadano(a) <span class="bold">{{ $registro->solicitud->solicitante->primer_nombre ?? '' }} {{ $registro->solicitud->solicitante->primer_apellido ?? '' }}</span>, titular de la Cédula de Identidad Nº V-<span class="bold">{{ $registro->solicitud->solicitante->cedula ?? '' }}</span>, emanado de ese Juzgador lo comento; mediante el cual ordena sea excluido del Sistema de Investigación e Información Policial (SIPPOL), motivado a <span class="bold">{{ $registro->motivo ?? 'SOBRESEIMIENTO' }}</span>, el cual guarda relación con la Causa del Tribunal Nº <span class="subrayado">{{ $registro->causa_tribunal ?? '' }}</span> Acta Procesal u Oficio Nº <span class="subrayado">{{ $registro->acta_oficio ?? '' }}</span>, fecha de omisión/aprehensión <span class="subrayado">{{ $registro->fecha_omision ?? '' }}</span>, por el delito de <span class="subrayado">{{ $registro->delito ?? '' }}</span>, siendo atendido en el prenominado Tribunal por un(a) ciudadano(a) quien dijo ser y llamarse <span class="subrayado">{{ $registro->atendido_por ?? '' }}</span>, titular de la Cédula de Identidad Nº V-<span class="subrayado">{{ $registro->cedula_atendido ?? '' }}</span> con el cargo de <span class="subrayado">{{ $registro->cargo_atendido ?? '' }}</span> indicando que ciertamente el oficio/sentencia antes mencionado(a) fue librado(a) <span class="subrayado">{{ $registro->oficio_librado ?? '' }}</span> No fue librado(a) <span class="subrayado">{{ $registro->oficio_no_librado ?? '' }}</span> y que los datos suministrados en el(la) mismo(a) son: <span class="subrayado">{{ $registro->datos_son ?? '' }}</span> no son: <span class="subrayado">{{ $registro->datos_no_son ?? '' }}</span> fiel y exacto del expediente físico que reposa en el Tribunal. Por lo que el funcionario abajo firmante considera que dicho oficio se encuentra: <span class="bold">APTO</span>: <span class="subrayado">{{ $registro->apto ?? '' }}</span> NO APTO: <span class="subrayado">{{ $registro->no_apto ?? '' }}</span> para llevar a cabo el Trámite correspondiente.
        </div>
    </div>
    <div class="mb-2">
        <span class="bold">OBSERVACIONES:</span>
        <div class="observaciones"></div>
        Es todo cuanto tengo que informar. Termino, se leyó y conforme firma.
    </div>
    <table class="w-100 mt-2" style="margin-bottom: 10px;">
        <tr>
            <td class="center bold" colspan="3">FIRMAS Y HUELLAS</td>
        </tr>
        <tr>
            <td class="center">FIRMA DEL FUNCIONARIO CICPC VERIFICADOR</td>
            <td class="center">HUELLAS DACTILARES DEL FUNCIONARIO CICPC VERIFICADOR</td>
            <td class="center">SELLO Y FIRMA DEL FUNCIONARIO DEL TRIBUNAL</td>
        </tr>
        <tr style="height: 50px;">
            <td class="firma-box"></td>
            <td class="center">
                <div class="huella-box"></div>
                <div class="huella-box"></div>
                <div class="huella-box"></div>
            </td>
            <td class="firma-box"></td>
        </tr>
        <tr>
            <td class="firma-label">PRESENCIAL</td>
            <td class="firma-label">&nbsp;</td>
            <td class="firma-label">&nbsp;</td>
        </tr>
    </table>
    <div class="advertencia">
        <span class="bold">ADVERTENCIA:</span> Solamente estarán facultados para la utilización de dicha Acta de Verificación los funcionarios adscritos al CICPC autorizados por el Asesor Legal Nacional, siendo responsable penal, civil, administrativa o disciplinariamente funcionarios o terceras personas que hagan uso de este instrumento sin la autorización o facultades correspondientes establecidas.
    </div>
    <table class="w-100 footer-table mt-4" style="margin-top: 18px;">
        <tr>
            <td class="w-33">Elaborado por:</td>
            <td class="w-33">Relación Pedro Popular</td>
            <td class="w-33">Justicia y Paz</td>
        </tr>
        <tr>
            <td colspan="3" class="center text-xs">Sede Principal CICPC. Mezclarina 2. Distrito Central</td>
        </tr>
        <tr>
            <td colspan="3" class="center text-xs">Documento generado el: {{ date('d/m/Y') }}</td>
        </tr>
    </table>
</body>
</html>
