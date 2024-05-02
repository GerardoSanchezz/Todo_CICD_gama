<?php
$user = "docker";
$password = "docker";
$database = "docker";
$table = "todo_list";

try {
    // Conectar a la base de datos
    $db = new PDO("mysql:host=database;dbname=$database", $user, $password);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Manejar los envíos de formularios para agregar, eliminar y actualizar tareas
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        if (isset($_POST['add'])) {
            // Agregar una nueva tarea
            $content = $_POST['content'];
            $stmt = $db->prepare("INSERT INTO $table (content) VALUES (:content)");
            $stmt->bindParam(':content', $content);
            $stmt->execute();
        } elseif (isset($_POST['delete'])) {
            // Eliminar una tarea
            $item_id = $_POST['item_id'];
            $stmt = $db->prepare("DELETE FROM $table WHERE item_id = :item_id");
            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->execute();
        } elseif (isset($_POST['update'])) {
            // Actualizar el contenido de una tarea
            $item_id = $_POST['item_id'];
            $new_content = $_POST['new_content'];
            $stmt = $db->prepare("UPDATE $table SET content = :new_content WHERE item_id = :item_id");
            $stmt->bindParam(':new_content', $new_content);
            $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);
            $stmt->execute();
        }
    }

    // Mostrar la lista de tareas
    echo "<h2>TODO</h2>";
    echo "<form method='POST'>";
    echo "<input type='text' name='content' placeholder='Agregar nueva tarea'>";
    echo "<button type='submit' name='add'>Agregar</button>";
    echo "</form>";
    
    echo "<ol>";
    $stmt = $db->query("SELECT item_id, content FROM $table");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<li>";
        echo htmlspecialchars($row['content']);
        echo " <form method='POST' style='display: inline;'>";
        echo "<input type='hidden' name='item_id' value='{$row['item_id']}'>";
        echo "<button type='submit' name='delete'>Eliminar</button>";
        echo "</form>";
        
        // Botón de actualización
        echo " <button onclick='showEditForm({$row['item_id']})'>Actualizar</button>";
        
        // Formulario de edición oculto inicialmente
        echo "<form method='POST' id='edit-form-{$row['item_id']}' style='display: none;' style='display: inline;'>";
        echo "<input type='hidden' name='item_id' value='{$row['item_id']}'>";
        echo "<input type='text' name='new_content' placeholder='Nuevo contenido' value='" . htmlspecialchars($row['content']) . "'>";
        echo "<button type='submit' name='update'>Guardar</button>";
        echo "</form>";
        
        echo "</li>";
    }
    echo "</ol>";
} catch (PDOException $e) {
    // Manejar errores de conexión a la base de datos
    echo "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>

<!-- Agregar JavaScript para manejar el evento de clic en el botón de actualización -->
<script>
function showEditForm(itemId) {
    // Ocultar todos los formularios de edición
    var forms = document.querySelectorAll('[id^="edit-form-"]');
    forms.forEach(function(form) {
        form.style.display = 'none';
    });
    
    // Mostrar el formulario de edición para la tarea específica
    var editForm = document.getElementById('edit-form-' + itemId);
    if (editForm) {
        editForm.style.display = 'inline';
    }
}
</script>