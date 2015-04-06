/**
 * Arquivo de funcoes javascript pontuais para envio de dados
*/
$(document).ready(function() {	
	
	$( "#date_ini" ).datepicker();
	$( "#date_end" ).datepicker();

	$('#dvPackage').hide();
	$("#group").resizable();

    $(".checkboxTree a").append("<em></em>");

    $(".checkboxTree a").hover(function() {
    $(this).find("em").animate({opacity: "show", top: "-75"}, "slow");
            var hoverText = $(this).attr("title");
            if(hoverText)
            {
                $(this).find("em").css({position: "absolute"});
                $(this).find("em").html(hoverText);
            }

        }, function() {
        $(this).find("em").animate({opacity: "hide", top: "-85"}, "fast");
    });     
    
	$('a[name=component]').click(function(e) {
		e.preventDefault();
		$("#modalContent").html("Carregando dados....");
		
		var id = $(this).attr('href');
	
		var maskHeight	= $(document).height();
		var maskWidth	= $(window).width();
	
		$('#dialog').css({'height': 250, 'background': '#FFFFFF'});
		
		$('#mask').css({'width':maskWidth,'height':maskHeight});

		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		//Get the window height and width
		var winH = $(window).height();
		var winW = $(window).width();
              
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
	
		$(id).fadeIn(2000);
		
		
		$.ajax({
			   type: "POST",
			   url: "/prime/component/index",
			   success: function(data){
				$("#modalContent").html(data);
			   }
		});		
	
	});
	
	$('a[name=SessionDefault]').click(function(e){
		e.preventDefault();
		var url = location;
		
		var client = $(this).attr("href");
		$("#content").html("Carregando...");
		$.ajax({
			   type: "POST",
			   data: "client_id="+client+"&url="+url,
			   url: "/default/index",
			   success: function(data){
				$("#wrapper").html(data);
			   }
		});		
	});
	
	$('a[name=SessionClient]').click(function(e){
		e.preventDefault();
		var url = location;
		
		var client = $(this).attr("href");
		$("#content").html("Carregando...");
		$.ajax({
			   type: "POST",
			   data: "client_id="+client+"&url="+url,
			   url: "/prime/index",
			   success: function(data){
				$("#wrapper").html(data);
			   }
		});		
	});

	$('a[name=server]').click(function(e) {
		e.preventDefault();
		
		var $dialog =
			jQuery.FrameDialog.create({
				url: 'http://148.91.91.204/prime/server/index',
				loadingClass: 'loading-image',
				title: 'Criação e edição para servidores',
				width: 500,
				height: 500,
				autoOpen: false
			});
		$dialog.dialog('open');
		$("button").hide();
		$(".ui-dialog-buttonpane").hide();
		//$(".ui-widget-overlay").hide();
		return false;
	});	

	$('a[name=hierarquia]').click(function(e) {
		e.preventDefault();
		
		var id			= $(this).attr('href');
		var comp		= $(this).attr('id');

		var $dialog =
			jQuery.FrameDialog.create({
				url: 'http://'+window.location.host+'/prime/component/tree?component_id='+comp,
				loadingClass: 'loading-image',
				title: 'Hierarquia de Componente',
				width: 300,
				height: 300,
				autoOpen: false
			});
		$dialog.dialog('open');
		$("button").hide();
		$(".ui-dialog-buttonpane").hide();
		//$(".ui-widget-overlay").hide();
		return false;
	});		
	
	
	$('a[name=package]').click(function(e) {
		e.preventDefault();

		var id = $(this).attr('href');
		var maskHeight = $(document).height();
		var maskWidth = $(window).width();
		var winH = $(window).height();
		var winW = $(window).width();
	
		$('#mask').css({'width':maskWidth,'height':maskHeight});
		$('#mask').fadeIn(1000);	
		$('#mask').fadeTo("slow",0.8);	
	
		$(id).css('top',  winH/2-$(id).height()/2);
		$(id).css('left', winW/2-$(id).width()/2);
		$(id).fadeIn(2000);
		
		$.ajax({
			   type: "POST",
			   data: "norender=1",
			   url: "/prime/package/index",
			   success: function(data){
				$("#modalContent").html(data);
			   }
		});		
	
	});	

	
	$("#btPesqProcess").click(function(e){
		e.preventDefault();
		
		var app = $("#title").val();
		var comp= $("#component").val();
		
		$("#listApp").html("Pesquisando...");

		$.ajax({
			   type: "POST",
			   data: "title="+app+"&component="+comp,
			   url: "/prime/process/listapp",
			   success: function(data){
				$("#listApp").html(data);
			   }
		});		
	});	
	
	$('.window .close').click(function (e) {
		e.preventDefault();
		$("#dialog").height('0px');
		$('#mask').hide();
		$('.window').hide();
	});		
	
	$('#mask').click(function () {
		$(this).hide();
		$('.window').hide();
	});	
	
	$('a[name=onPackage]').click(function(e) {
		$('#onPackage').hide();
		$('#dvPackage').show();
	});	
	
	$('a[name=btAppOn]').click(function(e) {
		$('#onApp').hide();
		$('#offApp').show();
	});
	

	$('a[name=btAppOff]').click(function(e) {
		$('#offApp').hide();
		$('#onApp').show();
	});	
	
	$('a[name=offPackage]').click(function(e) {
		$('#dvPackage').hide();
		$('#onPackage').show();
	});	
	
	
	$(".textFlow").click(function(e){
		$('.textFlow').removeAttr("readonly");
		$('#flow_id').attr('readonly', 'readonly');
	});
	
	$("#flow_id").click(function(e){
		$('#flow_id').removeAttr("readonly");
		$('.textFlow').attr('readonly', 'readonly');
		$('.textFlow').val("");
	});
	
	$('#tree6').checkboxTree({ 
		initializeChecked: 'expanded', 
		initializeUnchecked: 'collapsed', 
		onCheck: { node: 'expand'}, 
		onUncheck: { node: 'collapse'}, 
		collapseImage: '/image/downArrow.gif', 
		expandImage: '/image/rightArrow.gif'
	});		
	
	$('#treeComp').checkboxTree({ 
		initializeChecked: 'collapsed', 
		initializeUnchecked: 'collapsed', 
		onCheck: { node: 'expand'}, 
		onUncheck: { node: 'collapse'}, 
		collapseImage: '/image/downArrow.gif', 
		expandImage: '/image/rightArrow.gif'
	});

	 //hover states on the static widgets
	$('btEnviar').hover(
		function() { $(this).addClass('ui-state-hover'); },
		function() { $(this).removeClass('ui-state-hover'); }
	 ); 
	
});

