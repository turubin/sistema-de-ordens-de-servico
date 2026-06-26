<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Sistema de Ordens de Serviço</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #007bff, #6610f2);
            color: #fff;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .menu-container {
            background: rgba(255, 255, 255, 0.1);
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 0 20px rgba(0,0,0,0.2);
            backdrop-filter: blur(6px);
        }

        .menu-btn {
            width: 100%;
            height: 130px;
            font-size: 1.3rem;
            font-weight: 600;
            border-radius: 1rem;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .menu-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 0 15px rgba(0,0,0,0.3);
        }

        .menu-icon {
            font-size: 2rem;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="container menu-container">
        <h1 class="mb-5 fw-bold">Sistema de Ordens de Serviço</h1>
        <div class="row g-4 justify-content-center">
            <div class="col-12 col-md-4">
                <a href="cliente.php" class="btn btn-light text-primary menu-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-people-fill menu-icon"></i>
                    Clientes
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="tecnico.php" class="btn btn-light text-success menu-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-wrench-adjustable-circle-fill menu-icon"></i>
                    Técnicos
                </a>
            </div>
            <div class="col-12 col-md-4">
                <a href="ordem_servico.php" class="btn btn-light text-warning menu-btn d-flex flex-column align-items-center justify-content-center">
                    <i class="bi bi-clipboard2-check-fill menu-icon"></i>
                    Ordens de Serviço
                </a>
            </div>
        </div>
    </div>
</body>
</html>
