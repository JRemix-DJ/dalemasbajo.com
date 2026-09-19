<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI containno data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
$route['(:num)'] = 'home/index/$1';
$route['search/(:num)'] = 'search/index/$1';
$route['remixers/(:num)/(:num)'] = 'remixers/index/$1/$2';
$route['tienda/(:num)'] = 'tienda/index/$1';
$route['changepass'] = 'changepass/index';
$route['users/request_password_reset'] = 'users/request_password_reset';
$route['users/reset_password'] = 'users/reset_password';
$route['genero/(:any)/(:num)'] = 'generos/genero/$1/$2';
$route['audios'] = 'audios/index';
$route['audios/(:num)'] = 'audios/index/$1';
$route['videos/(:num)'] = 'videos/index/$1';
$route['admin'] = 'admin/dashboard/index';
$route['admin/login'] = 'admin/dashboard/login';

$route['admin/listar_productos'] = 'admin/products/listar_productos';
$route['admin/listar_productos/(:any)'] = 'admin/products/listar_productos/$1';
$route['admin/listar_videos'] = 'admin/products/listar_videos';
$route['admin/listar_videos/(:any)'] = 'admin/products/listar_videos/$1';
$route['admin/listar_drops'] = 'admin/products/listar_drops';
$route['admin/listar_drops/(:any)'] = 'admin/products/listar_drops/$1';
$route['admin/nuevo_producto'] = 'admin/products/nuevo_producto';
$route['admin/editar_producto'] = 'admin/products/editar_producto';
$route['admin/editar_producto/(:any)'] = 'admin/products/editar_producto/$1';
$route['admin/print_edit_product'] = 'admin/products/print_edit_product';
$route['admin/print_edit_product/(:any)'] = 'admin/products/print_edit_product/$1';
$route['admin/ver_descargar'] = 'admin/products/ver_descargar';
$route['admin/ver_descargar/(:any)'] = 'admin/products/ver_descargar/$1';
$route['admin/mostrar_descarga'] = 'admin/products/mostrar_descarga';
$route['admin/mostrar_descarga/(:any)'] = 'admin/products/mostrar_descarga/$1';
$route['admin/subir'] = 'admin/products/subir';
$route['admin/showme'] = 'admin/products/showme';
$route['admin/video'] = 'admin/products/video';
$route['admin/video/(:any)'] = 'admin/products/video/$1';
$route['admin/audio'] = 'admin/products/audio';
$route['admin/audio/(:any)'] = 'admin/products/audio/$1';
$route['admin/image'] = 'admin/products/image';
$route['admin/image/(:any)'] = 'admin/products/image/$1';
$route['admin/updateDurations'] = 'admin/products/updateDurations';
$route['admin/getAudioDuration'] = 'admin/products/getAudioDuration';
$route['admin/getVideoDuration'] = 'admin/products/getVideoDuration';
$route['admin/sox'] = 'admin/products/sox';
$route['admin/ffmpeg'] = 'admin/products/ffmpeg';

$route['admin/listar_usuarios'] = 'admin/users/listar_usuarios';
$route['admin/listar_usuarios/(:any)'] = 'admin/users/listar_usuarios/$1';
$route['admin/mostrar_usuarios'] = 'admin/users/mostrar_usuarios';
$route['admin/mostrar_usuarios/(:any)'] = 'admin/users/mostrar_usuarios/$1';
$route['admin/listar_djs'] = 'admin/users/listar_djs';
$route['admin/listar_djs/(:any)'] = 'admin/users/listar_djs/$1';
$route['admin/nuevo_usuario'] = 'admin/users/nuevo_usuario';
$route['admin/nuevo_dj'] = 'admin/users/nuevo_dj';
$route['admin/editar_usuario'] = 'admin/users/editar_usuario';
$route['admin/editar_usuario/(:any)'] = 'admin/users/editar_usuario/$1';
$route['admin/print_editar_usuario'] = 'admin/users/print_editar_usuario';
$route['admin/print_editar_usuario/(:any)'] = 'admin/users/print_editar_usuario/$1';
$route['admin/editar_perfil'] = 'admin/users/editar_perfil';
$route['admin/cambiar_pass'] = 'admin/users/cambiar_pass';
$route['admin/force_new_pass'] = 'admin/users/force_new_pass';
$route['admin/encrypt_all_users'] = 'admin/users/encrypt_all_users';
$route['admin/get_countries'] = 'admin/users/get_countries';