/**
 * Método para envio de um id do produto selecionado
 */
function lnProdComp(component)
{
	var product = $("select[name='product_id']").val();
	if(component != "")
		component = "&component="+component;
	else
		component = "";
    $("#dvComponent").html("Carregando componente...");

	$.ajax({
		   type: "POST",
		   data: "product_id="+product+component,
		   url: "/prime/component/list",
		   success: function(data){
		     $("#dvComponent").html(data);
		   }
	});
}

/**
 * Método para carregar os comandos de um fluxo
 */
function listCommand()
{
	$("#command").html("Carregando..");
	var flow = $('select[id="flow_id"]').val();
	$.ajax({
		   type: "POST",
		   data: "flow_id="+flow,
		   url: "/prime/flow/getcommand",
		   success: function(data){
		     $("#command").html(data);
		   }
	});
}

/**
 * metodo para enviar um formulario de armazenamento 
 */
function addForm(url, form)
{
	var dados = $("#"+form).serialize();
	$.ajax({
		   type: "POST",
		   data: dados,
		   url: "/prime/"+url+"/save",
		   success: function(data){
			$("#modalContent").html(data);
		   }
	});
	
	if(url == "server")
	{
		$.ajax({
			   type: "POST",
			   url: "/prime/server/box",
			   success: function(data){
				$("#boxserver").html(data);
			   }
		});			
	}
	return false;
}

