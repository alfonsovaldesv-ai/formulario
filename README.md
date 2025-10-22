# Léeme

Para instalar el proyecto solamente hay que pararse en la carpeta ./formulario y luego correr:

```php -S localhost:8000```

Y luego abrir el navegador en dicha dirección.

## Versiones

 - PHP: 8.4.13
 - Postgres: 15

Nota: los comandos para correr postgres que se señalan aquí se utilizaron en Windows 11.

Con este comando se llena la base de datos de acuerdo al contenido en `init.psql`.

```bash
Get-Content .\sql\init.sql | docker exec -i pg-local psql -U postgres -d productos
```

Luego, con este comando se accede a la base de datos en caso de que esto fuera necesario. 

```bash
docker exec -it pg-local psql -U postgres -d productos
```

