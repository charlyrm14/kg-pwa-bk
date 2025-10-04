<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Credenciales de acceso | King Dreams </title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
        table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
        img { -ms-interpolation-mode: bicubic; }
        .brand-primary { background-color: #2b7fff; }
        .brand-secondary { color: #374151; }
        .text-dark { color: #1f2937; }
    </style>
</head>
<body class="bg-gray-100" style="margin: 0; padding: 0;">

    <table border="0" cellpadding="0" cellspacing="0" width="100%" class="bg-gray-100" role="presentation">
        <tr>
            <td align="center" style="padding: 20px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;" class="bg-white rounded-lg shadow-xl" role="presentation">
                    
                    <tr>
                        <td align="center" class="brand-primary rounded-t-lg" style="padding: 30px 20px; border-radius: 8px 8px 0 0;">
                            <h1 class="text-3xl font-bold text-dark" style="margin: 0; color: #FFF;">
                                King dreams
                            </h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 40px 30px 40px 30px;" class="text-dark">
                            <h2 class="text-2xl font-semibold mb-6 brand-secondary" style="margin-top: 0; margin-bottom: 24px; color: #374151;">
                                ¡Hola, {{ $user->name }}!
                            </h2>
                            
                            <p class="mb-6 text-base" style="margin-bottom: 24px;">
                                Hemos generado una contraseña temporal para que puedas acceder a tu cuenta. Úsala para iniciar sesión y, por seguridad, te recomendamos cambiarla inmediatamente después.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" class="mb-8" role="presentation" style="margin-bottom: 32px;">
                                <tr>
                                    <td align="center" style="padding: 20px 10px; border: 1px solid #e5e7eb; background-color: #f3f4f6; border-radius: 8px;">
                                        <p class="text-lg font-bold text-dark" style="margin: 0; font-size: 1.125rem; color: #1f2937;">
                                            Tu Contraseña Temporal:
                                        </p>
                                        <div class="text-3xl font-extrabold mt-2 text-blue-600" style="margin-top: 8px; font-size: 1.875rem; font-weight: 800; color: #2563eb;">
                                            {{ $plainPassword }}
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p class="mb-8 text-base" style="margin-bottom: 32px;">
                                Recuerda que esta contraseña es temporal y caducará pronto. Haz clic en el botón de abajo para ir a la página de inicio de sesión.
                            </p>

                            <table border="0" cellpadding="0" cellspacing="0" width="100%" role="presentation">
                                <tr>
                                    <td align="center" style="padding: 0 0 20px 0;">
                                        <table border="0" cellpadding="0" cellspacing="0" role="presentation">
                                            <tr>
                                                <td align="center" class="brand-primary rounded-lg shadow-md" style="border-radius: 8px; background-color: #2b7fff;">
                                                    <a href="{{ $frontendUrl }}/login" target="_blank" class="text-dark font-bold text-lg inline-block py-3 px-6 no-underline" style="padding: 12px 24px; display: inline-block; font-weight: 700; color: #FFF; text-decoration: none; border-radius: 8px;">
                                                        Iniciar Sesión Ahora
                                                    </a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                            
                            <p class="text-sm text-gray-500 mt-6" style="margin-top: 24px; font-size: 0.875rem; color: #6b7280;">
                                Si no solicitaste este correo, puedes ignorarlo con seguridad.
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" class="bg-gray-200 rounded-b-lg" style="padding: 20px 30px; border-radius: 0 0 8px 8px;">
                            <p class="text-xs text-gray-500" style="margin: 0; font-size: 0.75rem; color: #6b7280;">
                                © {{ now()->year }} King Dreams. Todos los derechos reservados.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>

</body>
</html>