function lnRemoveApplication(amb, app, comp)
{
	if(confirm("Tem certeza que deseja remover?"))
	{
		$("#content").prepend("<div class='loading'>Carregando</div>");
		$.ajax({
			   type: "POST",
			   data: "component_id="+comp+"&application_id="+app+"&ambient_id="+amb,
			   url: "/prime/appliance/remove",
			   success: function(data){
					$(".loading").hide();
					$("#wrapper").html(data);
				}
		});
		return false;
	}
	return true;
}


function openPackage(type)
{
	var type_id = $(type).val();
	$("#package").hide();
	
	if(type_id == 1)
		$("#package").show();
}


/**
 * Edição de aplicação
 * @param app interger
 * @return
 */
function lnEditApp (app)
{
	$("#content").html("Carregando...");
	$.ajax({
		   type: "POST",
		   data: "&application_component_id="+app,
		   url:  "/prime/appliance/edit",
		   success: function(data){
				$("#content").html(data);
		   }
	});
	return false;
}

function linkIO(close1, close2, open)
{
	$('#'+close1).hide("fast");
	
	if(close2 == "add")
		$('#'+close2).show("fast"); 
	else
		$('#'+close2).hide("fast"); 
	$('#'+open).show('slow');
}


function addHeight(newTam, type)
{
}	

function deSelectComponent()
{
	$('input:radio[name=component_id]').removeAttr('checked');
}

/**
 * Metodo para remoção de servidor
 * transporta a variavel id parao controller server e metodo delete
 * @param id
 * @return html
 */
function RmvServer(id)
{
	$("#modalContent").html("Removendo...");
	$.ajax({
		   type: "POST",
		   data: "server_id="+id,
		   url: "/prime/server/delete",
		   success: function(data){
			$("#modalContent").html(data);
		   }
	});	
	return false;
}

/**
 * Metodo para remover Component
 * @param id
 * @return
 */
function removeComponent(id)
{
	if(id < 1)
	{
		alert("Erro: Selecione um componente.");
		$("input[name='component_id']").focus();
		return false;
	}
	
	if(confirm("Confirma a exclusão deste componente?"))
	{
		$("#content").append("<div class='loading'>Carregando</div>");
		var page = window.location;
		$.ajax({
			   type: "POST",
			   data: "component_id="+id+"&page="+page,
			   url: "/prime/component/remove",
			   success: function(data){
					window.location.reload(true);
					if(data)
						alert("Registro Removido.");
					else
						alert("Registro não removido tente novamente, mais tarde.");
			   }
		});		
		return true;
	}
}

function validComp()
{
	var prod = 	$('input:radio[name=product_id]:checked').val();
	if(prod > 0 && prod != undefined)
		return true;

	alert("Selecione um produto!");
	return false;
}

function assocProd(id)
{
	$("#content").prepend("<div class='loading'>Carregando</div>");
	$.ajax({
		   type: "POST",
		   data: "id="+id,
		   url: "/prime/component/assoc",
		   success: function(data){
			$(".loading").hide();
			$("#content").html(data);
		   }
	});		
	return true;	
}

/**
 * Método para atualizar lista de servidores
 */
function refreshServer ()
{
	$.ajax({
		   type:    "POST",
		   url:	    "/prime/server/box",
		   success: function(data){
				$("#boxserver").html(data);
		   }
	});
	return false;
}


/**
 * Método para validar argumento de comandos
 */
function validArgs (command)
{
	var component	=  $("#component_id"+command).val();
	var args	 	=  $("#args"+command).val();
	
	$("#message").html("<div class='loading'>Carregando</div>");

	if(args.length < 1 || args == undefined){
		alert("Por favor, preencha o argumento corretamente");
		return false;
	}

	if(command == "" && component == ""){
		alert("Click sobre a aba componente e acesse 'manutenção de componentes'.");
		return false;
	}
	
	$.ajax({
		   type:    "POST",
		   url:	    "/prime/component/saveargs",
		   data:	"component_id="+component+"&command_id="+command+"&args="+args,
		   success: function(data){
				$("#message").html(data);
		   }
	});
	return false;
}


