<?php
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Inserir Campos Dinamicamente com PHP e JQuery</title>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<style type="text/css">
.form-style-5{
	width: 97%;
	padding: 10px 20px;
	background: #f4f7f8;
	padding: 20px;
	background: #f4f7f8;
	border-radius: 8px;
	font-family: Georgia, "Times New Roman", Times, serif;
}
.form-style-5 fieldset{
	border: none;
}
.form-style-5 legend {
	font-size: 1.4em;
	margin-bottom: 10px;
}
.form-style-5 label {
	display: block;
	margin-bottom: 8px;
}
.form-style-5 input[type="text"],
.form-style-5 input[type="date"],
.form-style-5 input[type="datetime"],
.form-style-5 input[type="email"],
.form-style-5 input[type="number"],
.form-style-5 input[type="search"],
.form-style-5 input[type="time"],
.form-style-5 input[type="url"],
.form-style-5 textarea,
.form-style-5 select {
	font-family: Georgia, "Times New Roman", Times, serif;
	background: rgba(255,255,255,.1);
	border: none;
	border-radius: 4px;
	font-size: 16px;
	margin: 0;
	outline: 0;
	padding: 7px;
	width: 100%;
	box-sizing: border-box; 
	-webkit-box-sizing: border-box;
	-moz-box-sizing: border-box; 
	background-color: #e8eeef;
	color:#8a97a0;
	-webkit-box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
	box-shadow: 0 1px 0 rgba(0,0,0,0.03) inset;
	margin-bottom: 30px;
	
}
.form-style-5 input[type="text"]:focus,
.form-style-5 input[type="date"]:focus,
.form-style-5 input[type="datetime"]:focus,
.form-style-5 input[type="email"]:focus,
.form-style-5 input[type="number"]:focus,
.form-style-5 input[type="search"]:focus,
.form-style-5 input[type="time"]:focus,
.form-style-5 input[type="url"]:focus,
.form-style-5 textarea:focus,
.form-style-5 select:focus{
	background: #d2d9dd;
}
.form-style-5 select{
	-webkit-appearance: menulist-button;
	height:35px;
}
.form-style-5 .number {
    display: inline-block;
	background: #1abc9c;
	color: #fff;
	height: 30px;
	width: 30px;
	display: inline-block;
	font-size: 0.8em;
	margin-right: 4px;
	line-height: 30px;
	text-align: center;
	text-shadow: 0 1px 0 rgba(255,255,255,0.2);
	border-radius: 15px 15px 15px 0px;
}

.collapsible {
  background-color: #777;
  color: white;
  cursor: pointer;
  padding: 18px;
  width: 100%;
  border: none;
  text-align: left;
  outline: none;
  font-size: 15px;
}

.active, .collapsible:hover {
  background-color: #555;
}

.content {
  padding: 0 18px;
  display: none;
  overflow: hidden;
  background-color: #f1f1f1;
}
</style>
</head>
<body>
<form id="cases_fields">
<div class="form-style-5">
<!-- Card Primeira Parte -->
<button type="button" class="collapsible">+ Testes</button>

<!-- Créditos: https://www.youtube.com/watch?v=rVmZXJj5lH0 -->
<div id='secao1_content1' class="content table-responsive">
<input type="hidden" name="json_delete" id="json_delete" value="">

<?php 
require_once('db.php');
$array = get_card();
$cont = 0;
foreach($array as $key=>$value): 
    $cont++;
?>
<fieldset id="card_row<?php echo $cont;?>" style='display: inline;margin-right:4%;width:25%;'>
<input type="hidden" name="id_card[]" value="<?php echo $value['id_card'];?>">
<legend><span class="number"><?php echo $cont;?></span>Card</legend>
<label>Título:</label><input type="text" name="title_card[]" placeholder="Titulo do Card " value="<?php echo $value['title_card'];?>">
<label>Objetivo:</label><input type="text" name="subtitle_card[]" placeholder="SubTitulo do Card" value="<?php echo $value['subtitle_card'];?>">
<label>Número Impacto:</label><input type="text" name="text_footer_card[]" placeholder="Texto Card Footer" value="<?php echo $value['text_footer_card'];?>">
<label>Descrição:</label><input type="text" name="subtext_footer_card[]" placeholder="SubTexto Card Footer" value="<?php echo $value['subtext_footer_card'];?>">
<label>Link:</label><input type="text" name="card_link[]" placeholder="Link" value="<?php echo $value['card_link'];?>">
<button type="button" name="remove" id="<?php echo $cont;?>" class="btn btn-danger btn_remove">X</button>
</fieldset>
<?php endforeach; ?>

<button type="button" name="add" id="add" class="btn btn-success">Adicionar Item</button>
<input type="button" id="cases_submit" class="btn btn-info" value="Salvar"/>
</div>

</div>
</form>
</body>
</html>

<script>
$(document).ready(function(){
    //JS para expandir e reduzir conteudo
    var coll = document.getElementsByClassName("collapsible");
    var j;
    for (j = 0; j < coll.length; j++) {
      coll[j].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.display === "block") {
          content.style.display = "none";
        } else {
          content.style.display = "block";
        }
      });
    }

    //inserindo cards dinamicamente 
	$('#add').click(function(){
        var i=parseInt($('fieldset[id*=card_row]').length) + 1;
        var cont = 0;
        $('fieldset[id*=card_row]').each(function(index){
            var title = $(this).find("[name*=title_card]").val();
            if(title == ""){
                cont++;
            }
        });
    
       if(cont > 0){
           alert('Existe um card em branco. Por favor, insira dados para continuar criando');
           return false;
       }else{
            $('#secao1_content1').append('<fieldset id="card_row'+i+'" style="display:inline;margin-right:4%;width:25%;"> <input type="hidden" name="id_card[]" value="">'
                   + '<legend><span class="number">'+i+'</span>Card</legend>'
                   + '<label>Título:</label><input type="text" name="title_card[]" placeholder="Titulo do Card ">'
                   + '<label>Objetivo:</label><input type="text" name="subtitle_card[]" placeholder="SubTitulo do Card">'
                   + '<label>Número Impacto:</label><input type="text" name="text_footer_card[]" placeholder="Texto Card Footer">'
                   + '<label>Descrição:</label><input type="text" name="subtext_footer_card[]" placeholder="SubTexto Card Footer">'
                   + '<label>Link:</label><input type="text" name="card_link[]" placeholder="Link">'
                   + '<button type="button" name="remove" id="'+i+'" class="btn btn-danger btn_remove">X</button>');
       }
	});
	
	$(document).on('click', '.btn_remove', function(){
        var button_id = $(this).attr("id"); 
        var id_delete = $('fieldset[id=card_row'+button_id+']').find("[name*=id_card]").val();
        if(id_delete != undefined && id_delete != ''){
            if (confirm('Tem certeza que deseja apagar este card?')){
                var json_delete = $('#json_delete').val();
                if(json_delete != ""){
                    json_delete = json_delete + "," + id_delete;
                }else{
                    json_delete = id_delete;
                }
                $("#json_delete").val(json_delete);
                $('#card_row'+button_id).remove();
            }else{
                // Do nothing!
            }
        }else{
            $('#card_row'+button_id).remove();
        }
        
    });
    
    $('#cases_submit').click(function(){
        var json_delete = $('#json_delete').val();
        if(json_delete == "" || json_delete == undefined){
            json_delete = false;
        }
        //?id_delete=" + json_delete
        $.ajax({
			url:"name.php",
			method:"POST",
			data:$('#cases_fields').serialize(),
            success:function(data){
                location.reload();
			}
		});
	});

});
</script>