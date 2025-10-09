<?php

declare(strict_types=1);

namespace App\Services\AI;

class PromptsContentBuilderService
{
    private const CONTENT_LENGTH = 600;
    
    public static function instructions(string $topic): string
    {
        return "Actúa como un experto en entrenamiento de natación y nutrición deportiva. Tu audiencia es un club de natación juvenil. Genera un artículo detallado sobre el tema '{$topic}' usando un tono motivacional y fácil de entender. El contenido debe ser apto para todo público.
        TU ÚNICA RESPUESTA DEBE SER UN OBJETO JSON con la siguiente estructura:
        {
            \"name\": \"Título del contenido creativo y optimizado para SEO\",
            \"content\": \"El cuerpo completo del artículo o tip de natación/nutrición.\"
        }
        No incluyas texto adicional ni explicaciones fuera del objeto JSON.";
    }

    public static function buildContentPrompt(string $topic, array $options = []): string
    {
        $length = $options['length'] ?? self::CONTENT_LENGTH;
        $focus = $options['focus'] ?? 'beneficios';

        $prompt = "Genera un artículo de {$length} palabras para la sección de {$topic}. ";
        $prompt .= "El enfoque principal debe ser en los {$focus} para nadadores adolescentes. ";
        $prompt .= "Asegúrate de que el resultado final sea estrictamente un objeto JSON conforme a las instrucciones del sistema.";

        return $prompt;
    }
}