$route['admin/listar_ordenes'] = 'admin/orders/listar_ordenes';
$route['admin/listar_ordenes/(:any)'] = 'admin/orders/listar_ordenes/$1';
$route['admin/listar_ordenes_tokens'] = 'admin/orders/listar_ordenes_tokens';
$route['admin/listar_ordenes_tokens/(:any)'] = 'admin/orders/listar_ordenes_tokens/$1';
$route['admin/orden_detail'] = 'admin/orders/orden_detail';
$route['admin/orden_detail/(:any)'] = 'admin/orders/orden_detail/$1';
$route['admin/pagos'] = 'admin/orders/pagos';
$route['admin/pagos/(:any)'] = 'admin/orders/pagos/$1';
$route['admin/pagos_tokens'] = 'admin/orders/pagos_tokens';
$route['admin/pagos_tokens/(:any)'] = 'admin/orders/pagos_tokens/$1';
$route['admin/pagos_realizados'] = 'admin/orders/pagos_realizados';
$route['admin/pagos_realizados/(:any)'] = 'admin/orders/pagos_realizados/$1';
$route['admin/pagos_realizados_tokens'] = 'admin/orders/pagos_realizados_tokens';
$route['admin/pagos_realizados_tokens/(:any)'] = 'admin/orders/pagos_realizados_tokens/$1';
$route['admin/detalles_pago'] = 'admin/orders/detalles_pago';
$route['admin/detalles_pago/(:any)'] = 'admin/orders/detalles_pago/$1';
$route['admin/detalles_pago_token'] = 'admin/orders/detalles_pago_token';
$route['admin/detalles_pago_token/(:any)'] = 'admin/orders/detalles_pago_token/$1';
$route['admin/pago_a_dj'] = 'admin/orders/pago_a_dj';
$route['admin/pago_a_dj/(:any)'] = 'admin/orders/pago_a_dj/$1';
$route['admin/pago_a_dj_token'] = 'admin/orders/pago_a_dj_token';
$route['admin/pago_a_dj_token/(:any)'] = 'admin/orders/pago_a_dj_token/$1';

$route['admin/listar_planes'] = 'admin/plans/listar_planes';
$route['admin/listar_planes/(:any)'] = 'admin/plans/listar_planes/$1';
$route['admin/nuevo_plan'] = 'admin/plans/nuevo_plan';
$route['admin/add_plan'] = 'admin/plans/add_plan';
$route['admin/editar_plan'] = 'admin/plans/editar_plan';
$route['admin/editar_plan/(:any)'] = 'admin/plans/editar_plan/$1';
$route['admin/update_plan'] = 'admin/plans/update_plan';
$route['admin/print_edit_plan'] = 'admin/plans/print_edit_plan';
$route['admin/print_edit_plan/(:any)'] = 'admin/plans/print_edit_plan/$1';
$route['admin/precios'] = 'admin/plans/precios';
$route['admin/precios/(:any)'] = 'admin/plans/precios/$1';
$route['admin/nuevo_precio'] = 'admin/plans/nuevo_precio';
$route['admin/add_precio'] = 'admin/plans/add_precio';
$route['admin/print_edit_precio'] = 'admin/plans/print_edit_precio';
$route['admin/print_edit_precio/(:any)'] = 'admin/plans/print_edit_precio/$1';
$route['admin/editar_precio'] = 'admin/plans/editar_precio';
$route['admin/editar_precio/(:any)'] = 'admin/plans/editar_precio/$1';
$route['admin/update_precio'] = 'admin/plans/update_precio';

$route['admin/listar_banner'] = 'admin/banners/listar_banner';
$route['admin/listar_banner/(:any)'] = 'admin/banners/listar_banner/$1';
$route['admin/nuevo_banner'] = 'admin/banners/nuevo_banner';
$route['admin/add_banner'] = 'admin/banners/add_banner';
$route['admin/print_edit_banner'] = 'admin/banners/print_edit_banner';
$route['admin/print_edit_banner/(:any)'] = 'admin/banners/print_edit_banner/$1';
$route['admin/editar_banner'] = 'admin/banners/editar_banner';
$route['admin/editar_banner/(:any)'] = 'admin/banners/editar_banner/$1';
$route['admin/update_banner'] = 'admin/banners/update_banner';

$route['admin/listar_generos'] = 'admin/genres/listar_generos';
$route['admin/listar_generos/(:any)'] = 'admin/genres/listar_generos/$1';
$route['admin/nuevo_genero'] = 'admin/genres/nuevo_genero';
$route['admin/add_genero'] = 'admin/genres/add_genero';
$route['admin/editar_genero'] = 'admin/genres/editar_genero';
$route['admin/editar_genero/(:any)'] = 'admin/genres/editar_genero/$1';
$route['admin/print_edit_gender'] = 'admin/genres/print_edit_gender';
$route['admin/print_edit_gender/(:any)'] = 'admin/genres/print_edit_gender/$1';
$route['admin/update_genero'] = 'admin/genres/update_genero';

$route['admin/listar_faq'] = 'admin/faq/listar_faq';
$route['admin/listar_faq/(:any)'] = 'admin/faq/listar_faq/$1';
$route['admin/nuevo_faq'] = 'admin/faq/nuevo_faq';
$route['admin/add_faq'] = 'admin/faq/add_faq';
$route['admin/editar_faq'] = 'admin/faq/editar_faq';
$route['admin/editar_faq/(:any)'] = 'admin/faq/editar_faq/$1';
$route['admin/print_edit_faq'] = 'admin/faq/print_edit_faq';
$route['admin/print_edit_faq/(:any)'] = 'admin/faq/print_edit_faq/$1';
$route['admin/update_faq'] = 'admin/faq/update_faq';

$route['admin/cupones'] = 'admin/coupons/cupones';
$route['admin/cupones/(:any)'] = 'admin/coupons/cupones/$1';
$route['admin/add_cupon'] = 'admin/coupons/editar_cupon';
$route['admin/editar_cupon'] = 'admin/coupons/editar_cupon';
$route['admin/editar_cupon/(:any)'] = 'admin/coupons/editar_cupon/$1';
$route['admin/edit_cupon'] = 'admin/coupons/edit_cupon';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['genero/(:any)'] = 'generos/genero/';
