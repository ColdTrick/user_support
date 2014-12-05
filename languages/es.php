<?php

return array(

	'user_support' => "Soporte de Usuarios",

	// objects
	'item:object:faq' => "FAQ de soporte de usuarios",
	'item:object:help' => "Ayuda Contextual de soporte de usuarios",
	'item:object:support_ticket' => "Ticket de soporte de usuarios",
	
	// general
	'user_support:support_type' => "Categoría",
	'user_support:support_type:question' => "Consulta",
	'user_support:support_type:bug' => "Bug (error)",
	'user_support:support_type:request' => "Solicitud de funcionalidad",

	'user_support:support_type:status:open' => "Abierto",
	'user_support:support_type:status:closed' => "Cerrado",
	
	'user_support:anwser' => "Respuesta",
	'user_support:anwser:short' => "A",
	'user_support:question' => "Consulta",
	'user_support:question:short' => "Q",
	'user_support:url' => "URL",
	'user_support:allow_comments' => "Permitir comentarios",
	'user_support:read_more' => "Leer más",
	'user_support:help_context' => "Ayuda contextual",
	'user_support:reopen' => "Reabrir",
	'user_support:last_comment' => "Último comentario por: %s",
	'user_support:comment_close' => "Comentar y cerrar",

	'user_support:staff_gatekeeper' => "Esta página sólo está disponible para el personal de soporte",
	
	// settings
	'user_support:settings:support_tickets:title' => "Preferencias de los Tickets de Soporte",
	'user_support:settings:support_tickets:help_group' => "Seleccionar un grupo al que pedir ayuda",
	'user_support:settings:support_tickets:help_group:none' => "Sin grupo de soporte",
	
	'user_support:settings:help:title' => "Preferencias de la Ayuda Contextual",
	'user_support:settings:help:enabled' => "Está habilitada la ayuda contextual?",

	'user_support:settings:help_center:title' => "Preferencias del Centro de Ayuda",
	'user_support:settings:help_center:add_help_center_site_menu_item' => "Añadir un elemento al menú del sitio para el Centro de Ayuda",
	'user_support:settings:help_center:show_floating_button' => "Mostrar un botón flotante que enlaza al Centro de Ayuda",
	'user_support:settings:help_center:show_floating_button:left_top' => "Izquierda - Arriba",
	'user_support:settings:help_center:show_floating_button:left_bottom' => "Izquierda - Abajo",
	'user_support:settings:help_center:show_floating_button:right_top' => "Derecha - Arriba",
	'user_support:settings:help_center:show_floating_button:right_bottom' => "Derecha - Abajo",
	'user_support:settings:help_center:float_button_offset' => "Desplazamiento vertical del botón flotante",
	'user_support:settings:help_center:show_as_popup' => "Mostrar el Centro de Ayuda en un popup",
		
	'user_support:settings:faq:title' => "Preferencias del FAQ",
	'user_support:settings:faq:add_faq_site_menu_item' => "Añadir un enlace al FAQ en el menú del sitio",
	'user_support:settings:faq:add_faq_footer_menu_item' => "Añadir un enlace al FAQ en pié de página",

	'user_support:settings:other:title' => "Otro",
	'user_support:settings:other:ignore_site_guid' => "Ignorar site_guid al buscar Ayuda Contextual y elementos del FAQ. Se puede utilizar para instalaciones multisitio para compartir ayuda y faq's entre sitios.",
			
	
	// user settings
	'user_support:usersettings:admin_notify' => "Quieres recibir una notificación cuando se crea/actualiza un ticket de soporte?",
	
	// annotations
	'river:comment:object:support_ticket' => "%s posteó un comentario a las %s",
	'river:create:object:support_ticket' => "%s posteó un comentario a las %s",
	'user_support:support_ticket:closed' => "Se ha cerrado tu ticket de soporte",
	'user_support:support_ticket:reopened' => "Se ha abierto de nuevo tu ticket de soporte",
	'user_support:support_ticket:promote' => "Promover al FAQ",
	
	// admin notify
	'user_support:notify:admin:create:subject' => "Se ha reportado un nuevo ticket de soporte",
	'user_support:notify:admin:create:message' => "Hola,

%s ha reportado un nuevo ticket de soporte:
%s

Sigue el enlace para ver erl ticket:
%s",
	
	'user_support:notify:admin:updated:subject' => "Se ha actualizado un ticket de soporte",
	'user_support:notify:admin:updated:message' => "Ho,

%s actualizó el ticket de soporte %s:
%s

Sigue el enlace para ver el ticket:
%s",

	// menu
	'user_support:menu:support_tickets' => "Tickets de soporte",
	'user_support:menu:support_tickets:archive' => "Archivo de tickets de soporte",
	'user_support:menu:support_tickets:mine' => "Mis tickets de soporte",
	'user_support:menu:support_tickets:mine:archive' => "Mis tickets de soporte cerrados",
	
	'user_support:menu:faq' => "FAQ",
	'user_support:menu:faq:group' => "FAQ del grupo",
	'user_support:menu:faq:create' => "Crear FAQ",
	
	'user_support:menu_user_hover:make_staff' => "Añadir al personal de soporte",
	'user_support:menu_user_hover:remove_staff' => "Eliminar del personal de soporte",
	
	// button
	'user_support:button:text' => "Soporte",
	'user_support:button:hover' => "Click para abrir el Centro de Ayuda",
	
	'user_support:help_center:title' => "Centro de Ayuda",
	'user_support:help_center:ask' => "Hacer una pregunta",
	'user_support:help_center:help' => "Crear ayuda",
	'user_support:help_center:help:title' => "Ayuda contextual",
	'user_support:help_center:faq:title' => "FAQ",
	'user_support:help_center:help_group' => "Grupo de ayuda",

	// forms
	'user_support:forms:help:title' => "Crear Ayuda Contextual",
	'user_support:faq:edit:title:edit' => "Editar un elemento del FAQ",
	'user_support:faq:create:title' => "Crear un elemento del FAQ",

	// ticket - list
	'user_support:tickets:list:title' => "Soportar tickets",
	
	// ticket - mine
	'user_support:tickets:mine:title' => "Mis tickets de soporte",
	'user_support:tickets:mine:archive:title' => "Mis tickets de soporte cerrados",
	'user_support:tickets:owner:title' => "%s Tickets de Soporte",
	'user_support:tickets:owner:archive:title' => "%s Tickets de Soporte cerrados",
	
	// ticket - archive
	'user_support:tickets:archive:title' => "Archivo de Tickets de Soporte",

	// faq - list
	'user_support:faq:list:title' => "Ver todos los elementos del FAQ",
	'user_support:faq:not_found' => "No hay elementos disponibles en el FAQ",
	
	// group faq
	'user_support:group:tool_option' => "Activar soporte para FAQs de grupo",
	'user_support:faq:group:title' => "%s FAQ",

	// widgets
	'user_support:widgets:faq:title' => "FAQ",
	'user_support:widgets:faq:description' => "Mostrar una lista de los elementos más recientes añadidos al FAQ",
	
	'user_support:widgets:support_ticket:title' => "Tickets de soporte",
	'user_support:widgets:support_ticket:description' => "Muestra una lista de tus tickets de soporte",
	'user_support:widgets:support_ticket:filter' => "Tickets que quieres ver",
	'user_support:widgets:support_ticket:filter:all' => "Todos",
	
	'user_support:widgets:support_staff:title' => "Personal de soporte",
	'user_support:widgets:support_staff:description' => "Muestra una lista de tickets abiertos",
	
	// actions
	// help - edit
	'user_support:action:help:edit:error:input' => "Entrada inválida para crear/editar esta ayuda contextual",
	'user_support:action:help:edit:error:save' => "Hubo un error desconocido al guardar la ayuda contextual",
	'user_support:action:help:edit:success' => "La ayuda contextual se guardó correctamente",
	
	// help - delete
	'user_support:action:help:delete:error:delete' => "Hubo un error desconocido al eliminar la ayuda contextual",
	'user_support:action:help:delete:success' => "Se ha borrado la ayuda contextual correctamente",

	// ticket - edit
	'user_support:action:ticket:edit:error:input' => "Entrada incorrecta para crear/editar un ticket de soporte",
	'user_support:action:ticket:edit:error:save' => "Hubo un error desconocido al guardar el ticket de soporte",
	'user_support:action:ticket:edit:success' => "El ticket de soporte se guardó correctamente",

	// ticket - delete
	'user_support:action:ticket:delete:error:delete' => "Hubo un error desconocido al eliminar el ticket de soporte",
	'user_support:action:ticket:delete:success' => "Ticket de soporte borrado correctamente",
	
	// faq - delete
	'user_support:action:faq:delete:error:delete' => "Hubo un error desconocido al borrar el FAQ, inténtalo de nuevo",
	'user_support:action:faq:delete:success' => "El FAQ se ha borrado correctamente",
	
	// faq - edit
	'user_support:action:faq:edit:error:input' => "Entrada incorrecta para crear/editar el FAQ, proporciona una Pregunta y una Respuesta",
	'user_support:action:faq:edit:error:create' => "Hubo un error al crear el FAQ",
	'user_support:action:faq:edit:success' => "FAQ creado/editado correctamente",
	
	// ticket = close
	'user_support:action:ticket:close:error:disable' => "Hubo un error desconocido al cerrar el Ticket de Soporte",
	'user_support:action:ticket:close:success' => "Ticket de Soporte cerrado correctamente",
	
	// ticket - reopen
	'user_support:action:ticket:reopen:error:enable' => "Hubo un error al reabrir el Ticket de Soporte",
	'user_support:action:ticket:reopen:success' => "El Ticket de Soporte se abrió de nuevo correctamente",
	
	// support staff
	'user_support:action:support_staff:added' => "Se ha añadido el usuario al personal de soporte",
	'user_support:action:support_staff:removed' => "Se ha eliminado el usuario del personal de soporte",
	
);
