/**
 * Arquivo de funcoes javascript pontuais para envio de dados
*/

/**
 * Método para edição de cliente
 */
function lnEditClient(client)
{
	$.ajax({
		   type: "POST",
		   url: "/admin/client",
		   data: "client_id="+client,
		   success: function(data){
		     $("#wrapper").html(data);
		   }
	});
}

/**
 * Método para remoção de cliente
 */
function lnRemoveClient(client)
{
	if(confirm("Tem certeza que deseja remover?"))
	{
		$.ajax({
			   type: "POST",
			   url: "/admin/client/delete",
			   data: "client_id="+client,
			   success: function(data){
			     $("#wrapper").html(data);
			   }
		});
	}
}

/**
 * Método para preenchimento do Box de Aplicações
 */
function setApplication()
{
    $("#dvApplication").html("");
    $("#dvApplication").html("<pre>Carregando aplicações....</pre>");
    $("#dvComponent").hide();
    
	var clientId = $("select[name='client_id']").val();
	$.ajax({
	   type: "POST",
	   url:  "/default/find/application",
	   data: "client_id="+clientId,
	   success: function(data){
	     $("#dvApplication").html(data);
	 	 $("#dvApplication").show();
	   }
	});
}


/**
 * Método para preenchimento do Box de Component recebendo um id da aplicação
 */
function setComponent()
{
	$("#dvComponent").show();
	$("#dvComponent").html("<pre>Carregando componentes....</pre>");
	var application = $("select[name='application_id']").val();
	$.ajax({
	   type: "POST",
	   url:  "/default/find/component",
	   data: "application_id="+application,
	   success: function(data){
	     $("#dvComponent").html(data);
	 	 $("#dvComponent").show();
	   }
	});
}


/** Método para pesquisar operações disponíveis**/
function searchExec ()
{
	$("#dvResponse").show();
	$("#dvResponse").html("Carregando Pesquisa...");
	
	var client 		= $("select[name='client_id']").val();
	var client_tmp	= $("#client_id").val();
	
	if(client_tmp > 0)
		client = client_tmp;

	if(client == "" || client == null){
		alert("Selecione um cliente");
		$("#client_id").focus();
		return true;
	}
	
	var data = $("#frm_findExec").serialize();
	$.ajax({
	   type: "POST",
	   url:  "/default/find/response",
	   data: data,
	   success: function(data){
	     $("#dvResponse").html(data);
	   }
	});
	return false;
}


/** Método para acessar o log do processo executado**/
function acessLog (url)
{
	$.ajax({
	   type: "POST",
	   url:  "/default/exec/download",
	   data: "url="+url,
	   success: function(data){
	     $("#dvDownload").html(data);
	   }
	});
	return false;	
}

/**
 * Método para popular o select bos de ambiente no módulo operacional
 * @param int application_id
 * @return html
 */
function populateAmbient(application_id)
{
	$.ajax({
		   type: "POST",
		   url:  "/default/find/ambient",
		   data: "application_id="+ambient,
		   success: function(data){
		     $("#dvDownload").html(data);
		   }
		});
		return false;
}