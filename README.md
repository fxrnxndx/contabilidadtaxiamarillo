# Proyecto de Venta de Departamentos

## Descripción
Sistema de lista de precios, para la generacion de cotizacion de clientes que esten interesados en algun departamento segun las necesidades y disponibilidad del cliente.

## Tecnologías Utilizadas

### Backend
- **[CodeIgniter 4](https://codeigniter.com/docs/installation)**: Framework PHP para el desarrollo de aplicaciones web.

### Frontend
- **JavaScript**: Lenguaje de programación para la interacción dinámica del usuario.
- **[jQuery](https://jquery.com/)**: Biblioteca de JavaScript para simplificar la manipulación del DOM y las interacciones.
- **[Bootstrap](https://getbootstrap.com/)**: Framework CSS para diseñar interfaces web responsivas.
- **[DataTables](https://datatables.net/)**: Plugin de jQuery para crear tablas interactivas y dinámicas.

### Base de Datos
- **[MySQL](https://www.mysql.com/)**: Sistema de gestión de bases de datos relacional.

## Librerías Utilizadas
- **[FPDF](http://www.fpdf.org/)**: Librería PHP para generar archivos PDF.
- **[PhpSpreadsheet](https://phpspreadsheet.readthedocs.io/)**: Librería PHP para leer y escribir archivos de hojas de cálculo.
- **[Toastify](https://apvarun.github.io/toastify-js/)**: Librería JavaScript para mostrar notificaciones de toast.

## Instalación

### Requisitos Previos
- **PHP 7.4 o superior**
- **Composer**
- **MySQL**


## Uso

### Generación de PDF
Para generar archivos PDF, el sistema utiliza la librería FPDF. Puedes encontrar los scripts relacionados en la carpeta `app/Libraries/FPDF`.

### Generación de Hojas de Cálculo
Para manejar archivos de hojas de cálculo, se utiliza PhpSpreadsheet. Los scripts correspondientes están en `app/Libraries/PhpSpreadsheet`.

### Interacción Dinámica
Para las tablas interactivas, se utiliza DataTables en combinación con jQuery. El código relevante se encuentra en `public/js/datatables.js`.

### Notificaciones
Las notificaciones toast se manejan con Toastify. Puedes ver su uso en `public/js/toastify.js`.


## Licencia
Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.

## Contacto
Para cualquier consulta o soporte, puedes contactar a [tu_nombre](mailto:tu_correo@example.com).
