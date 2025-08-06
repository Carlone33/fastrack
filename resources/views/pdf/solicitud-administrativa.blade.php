<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>PDF Solicitud Administrativa</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h1, h2, h3 { color: #be123c; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        td, th { border: 1px solid #ccc; padding: 8px; }
        .header-logos { width: 100%; display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .header-logos img { height: 50px; }
        .footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            font-size: 10px;
            color: #888;
            text-align: center;
            border-top: 1px solid #ccc;
            padding-top: 8px;
            background: #fff;
        }
    </style>
</head>
<body>
    <div class="header-logos">
        <img src="{{ public_path('images/logo.png') }}" alt="Logo CICPC">
        <div>
            <h2 style="text-align:center; margin-bottom: 2px;">ASESORÍA LEGAL CICPC</h2>
            <h3 style="text-align:center; margin-bottom: 2px;">SOLICITUD ADMINISTRATIVA</h3>
        </div>
        <img src="{{ public_path('images/iutv.png') }}" alt="Logo IUTV">
    </div>
    <table style="width:100%; margin-bottom: 20px;">
        <tr>
            <td>Caracas, ____ de ____________ de 2024</td>
            <td style="text-align:right;">Hora: ______</td>
        </tr>
    </table>
    <p style="margin-top: 10px; font-size: 0.95em; line-height: 1.5; text-align:justify;">
        Siendo las ____ horas del día de hoy, el abogado responsable <strong>{{ $registro->solicitud->abogado->persona->primer_nombre ?? '-' }} {{ $registro->solicitud->abogado->persona->primer_apellido ?? '-' }}</strong>, cumpliendo instrucciones y bajo el marco de un convenio interno del CICPC, emite la presente acta para dejar constancia de que la persona <strong>{{ $registro->solicitud->solicitante->primer_nombre ?? '-' }} {{ $registro->solicitud->solicitante->primer_apellido ?? '-' }}</strong> será excluida del Sistema de Investigación Policial, en virtud de un caso de estudio y conforme a los acuerdos institucionales vigentes, quedando libre de cualquier procedimiento o registro que pudiera afectarle.
    </p>
    <table style="width:100%; margin-top:30px;">
        <tr>
            <td style="width:33%; text-align:center; font-size:0.95em;">FIRMA DEL FUNCIONARIO CICPC VERIFICADOR<br><br><br>__________________________</td>
            <td style="width:33%; text-align:center; font-size:0.95em;">HUELLAS DACTILARES DEL FUNCIONARIO CICPC VERIFICADOR<br><br><br>__________________________</td>
            <td style="width:33%; text-align:center; font-size:0.95em;">COORDINACIÓN DE ASESORÍA LEGAL<br><br><br>__________________________</td>
        </tr>
    </table>
    <div style="margin-top:20px; font-size:0.95em;">
        <strong>OBSERVACIONES:</strong> _______________________________________________________________________________________
    </div>
    <div style="margin-top:30px; font-size:0.85em; text-align:center; color:#888;">
        Es todo cuanto tengo que informar. Termino, se leyó y conforme firma.
    </div>
    <div class="footer">
        Documento generado electrónicamente por el sistema CICPC. Para dudas o validaciones, acuda a la Asesoría Legal CICPC o al IUTV.<br>
        © CICPC - IUTV {{ date('Y') }}
    </div>
</body>
</html>
