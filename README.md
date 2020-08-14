# Prueba Técnica HumanTech

Se generó la siguiente API bajo los siguientes puntos

- Se debe desarrollar los apis de los cruds de películas y sus turnos. Se adjunta mockups a modo de guía de los campos que debería tener ambas entidades.
- Los apis de asignación de turnos a películas queda a tu criterio.
- Para el desarrollo se debe utilizar Laravel Framework.
- Añadir capa de seguridad para el consumo de los servicios (opcional).
- Se evaluará el orden en el código y buenas prácticas de programación.
- Al ser una evaluación para el puesto de backend, es opcional el desarrollo de la interfaz.
- Enviar el postman u otra herramienta para probar los servicios.

La API se desarrollo bajo una imagen de [docker](https://hub.docker.com/r/cbrghton/php_fpm_composer_tools) personalizada con php 7.3

Se adjunta un script (**install.sh**) para instalar las dependencias y crear la base de datos y llenarla de datos

Solo se necesita especificar el nombre de la base de datos, el host, el usuario y password en el .env

Para el consumo de la API se utilizo la herramienta de [Insomnia Core](https://insomnia.rest/) y se anexa un json para importar las peticiones (**insomnia.json**) 
