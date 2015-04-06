/**
 * Arquivo de funcoes javascript pontuais para envio de dados
*/

function removeProduct(id)
{
	if(id < 1)
	{
		alert("Erro: Selecione um produto.");
		$("input[name='product_id']").focus();
		return false;
	}
	
	$("#wrapper").prepend("<div class='loading'>Carregando</div>");

	$.ajax({
		   type: "POST",
		   data: "product_id="+id,
		   url: "/admin/product/remove",
		   success: function(data){
			$("#wrapper").html(data);
		   }
	});		
	return true;	
}

/**
 * Metodo para remoção da associação de produto ao fluxo
*/
function removeAssocFlow (product, command)
{
	if(confirm("Confirma a exclusão deste produto?"))
	{
		$("#content").html("<div class='loading'>Carregando</div>");
		$.ajax({
			   type: "POST",
			   data: "product_id="+product+"&command_flow_id="+command,
			   url: "/admin/flow/removeassoc",
			   success: function(data){
				$("#wrapper").html(data);
			   }
		});
	}
	return false;
}
