# Cybed-API

#### Aplicación desplegada en heroku

|  [Frontend](https://cybed-frontend.herokuapp.com/)   |[API-Rest](https://cybed-api.herokuapp.com/)
|--------------|-----------------|



## Descripción

CYBED es una aplicación web que se encargue de documentar las principales vulnerabilidades mundiales, “CVE” (Common Vulnerabilities and Exposures), además de contener un foro de ayuda entre usuarios e información sobre los ataques informáticos que se llevan a cabo en la actualidad.

La aplicación consta de 3 partes:
- [Frontend](https://github.com/Proyecto-Cybed/Cybed-Frontend): Lo que vé el usuario final, donde interactúa con nuestra aplicación.
- [API-Rest](https://github.com/Proyecto-Cybed/Cybed-API): La interfaz de contenido de nuestra aplicación, donde se encuentra toda la infromación accesible al exterior.
- Base de datos: Donde almacenamos la información.


## Herramientas

Para la realización hemos utilizado las siguientes herramientas:

<table>
<thead>
  <tr>
    <th></th>
    <th>Herramientas</th>
    <th>Frameworks</th>
  </tr>
</thead>
<tbody>
  <tr>
  <td rowspan="2"><a href="https://github.com/Proyecto-Cybed/Cybed-Frontend">Frontend</a></td>
    <td>HTML, CSS</td>
    <td><a href="https://getbootstrap.com/">Boostrap 5</a></td>
  </tr>
  <tr>
    <td>JavaScript</td>
    <td>Vanilla, <a href="https://jquery.com/">jQuery</a></td>
  </tr>
  <tr>
  <td><a href="https://github.com/Proyecto-Cybed/Cybed-API">API</a></td>
    <td>PHP</td>
    <td><a href="https://symfony.com/releases/6.0">Symfony 6</a></td>
  </tr>
  <tr>
    <td>Base de datos</td>
    <td>MySQL</td>
    <td><a href="https://remotemysql.com/">Remote MySQL</a></td>
  </tr>
   <tr>
    <td>Despliegue</td>
    <td><a href="https://www.heroku.com/">Heroku</a></td>
    <td></td>
  </tr>
</tbody>
</table>

## Esquema

![Esquema](https://raw.githubusercontent.com/Proyecto-Cybed/Cybed-API/main/snapshots/Diagrama%20APP.png)

## Requisitos

### Requisitos Desarrollo en el Entorno Servidor

- [X] __RA5__: Implementado con Symfony
- [X] __RA7__: API REST que permita hacer CRUD de alguna entidad (usuarios, noticias...)
- [X] __RA8__: Uso de AJAX
- [X] __RA9__: Uso de servivio externo (Google, APIs externas, Twitter...)

### Requisitos Desarrollo en el Entorno Cliente

- [X] __RA5__: Objeto form, objetos relacionados con eventos, eventos, envíos y validación de formularios..etc. No tenéis que tocar todas las partes sino trabajar algún aspecto relacionado con formularios, eventos, validación... Por ejemplo formularios de contacto, formularios de alta y cosas de este tipo 
- [X] __RA6__: Modelo de objetos DOM: objetos, acceso (esto ya lo hemos usado en clase), gestión de eventos (algunos/as ya lo han usado)
- [X] __RA7__: AJAX: envío y recepción de datos de forma asíncrona.

### Requisitos Despliegue de Aplicaciones Web

- [X] __RA4__: Transferencia de archivos. Subir código fuente a __Heroku__
- [X] __RA5__: Parámetros de configuración. Configurar variables necesarias: __URI__ de base datos, ...
- [X] __RA6__: Documentación y control de versiones con __Git__. Desarrollo con __Markdown__ de README.md 

### Requisitos Empresa e Iniciativa Emprendedora

- [X] __RA1__: Iniciativa emprendedora, ideación y  prototipados de la idea. Actitudes personales y profesionales (fase I del proyecto de empresa)
- [X] __RA2__: Análisis del entorno de una actividad. (Fase II Del proyecto de empresa)
- [X] __RA3__: Puesta en marcha de una empresa. Determinación del mercado, elementos de marketing, forma jurídica y obligaciones legales (Fase lV y V del plan de empresa) 
- [X] __RA4__: Gestión administrativa y económica-financiera (fase VI del proyecto de empresa). 

## Participantes
- Juan Antonio González Rivera ► [Deg42](https://github.com/Deg42)
- Juan Miguel Costa Lucena ► [JuanmiCLucena](https://github.com/JuanmiCLucena)
- Rafael Bermudo Villaécija ► [rafaelbv95](https://github.com/rafaelbv95)

## Licencia

<a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/"><img alt="Licencia de Creative Commons" style="border-width:0" src="https://i.creativecommons.org/l/by-nc-sa/4.0/88x31.png" /></a><br /><span xmlns:dct="http://purl.org/dc/terms/" property="dct:title">CYBED</span> by <span xmlns:cc="http://creativecommons.org/ns#" property="cc:attributionName">Cybed S.L.</span> is licensed under a <a rel="license" href="http://creativecommons.org/licenses/by-nc-sa/4.0/">Creative Commons Reconocimiento-NoComercial-CompartirIgual 4.0 Internacional License</a>.
