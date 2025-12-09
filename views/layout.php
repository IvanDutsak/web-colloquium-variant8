<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? htmlspecialchars($title) . ' - ' : ''; ?>Course Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            overflow: hidden;
        }
        
        header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        header h1 {
            margin-bottom: 10px;
        }
        
        nav {
            background: #f8f9fa;
            padding: 0;
            border-bottom: 1px solid #dee2e6;
            display: flex;
        }
        
        nav a {
            flex: 1;
            padding: 15px;
            text-decoration: none;
            color: #333;
            text-align: center;
            border-right: 1px solid #dee2e6;
            transition: background 0.3s;
        }
        
        nav a:last-child {
            border-right: none;
        }
        
        nav a:hover {
            background: #e9ecef;
        }
        
        nav a.active {
            background: #667eea;
            color: white;
        }
        
        main {
            padding: 30px;
            min-height: 400px;
        }
        
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
            border-left: 4px solid #28a745;
            background: #d4edda;
            color: #155724;
        }
        
        .alert.error {
            border-left-color: #dc3545;
            background: #f8d7da;
            color: #721c24;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        table thead {
            background: #f8f9fa;
        }
        
        table th {
            padding: 12px;
            text-align: left;
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        
        table td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
        }
        
        table tbody tr:hover {
            background: #f8f9fa;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            transition: background 0.3s;
            font-size: 14px;
        }
        
        .btn:hover {
            background: #764ba2;
        }
        
        .btn-small {
            padding: 5px 10px;
            font-size: 12px;
        }
        
        .btn-danger {
            background: #dc3545;
        }
        
        .btn-danger:hover {
            background: #c82333;
        }
        
        .btn-success {
            background: #28a745;
        }
        
        .btn-success:hover {
            background: #218838;
        }
        
        .form-group {
            margin-bottom: 20px;
        }
        
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 500;
            color: #333;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            font-size: 14px;
            font-family: inherit;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        
        .card {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 5px;
            padding: 20px;
            margin-bottom: 20px;
        }
        
        .card h3 {
            margin-bottom: 10px;
            color: #333;
        }
        
        .stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-box {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }
        
        .stat-box .number {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .stat-box .label {
            font-size: 14px;
            opacity: 0.9;
        }
        
        footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            color: #666;
            border-top: 1px solid #dee2e6;
            font-size: 12px;
        }
        
        .empty-state {
            text-align: center;
            padding: 40px;
            color: #999;
        }
        
        .empty-state p {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <h1>📚 Course Management System</h1>
            <p>Система управління курсами та студентами</p>
        </header>
        
        <nav>
            <a href="index.php?action=courses" class="<?php echo ($action ?? 'courses') === 'courses' ? 'active' : ''; ?>">
                📖 Курси
            </a>
            <a href="index.php?action=students" class="<?php echo ($action ?? '') === 'students' ? 'active' : ''; ?>">
                👥 Студенти
            </a>
        </nav>
        
        <main>
            <?php if (isset($_SESSION['message'])): ?>
                <div class="alert">
                    <?php echo htmlspecialchars($_SESSION['message']); ?>
                </div>
                <?php unset($_SESSION['message']); ?>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert error">
                    <?php echo htmlspecialchars($_SESSION['error']); ?>
                </div>
                <?php unset($_SESSION['error']); ?>
            <?php endif; ?>
            
            <!-- Вміст сторінки буде вставлено тут -->
            <?php require_once $contentFile; ?>
        </main>
        
        <footer>
            <p>© 2025 Course Management System | Варіант 8: Зв'язки між сутностями та DRY принцип</p>
        </footer>
    </div>
</body>
</html>
