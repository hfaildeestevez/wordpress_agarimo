## wordpress_agarimo

### Creación tema hijo

Lo primero que  hicimos fue buscar un tema que nos gustase y lo añadimos a nuestro wp.
A continuacion en el PhpStorm creamos una capeta con el mismo nombre que nuestro tema 
añadiendole un -child. Le creamos un [style.css](https://github.com/hfaildeestevez/wordpress_agarimo/blob/master/html/wp-content/themes/ff-associate-child/style.css) donde le ponemos el siguiente texto:
~~~
/*
 Theme Name:   ff-associate-child
 Theme URI:    http://example.com/ff_associate-child/
 Description:  FF Associate Child Theme
 Author:       hfaildeestevez, bmartinezparedes
 Author URI:   http://example.com
 Template:     ff-associate
 Version:      1.0.0
 License:      GNU General Public License v2 or later
 License URI:  http://www.gnu.org/licenses/gpl-2.0.html
 Tags:         light, dark, two-columns, right-sidebar, responsive-layout, accessibility-ready
 Text Domain:  ff-associate-child
*/
~~~

Lo importante de aquí es el Theme Name: Donde le pondremos el nombre de nuestro theme que sera 
lo que nos salga en la eleccion de temas; y Template: que pondremos el dominio del tema principal que eligimos.

Para que el tema hijo nos meta el style del tema principal necesitaremos un functions.php donde tendremos lo siguinete:

~~~
<?php
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {
    $parenthandle = 'parent-style'; // This is 'ff-associate-style' for the FF Associate theme.
    $theme = wp_get_theme();
    wp_enqueue_style( $parenthandle, get_template_directory_uri() . '/style.css',
        array(),  // if the parent theme code has a dependency, copy it to here
        $theme->parent()->get('Version')
    );
    wp_enqueue_style( 'child-style', get_stylesheet_uri(),
        array( $parenthandle ),
        $theme->get('Version') // this only works if you have Version in the style header
    );
}
~~~

Con esto conseguiremos que nos coja el style del tema principal y nos lo aplique en nuestro tema-child.

Una vez cargado nuestro tema child con el style del tema principal cambiaremos nuestro tema desde el backend.

### Backend

![Texto alternativo](/html/wp-content/themes/ff-associate-child/imagenes/inicio.png)

Entramos en nuestra pagina desde admin y desde *temas > personalizar tema >* personalizamos nuestro tema con diferentes configuraciones, 
desde cambiar algun color , entradas desde la pagina principal, cambio de icono de la pestaña, etc.

Otras dos paginas serian nuestro acerca de y contactos que se veran en las siguientes imagenes:

![Texto alternativo](/html/wp-content/themes/ff-associate-child/imagenes/acerca.png)

![Texto alternativo](/html/wp-content/themes/ff-associate-child/imagenes/contacto.png)

Estas paginas se pueden modifigar en el apartado paginas que se podra ver en la sigueinte imagen:

![Texto alternativo](/html/wp-content/themes/ff-associate-child/imagenes/paginas.png)

En esta parte podremos modificar el texto o información que aparecera en cada pagina.

### Cambios en style.css/child

En nuetsro style del tema child le añadimos los siguinetes setilos que aran un cambio significativo:

`.entry-title{
    font-family: "Malgun Gothic";
}`

`.entry-content{
    font-family: "Malgun Gothic";
}`

Con lo siguiente conseguimos que el titulo de los entradas y su contenido cambie a una fuente *Malgun Gothic*.


![Texto alternativo](/html/wp-content/themes/ff-associate-child/imagenes/fuente.png)


