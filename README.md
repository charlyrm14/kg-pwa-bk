#  Plataforma de Gestión para Escuela de Natación - Backend

Este repositorio contiene el backend de una plataforma orientada a la gestión de una escuela de natación.
El objetivo principal es servir como proyecto de portafolio, pero también como una opción para ser utilizado en un entorno productivo.

Actualmente, el backend está pensado para ejecutarse de manera local, mientras que el frontend puede consumir datos mock o conectarse a este backend en desarrollo.

# Objetivo del proyecto

El backend tiene como objetivo cubrir las siguientes necesidades:

- Gestión de usuarios (administradores, maestros y alumnos)
- Asignación de horarios y días de clase
- Registro y control de asistencias
- Historial de asistencias y reportes
- Sistema de ranking (en desarrollo)
- Registro de historial de pagos (sin pasarela de pagos, solo registro administrativo)
- Gestión de contenidos (noticias, eventos, tips deportivos, tips nutricionales)
- Integración con IA para generación de contenido y asistencia conversacional
- Enfoque en arquitectura limpia, mantenible y escalable

# Tecnologías utilizadas

- PHP: ^8.2
- Framework: Laravel 12
- Base de datos: PostgreSQL 14.20
- Autenticación: OAuth 2.0 con Laravel Passport
- Sockets / Realtime: Pusher (en desarrollo)
- Exportación de reportes: Maatwebsite Excel

# Autenticación y seguridad

- Autenticación basada en OAuth 2.0 usando Laravel Passport
- Uso de JWT almacenados en cookies para mayor seguridad en entornos web
- Protección de rutas mediante middleware
- Autorización de acciones mediante Policies, basadas en el rol del usuario

# Uso de patrones de diseño

Strategy Pattern

Utilizado principalmente para:

- Generación de contenidos
- Noticias
- Eventos
- Tips para mejorar técnica de natación
- Tips nutricionales
- Generación de reportes
- Reportes de asistencias
- Reportes por periodo (mensual, semanal, etc.)

Esto permite:

- Cambiar o extender comportamientos sin modificar lógica existente
- Centralizar la lógica según el tipo de contenido o reporte

# Observer Pattern

Utilizado para reaccionar a eventos, por ejemplo:

- Al crear un usuario con rol de estudiante
- Generación automática de uuid
- Generación de código de estudiante

Al crear contenidos

- Generación automática de slug
- Mantener el controlador limpio y enfocado solo en su responsabilidad

# Integración con IA

El backend integra una API gratuita de Meta-Llama a través de OpenRouter, utilizada para:

- Generación de contenido (noticias, tips, eventos)
- Asistente conversacional enfocado en: Natación, entrenamiento, comunidad escolar

# Comandos por consola

La generación de contenido mediante IA también puede ejecutarse a través de comandos Artisan, lo que permite:

- Automatizar la creación de contenido
- Evitar dependencia directa de endpoints HTTP
- Facilitar pruebas y futuras tareas programadas

# Chat y mensajería

Implementación de un sistema de chat enfocado inicialmente en IA

Arquitectura preparada para:

- Chats directos
- Chats grupales
- Chats de soporte

Uso de sockets (Pusher) aunque actualmente el flujo principal es request/response

Separación clara entre HTTP y WebSockets

# Reportes

- Generación de reportes administrativos
- Exportación a Excel
- Arquitectura preparada para agregar nuevos tipos de reportes sin modificar los existentes

# Tipado estricto y buenas prácticas

- Uso de declare(strict_types=1) en servicios y clases clave
- Requests personalizados para validación
- Resources para estandarizar respuestas JSON
- Transacciones para operaciones críticas
- Manejo explícito de errores y logging

# Estado actual del proyecto

- El backend funciona de manera local
- No está desplegado en un entorno público

El frontend puede:

- Consumir este backend en local o trabajar con datos mockeados

Esta decisión es intencional para:

- Mantener el proyecto accesible como portafolio

# Repositorios relacionados

Frontend: (Repositorio principal del proyecto frontend)

Link:
👉 https://github.com/charlyrm14/kg-pwa-fr

# Nota final

Este proyecto está en constante evolución.
Muchas decisiones están pensadas desde un enfoque práctico y realista, buscando un balance entre:

- Escalabilidad
- Simplicidad
- Tiempo de desarrollo

# Autor

Carlos I. Ramos Morales

Desarrollador Full Stack