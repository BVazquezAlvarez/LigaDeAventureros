<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?= setting('app_name') ?></title>
        <style>
            .body {
                font-family: Arial, sans-serif;
                background-color: #f0f0f0;
                padding-top: 20px;
            }
            .container {
                background-color: #fff;
                border-radius: 5px;
                box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
                max-width: 600px;
                margin: 0 auto;
                padding: 20px;
            }
            h1 {
                color: #333;
                margin-top: 0;
            }
            p, ul {
                color: #666;
            }
            .button {
                background-color: #007BFF;
                color: #fff !important;
                padding: 10px 20px;
                text-decoration: none;
                border-radius: 3px;
                display: inline-block;
            }
            .footer {
                margin-top: 2em;
                background-color: #333;
                color: #fff !important;
                padding: 10px;
                text-align: center;
            }
            .rojo {
                color: #ff6347;
            }
        </style>
    </head>
    <body class="body">
        <div class="container">
            <?= view($main) ?>
        </div>
        <div class="footer">
            © <?= date('Y') ?> <?= setting('app_name') ?>
        </div>
    </body>
</html>