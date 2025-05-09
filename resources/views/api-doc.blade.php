<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Documentação da API - ShipSmart</title>
    <link rel="stylesheet" href="https://unpkg.com/swagger-ui-dist/swagger-ui.css">
    <style>
        html, body { margin: 0; padding: 0; height: 100%; }
        #swagger-ui { height: 100%; }
    </style>
</head>
<body>
    <div id="swagger-ui"></div>

    <script src="https://cdn.jsdelivr.net/npm/swagger-ui-dist@5/swagger-ui-bundle.js" defer></script>
    <script defer>
        document.addEventListener("DOMContentLoaded", function () {
            SwaggerUIBundle({
                url: "{{ asset('api-doc.json') }}",
                dom_id: '#swagger-ui',
                presets: [SwaggerUIBundle.presets.apis],
                layout: "BaseLayout"
            });
        });
    </script>
</body>
</html>
