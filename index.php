<?php
$db = new PDO('sqlite:database.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS tareas (
    id   INTEGER PRIMARY KEY AUTOINCREMENT,
    nombre      TEXT NOT NULL,
    descripcion TEXT
)");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $db->prepare("INSERT INTO tareas (nombre, descripcion) VALUES (?, ?)");
    $stmt->execute([$_POST['nombre'], $_POST['descripcion']]);
    header('Location: index.php');
    exit;
}


$tareas = $db->query("SELECT * FROM tareas ORDER BY id DESC")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Tareas – SQLite</title>
   
</head>
<body>
<div class="container">

    <h1> Registro de Tareas</h1>

 
    <form method="POST">
        <h2>Nueva tarea</h2>

        <label for="nombre">Nombre de la tarea</label>
        <input type="text" id="nombre" name="nombre" placeholder="Nombre de la tarea" required>

        <label for="descripcion">Descripción</label>
        <textarea id="descripcion" name="descripcion" placeholder="Descripcion"></textarea>

        <button type="submit">Guardar tarea</button>
    </form>


    <div class="tabla-wrap">
        <h2>Tareas registradas</h2>

        <?php if (empty($tareas)): ?>
            <p class="empty">Aún no hay tareas registradas.</p>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nombre</th>
                        <th>Descripción</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($tareas as $tarea): ?>
                    <tr>
                        <td><?= $tarea['id'] ?></td>
                        <td><?= htmlspecialchars($tarea['nombre']) ?></td>
                        <td><?= htmlspecialchars($tarea['descripcion']) ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

</div>
</body>
</html>
