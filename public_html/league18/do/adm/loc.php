<?php
/* ~ Global Include ~ */
$patch_project = $_SERVER['DOCUMENT_ROOT'];
$patch_global = $patch_project.'/inc/conf/global.php';
if(!empty($patch_global)){
    if(!file_exists($patch_global)){
        die('The problem with the connection files.');
    }else{
		require_once($patch_global);
    }
}
if($_SESSION['id'] == 1 || $_SESSION['id'] == 2 || $_SESSION['id'] == 3 || $_SESSION['id'] == 8 ) {

$LocationQuery = $mysqli->query("SELECT * FROM `base_location`");

if(isset($_POST['id'])){
	$update = $mysqli->query("UPDATE `base_location` SET `".$_POST['id']."` = '".$_POST['value']."' WHERE `id` = '".$_POST['locID']."'");
}
}
?>
<html>
	<head>
		<title>Информация о локациях</title>
		<LINK REL='Stylesheet' HREF='/css/bootstrap.css' TYPE='text/css'>
		<script src="/js/jquery/jquery.js"></script>
		<script src="/js/jquery/notify.js"></script>
		<script type="text/javascript" language="javascript">
		function TurnType(e,loc){
			var data = $(e).text();
			$(e).replaceWith("<textarea id="+e.id+" onkeydown='if(event.keyCode==13) {ajaxResponse(this); return false;}' class='form-control' type='text' value="+data+" data-id="+loc+" >"+data+"</textarea>");
			$('textarea').focus();
		}
		function ajaxResponse(e){
			var div = $(".form-control");
			var id = $(div).attr('id');
			var val = div.val();
			var loc = $(div).attr('data-id');
			if($('textarea').length != 0){
				if (!div.is(e.target)  && div.has(e.target).length === 0) {
					$.ajax({
						type: 'POST',
						data: {
							id: id,
							value: val,
							locID: loc
						},
						success: function() {
							$('textarea').replaceWith('<td id='+id+' ondblclick="TurnType(this);">'+$('textarea').val()+'</td>');
						}
					});
				}
			}
		}
</script>
	</head>
	<body style="background-color: rgb(241, 241, 241); text-align: center;">
	<table class="table">
		<caption>
		  Локации (для редактирования два клика) 
		</caption>
		<thead>
			<tr>
				<th>ID</th>
				<th>Название</th>
				<th>Описание</th>
			</tr>
		</thead>
		<tbody>
		<?
			while($location = $LocationQuery->fetch_assoc()){
		?>
		<tr>
			<td id="id" ondblclick="TurnType(this,<?=$location['id'];?>);"><?=$location['id'];?></td>
			<td id="name" ondblclick="TurnType(this,<?=$location['id'];?>);"><?=$location['name'];?></td>
			<td id="description" ondblclick="TurnType(this,<?=$location['id'];?>);"><?=$location['description'];?></td>
		</tr>
		<?}?>
		</tbody>
	</table>
	<script>
	
	$(document).on('mouseup',function (e){
		ajaxResponse(e);
	});
	</script>
	</body>
</html>