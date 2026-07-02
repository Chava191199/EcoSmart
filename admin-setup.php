<?php
session_start();
include 'config/conexion.php';

$mensaje = '';
$exito = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $correo = isset($_POST['correo']) ? trim($_POST['correo']) : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    
    if (empty($correo) || empty($password)) {
        $mensaje = 'Por favor completa todos los campos.';
    } else {
        
        // Buscar usuario por correo
        $stmt = $conexion->prepare('SELECT id, password, rol FROM usuarios WHERE correo = ? LIMIT 1');
        
        if ($stmt) {
            $stmt->bind_param('s', $correo);
            $stmt->execute();
            $resultado = $stmt->get_result();
            
            if ($resultado->num_rows > 0) {
                $usuario = $resultado->fetch_assoc();
                
                // Verificar contraseña
                if (password_verify($password, $usuario['password'])) {
                    
                    // Actualizar rol a admin
                    $stmt2 = $conexion->prepare('UPDATE usuarios SET rol = ? WHERE id = ?');
                    if ($stmt2) {
                        $rol_nuevo = 'admin';
                        $stmt2->bind_param('si', $rol_nuevo, $usuario['id']);
                        
                        if ($stmt2->execute()) {
                            $exito = true;
                            $mensaje = '✅ ¡Felicidades! Tu cuenta ha sido promovida a administrador. Ya puedes acceder al panel admin.';
                            // Actualizar sesión si el usuario está logueado
                            if (isset($_SESSION['id']) && $_SESSION['id'] == $usuario['id']) {
                                $_SESSION['rol'] = 'admin';
                            }
                        } else {
                            $mensaje = 'Error al actualizar el rol. Intenta más tarde.';
                        }
                        $stmt2->close();
                    }
                } else {
                    $mensaje = '❌ Contraseña incorrecta.';
                }
            } else {
                $mensaje = '❌ Correo no encontrado en la base de datos.';
            }
            
            $stmt->close();
        } else {
            $mensaje = 'Error del servidor. Intenta más tarde.';
        }
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configuración de Administrador - EcoSmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        .setup-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            padding: 40px;
            max-width: 400px;
            width: 100%;
        }
        
        .setup-container h1 {
            text-align: center;
            color: #333;
            margin-bottom: 10px;
            font-size: 28px;
        }
        
        .setup-container p {
            text-align: center;
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }
        
        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 12px;
            margin-bottom: 15px;
            transition: all 0.3s;
        }
        
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        
        .btn-setup {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            cursor: pointer;
            transition: all 0.3s;
        }
        
        .btn-setup:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        
        .alert {
            border-radius: 8px;
            margin-bottom: 20px;
            border: none;
        }
        
        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
        
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .alert-warning {
            background-color: #fff3cd;
            color: #856404;
        }
        
        .info-box {
            background: #f0f4ff;
            border-left: 4px solid #667eea;
            padding: 15px;
            border-radius: 5px;
            margin-top: 20px;
            font-size: 13px;
            color: #333;
        }
    </style>
</head>
<body>

<div class="setup-container">
    
    <h1>🔧 Configuración Admin</h1>
    <p>Convierte tu cuenta en administrador</p>
    
    <?php if (!empty($mensaje)): ?>
        <div class="alert <?php echo $exito ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo htmlspecialchars($mensaje); ?>
        </div>
    <?php endif; ?>
    
    <?php if (!$exito): ?>
        
        <form method="POST">
            
            <div>
                <label for="correo" class="form-label">📧 Correo</label>
                <input 
                    type="email" 
                    class="form-control" 
                    id="correo" 
                    name="correo" 
                    placeholder="tu@correo.com" 
                    required>
            </div>
            
            <div>
                <label for="password" class="form-label">🔐 Contraseña</label>
                <input 
                    type="password" 
                    class="form-control" 
                    id="password" 
                    name="password" 
                    placeholder="Tu contraseña" 
                    required>
            </div>
            
            <button type="submit" class="btn-setup">
                Hacer Administrador
            </button>
            
        </form>
        
        <div class="info-box">
            <strong>⚠️ Importante:</strong><br>
            Este formulario solo funciona una vez. Después de que tu cuenta sea promovida a administrador, <strong>debes eliminar este archivo</strong> por seguridad.
            <br><br>
            Accede a tu hosting (FTP o File Manager) y elimina el archivo <code>admin-setup.php</code>.
        </div>
        
    <?php else: ?>
        
        <div class="info-box" style="background: #d4edda; border-color: #28a745; color: #155724;">
            <strong>✅ ¡Éxito!</strong><br>
            Tu cuenta ha sido promovida a administrador.
            <br><br>
            <a href="index.php" style="color: #155724; text-decoration: underline;">Ir al inicio</a> para acceder al panel admin desde el navbar.
            <br><br>
            <strong>⚠️ IMPORTANTE:</strong> Elimina este archivo (<code>admin-setup.php</code>) del servidor por seguridad. 
            Accede vía FTP o File Manager de InfinityFree y bórralo.
        </div>
        
    <?php endif; ?>

</div>

</body>
</html>
