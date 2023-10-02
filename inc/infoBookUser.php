<div class="table-responsive">
    <table class="table table-hover table-bordered text-center">
        <thead>
            <tr>
                <th colspan="2" class="text-center lead success"><strong>Datos del libro</strong></th>
            </tr>
        </thead>
        <tbody>
            <tr><td><strong>Título</strong></td><td><?php echo $fila['Titulo']; ?></td></tr>
            <tr><td><strong>Autor</strong></td><td><?php echo $fila['Autor']; ?></td></tr>
            <tr><td><strong>País</strong></td><td><?php echo $fila['Pais']; ?></td></tr>
            <tr><td><strong>Año</strong></td><td><?php echo $fila['Year']; ?></td></tr>
            <tr><td><strong>Edición</strong></td><td><?php echo $fila['Edicion']; ?></td></tr>
            <tr><td><strong>Editorial</strong></td><td><?php echo $fila['Editorial']; ?></td></tr>
        </tbody>
  </table>
</div>