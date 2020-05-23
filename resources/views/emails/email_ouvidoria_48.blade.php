<html>
    <body>
        <p>ATENÇÃO! Faltam 48 horas.</p>
        <p>A demanda de Protocolo Nº {{ str_pad($protocolo, 14, 0, STR_PAD_LEFT) }}, ainda não foi Concluída ou Fechada</p>
        <p><a href="{{ route('ouvidoria.edit', $ouvidoria_id) }}">Clique aqui.</a></p>
    </body>
</html>