function updateServer(id)
{
	var address  = $("#address"+id).val();
	var hostname = $("#hostname"+id).val();
	var port     = $("#port"+id).val();
	$("#modalContent").html("Atualizando...");
	
	if(address == null && id > 0)
	{
		alert("Erro: verifique se digitou um ip.");
		return false;
	}

	if(port == null && id > 0)
	{
		alert("Erro: verifique se digitou uma porta.");
		return false;
	}
	
	$.ajax({
		   type:    "POST",
		   url:	    "/prime/server/save",
		   data:	"hostname="+hostname+"&port="+port+"&address="+address+"&server_id="+id,
		   success: function(data){
				$("#modalContent").html(data);
		   }
	});
	return false;
}

function admUserSave(id)
{
	var profile_id	= 	$("select[name='profile_id"+id+"']").val();
	var client_id	= 	$("select[name='client_id"+id+"']").val();
	var status_id	= 	$("select[name='status_id"+id+"']").val();
	
	$("#content").html("<div class='loading'>Carregando</div>");
	
	$.ajax({
		   type:    "POST",
		   url:	    "/admin/user/save",
		   data:	"user_id="+id+"&client_id="+client_id+"&profile_id="+profile_id+"&status_id="+status_id,
		   success: function(data){
				$("#wrapper").html(data);
		   }
	});
	return false;
}

/**
 * Metodo para criar um iframe dinamicamente redimensionavel 
 * @param cmd
 * @param comp
 * @return
 */
function iframeRes(cmd, comp, ctl)
{
	if(cmd  == 0)
		cmd	= $("select[id='flow_id"+ctl+"']").val();
	
	if(cmd == undefined || cmd == "")
	{
		alert("Erro: comando inválido!");
		return false;
	}
		
	var $dialog =
	jQuery.FrameDialog.create({
		url: 'http://148.91.91.204/default/exec/command?flow_id='+cmd+'&component_id='+comp,
		loadingClass: 'loading-image',
		title: 'Executando Comando',
		width: 400,
		height: 300,
		autoOpen: false
	});
	$dialog.dialog('open');
	$("button").hide();
	$(".ui-dialog-buttonpane").hide();
	$(".ui-widget-overlay").hide();
	return false;
}

/**
 * Metodo para criar um iframe dinamicamente redimensionavel 
 * @return
 */
function iframeMonit()
{
	var amb	= $("select[id='ambient_id']").val();
	var serv= $("select[id='server_id']").val();
		
	var $dialog =
	jQuery.FrameDialog.create({
		url: 'http://148.91.91.204/monitor/execute/index?ambient_id='+amb+'&server_id='+serv,
		loadingClass: 'loading-image',
		title: 'Executando Comando',
		width: 800,
		height: 550,
		autoOpen: false
	});
	$dialog.dialog('open');
	$("button").hide();
	$(".ui-dialog-buttonpane").hide();
	//$(".ui-widget-overlay").hide();
	return false;
}

/**
 * Método para acessar edição de argumentos
 * @param int comp
 * @param int prod
 */
function acessArgs (comp, prod)
{
	var $dialog =
		jQuery.FrameDialog.create({
			url: 'http://148.91.91.204/prime/component/args?render=2&component_id='+comp+'&product_id='+prod,
			loadingClass: 'loading-image',
			title: 'Argumentos para comando',
			width: 680,
			height: 350,
			autoOpen: false
		});
		$dialog.dialog('open');
		$("button").hide();
		$(".ui-dialog-buttonpane").hide();
		$(".ui-widget-overlay").hide();
		return false;
}

/**
 * Metodo para verificar o health de um servidor
 * @param a
 * @param server
 * @return
 */
function abreHealth(a, server)
{
	$('#tb'+a).show(); 
	$('#ln'+a).hide();
	$('#fc'+a).show();
	
	$("#tb"+a).html("<div class='loading'>Carregando</div>");
	$.ajax({
		   type:    "POST",
		   url:	    "/monitor/health/list",
		   data:	"server_id="+server,
		   success: function(data){
				$("#tb"+a).html(data);
		   }
	});
}