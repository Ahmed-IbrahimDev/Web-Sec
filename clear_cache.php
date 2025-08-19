<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear Cache & Session</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .cache-cleared {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
            border-radius: 10px;
            padding: 20px;
            margin: 20px 0;
            text-align: center;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0"><i class="fas fa-broom me-2"></i>Clear Cache & Session</h4>
                    </div>
                    <div class="card-body">
                        <?php
                        try {
                            echo "<div class='alert alert-info'><i class='fas fa-info-circle me-2'></i>Clearing application cache...</div>";
                            
                            // Clear Laravel cache
                            \Artisan::call('cache:clear');
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Application cache cleared</div>";
                            
                            // Clear config cache
                            \Artisan::call('config:clear');
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Config cache cleared</div>";
                            
                            // Clear route cache
                            \Artisan::call('route:clear');
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ Route cache cleared</div>";
                            
                            // Clear view cache
                            \Artisan::call('view:clear');
                            echo "<div class='alert alert-success'><i class='fas fa-check me-2'></i>✓ View cache cleared</div>";
                            
                            echo "<hr>";
                            
                            echo "<div class='cache-cleared'>";
                            echo "<h5><i class='fas fa-check-circle me-2'></i>Cache & Session Cleared Successfully!</h5>";
                            echo "<p>All application caches have been cleared. Please:</p>";
                            echo "<ol class='text-start'>";
                            echo "<li>Close all browser tabs for this application</li>";
                            echo "<li>Clear your browser cache (Ctrl+Shift+Delete)</li>";
                            echo "<li>Open a new tab and go to the login page</li>";
                            echo "<li>Try logging in with: admin@example.com / password</li>";
                            echo "</ol>";
                            echo "</div>";
                            
                        } catch (Exception $e) {
                            echo "<div class='alert alert-danger'>";
                            echo "<h5><i class='fas fa-exclamation-triangle me-2'></i>Error occurred!</h5>";
                            echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
                            echo "<strong>File:</strong> " . $e->getFile() . "<br>";
                            echo "<strong>Line:</strong> " . $e->getLine();
                            echo "</div>";
                        }
                        ?>
                        
                        <div class="text-center mt-4">
                            <a href="http://127.0.0.1:8000/login" class="btn btn-success me-2">
                                <i class="fas fa-sign-in-alt me-2"></i>Go to Login
                            </a>
                            <a href="http://127.0.0.1:8000/fix_login_data.php" class="btn btn-warning me-2">
                                <i class="fas fa-tools me-2"></i>Fix Login Data
                            </a>
                            <a href="http://127.0.0.1:8000/check_data.php" class="btn btn-info">
                                <i class="fas fa-database me-2"></i>Check Data
                            </a>
                        </div>
                        
                        <div class="alert alert-info mt-4">
                            <h6><i class='fas fa-lightbulb me-2'></i>Browser Cache Instructions:</h6>
                            <ul class="mb-0">
                                <li><strong>Chrome/Edge:</strong> Press Ctrl+Shift+Delete, select "Cached images and files", click "Clear data"</li>
                                <li><strong>Firefox:</strong> Press Ctrl+Shift+Delete, select "Cache", click "Clear Now"</li>
                                <li><strong>Brave:</strong> Press Ctrl+Shift+Delete, select "Cached images and files", click "Clear data"</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 