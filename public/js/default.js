
/**
 * Metodo para redirecionar o layout
 * @param objeto
 * @return
 */
function redirecionar()
{
	var valor	= 	$("select[name='redirect']").val();
	$("#content").html("<div class='loading'>Carregando</div>");	
	$.ajax({
		   type: "POST",
		   url:  valor,
		   success: function(data){
				$("#wrapper").html(data);
		   }
	});
}

function pesqAmbient(obj)
{
	var application =  ($(obj).val());
	$("#ambient").html("<div class='loading'>Carregando</div>");	
	$.ajax({
		   type: "POST",
		   data: "application_id="+application,
		   url:	"/find/boxambient",
		   success: function(data){
				$("#ambient").html(data);
		   }
	});
	return false;
}


function pesqComp(obj, appid)
{
	var ambient =  ($(obj).val());
	$("#component").html("");	
	$("#component").html("<div class='loading'>Carregando</div>");	
	$.ajax({
		   type: "POST",
		   data: "application_id="+appid+"&ambient_id="+ambient,
		   url:	"/find/component",
		   success: function(data){
				$("#component").html(data);
		   }
	});
	return false;
}

/** Metodo para iniciar commando **/
function execCmd(lbl, comp)
{
	var flow = $("select[name='flow_id"+lbl+"']").val();
	$("#wrapper").append("<div class='loading'>Carregando</div>");	
	$("#iframe").show();
	
	if(flow == undefined || flow == null || flow == "")
	{
		$(".loading").hide();
		alert("Erro, escolha um comando!");
		return false;
	}
	$.ajax({
		   type:    "POST",
		   data:    "component_id="+comp+"&flow_id="+flow,
		   url:	    "/exec/command",
		   cache: false,
		   processData: false,
		   success: function(data){
				$(".loading").hide();
				$("#exec"+lbl).html(data);
		   }
	});
	return false;
}

function validCmd(a)
{
	var flow = $("select[id='flow_id"+a+"']").val();
	$('#sgroup'+a).html("");
	if(flow == undefined || flow == null || flow == "")
	{
		$('#sbtEnviar').show();
		alert("Erro, escolha um fluxo!");
		return false;
	}
	$('#sbtEnviar'+a).hide();		
	$('#sgroup'+a).removeClass("group");
	$('#sgroup'+a).show();
	return true;
}


/**
 * Submit do formulario de historico
 * @param obj
 * @return
 */
function pesqHist(obj)
{
	var form = $(obj).serialize();
	
	$("#listHist").html();
	$("#wrapper").append("<div class='loading'>Carregando</div>");	

	$.ajax({
		   type:    "POST",
		   data:    form,
		   url:	    "/historic/search",
		   cache: false,
		   processData: false,
		   success: function(data){
				$(".loading").hide();
				$("#listHist").html(data);
		   }
	});
	return false;
}

/** Método para acessar a execução do processo**/
function acessExec (app, comp, amb)
{
	$("#popunder").show();
	$("#popunder").html("<div class='loading'>Carregando</div>");

	var $dialog =
		jQuery.FrameDialog.create({
			url: 'http://148.91.91.204/default/exec/index?application_id='+app+"&component_id="+comp+"&ambient_id="+amb,
			loadingClass: 'loading-image',
			title: 'Componente - Detalhes',
			width: 800,
			height: 500,
			autoOpen: false
		});
	$dialog.dialog('open');
	$("button").hide();
	$("#popunder").hide();
	$(".ui-dialog-buttonpane").hide();
	//$(".ui-widget-overlay").hide();
	return false;
}



/** Método para acessar a execução do processo para subprocesso**/
function acessExec2 (app, comp, amb)
{
	$("#popunder").show();
	$("#popunder").html("<div class='loading'>Carregando</div>");

	var $dialog =
		jQuery.FrameDialog.create({
			url: 'http://148.91.91.204/default/exec/index?application_id='+app+"&component_id="+comp+"&ambient_id="+amb,
			loadingClass: 'loading-image',
			title: 'Componente - Detalhes',
			width: 600,
			height: 500,
			autoOpen: false
		});
	$dialog.dialog('open');
	$("button").hide();
	$("#popunder").hide();
	$(".ui-dialog-buttonpane").hide();
	$(".ui-widget-overlay").hide();
	return false;
}