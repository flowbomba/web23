<?PHP
if(!$logged) {
	$main_content .= 'You must be logged to see status of bugs. You are redirecting to login page in 5 seconds ...';
	echo '<meta http-equiv="refresh" content="5;URL=index.php?subtopic=accountmanagement">';
} else {
	if($group_id_of_acc_logged >= $config['site']['access_admin_panel']) {
		$mode = $_REQUEST['mode'];
		if(empty($mode) && $mode == "") {
					if($_SESSION['type'] == 1) {
						$main_content .= '<div style="background-color: #f1e0c6; padding:10px; border: 1px solid #fcefa1; color:#524b3a;"><b>Bug has been added with success!</b></div><br />';
					    unset($_SESSION['type']);
						$_SESSION['type'] == "";
					}
					
					if($_SESSION['type'] == 2) {
						$main_content .= '<div style="background-color: #f1e0c6; padding:10px; border: 1px solid #fcefa1; color:#524b3a;"><b>Bug has been deleted with success!</b></div><br />';
					    unset($_SESSION['type']);
						$_SESSION['type'] == "";
					}
					
					if($_SESSION['type'] == 3) {
						$main_content .= '<div style="background-color: #f1e0c6; padding:10px; border: 1px solid #fcefa1; color:#524b3a;"><b>Bug has been changed with success!</b></div><br />';
					    unset($_SESSION['type']);
						$_SESSION['type'] == "";
					}
					$main_content .='<table align="center" cellspacing="0" cellpadding="5" style="border: 2px solid #55636c;">
						<tr style="background-color: '.$config['site']['darkborder'].'"><td><img src="images/bugs/done.png" /></td><td>Done</td><td>&nbsp;</td><td><img src="images/bugs/progress.png" /></td><td>In Progress</td><td>&nbsp;</td><td><img src="images/bugs/pending.png" /></td><td>Pending</td></tr>
						</table><br />';
						
					$main_content .='<div class="TableContainer"><table class="Table3" cellpadding="0" cellspacing="0"><div class="CaptionContainer"><div class="CaptionInnerContainer"><span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span>
			<div class="Text">Bugs Progress</div><span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span><span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span></div></div>
				<tr>
					<td>
						<div class="InnerTableContainer">
							<table style="width:100%;">
								<tr>
									<td><div class="TableShadowContainerRightTop"><div class="TableShadowRightTop" style="background-image:url('.$layout_name.'/images/content/table-shadow-rt.gif);"></div></div>
										<div class="TableContentAndRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-rm.gif);">
											<div class="TableContentContainer">
												<table class="TableContent" width="100%">
													<tr class="LabelH">
														<td style="width:1%">Status</td>
														<td>Description</td><td style="width:6%">&#160;</td></tr>';
													
					$query = $SQL->query('SELECT * FROM '.$SQL->tableName('z_bug_logs').' ORDER BY status DESC;');
					$status = array(0 => "pending", 1 => "progress", 2 => "done");
					if($query->rowcount() == 0) {
						$main_content .='<tr style="'.$config['site']['lightborder'].'"><td colspan="3"><center>No bugs found</center></td></tr>';
					} else {
						$counter = 0;
						foreach($query->fetchAll() as $row) {
							if(is_int($counter / 2))
									$bgcolor = $config['site']['lightborder'];
								else
									$bgcolor = $config['site']['darkborder'];
								$counter++;
							$main_content .= '<tr style="background-color:'.$bgcolor.';"><td align="center"><img src="images/bugs/'.$status[$row['status']].'.png" /></td>
												<td>'.nl2br($row['description']).'</td>
												<td><a href="index.php?subtopic=bugrecords&mode=edit&id='.$row['id'].'"><img src="images/bugs/edit.png" /></a>
													<a href="index.php?subtopic=bugrecords&mode=del&id='.$row['id'].'" onclick="return confirm(\'Please Confirm Delete\');"><img src="images/bugs/delete.png" /></a>
												</td>';
												}
							$main_content .='</tr>';
						}
					
					$main_content .='			</table>
											</div>
										</div>
										<div class="TableShadowContainer"><div class="TableBottomShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bm.gif);"><div class="TableBottomLeftShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-bl.gif);"></div><div class="TableBottomRightShadow" style="background-image:url('.$layout_name.'/images/content/table-shadow-br.gif);"></div></div></div>
									</td>
								</tr>
							</table>
						</div>
					</div>
				</td>
			</tr>
			</table></div>';
				$main_content .= '<Br /><a href="index.php?subtopic=bugrecords&mode=add"><div class="BigButton" style="background-image:url(layouts/elemental/images/buttons/sbutton.gif)"><div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);"><div class="BigButtonOver" style="background-image:url(layouts/elemental/images/buttons/sbutton_over.gif);"></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="layouts/elemental/images/buttons/_sbutton_submit.gif"></div></div></a>';
		}
		
		if($mode == 'del') {
			if(isset($_GET['id']) and $_GET['id'] != "") {
				$SQL->query('DELETE FROM `z_bug_logs` WHERE `id` = '.$SQL->quote($_GET['id']).';');
				$_SESSION['type'] = 2;
				header('Location: index.php?subtopic=bugrecords');
			}
		}
		
		if($mode == 'edit') {
			if($_POST) {
				$SQL->query('UPDATE  `z_bug_logs` SET  `status` =  '.$_POST['status'].', `description` =  '.$SQL->quote($_POST['desc']).' WHERE  `id` ='.$_POST['bug_id'].';');
				$_SESSION['type'] = 3;
				header('Location: index.php?subtopic=bugrecords');
			}
			
			if(isset($_GET['id']) && $_GET['id'] != "") {
				if(empty($_POST) && !$_POST) {
				$q = $SQL->query('SELECT * FROM z_bug_logs WHERE id='.$SQL->quote($_GET['id']).';');
				if($q->rowcount() == 0) { $main_content .= 'Invalid Bug ID'; sleep(5); header('Location: index.php?subtopic=bugrecords'); } else {
				$r = $q->fetch();
				$main_content .='<form action="?subtopic=bugrecords&mode=edit" method="post" ><div class="TableContainer" >  <table class="Table1" cellpadding="0" cellspacing="0" >    <div class="CaptionContainer" >      <div class="CaptionInnerContainer" >        <span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <div class="Text" >Edit Bug</div>        <span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);" /></span>        <span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);" ></span>        <span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>        <span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);" /></span>      </div>    </div>    <tr>      <td>        <div class="InnerTableContainer" ><input type="hidden" name="bug_id" value="'.$_GET['id'].'" />
<table style="width:100%;">
		<tr>
			<td class="LabelV">
				<span>Status</span>
			</td>
			<td style="width:90%;">
				<table cellspacing="2" cellpadding="5">
					<tr>
						<td><input type="radio" name="status" value="2" '; if($r['status'] == 2) { $main_content .= 'checked'; } $main_content .='><img src="images/bugs/done.png" /></td>
						<td>Done</td>
						
						<td><input type="radio" name="status" value="1" '; if($r['status'] == 1) { $main_content .= 'checked'; } $main_content .='><img src="images/bugs/progress.png" /></td>
						<td>In Progress</td>
						
						<td><input type="radio" name="status" value="0" '; if($r['status'] == 0) { $main_content .= 'checked'; } $main_content .='><img src="images/bugs/pending.png" /></td>
						<td>Pending</td>
					</tr>
				</table>
			</td>
		</tr>
		
		<tr>
		<td class="LabelV">
			<span>Description</span>
		</td>
		<td>
			<textarea name="desc" rows="10" cols="80">'.($r['description']).'</textarea>
		</td>
	</tr>
</table></div>  </table></div></td></tr><br/><table style="width:100%" ><tr align="center" ><td><table border="0" cellspacing="0" cellpadding="0" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif" ></div></div></td><tr></form></table></td><td><table border="0" cellspacing="0" cellpadding="0" ><form action="?subtopic=bugrecords" method="post" ><tr><td style="border:0px;" ><div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)" ><div onMouseOver="MouseOverBigButton(this);" onMouseOut="MouseOutBigButton(this);" ><div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);" ></div><input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif" ></div></div></td></tr></form></table></td></tr></table> 
';
	}
	}
}
}
		
		if($mode == 'add') {
			if(empty($_POST) && !$_POST) {
				$main_content .= '<form action="?subtopic=bugrecords&mode=add" method="post">
	<div class="TableContainer">
		<table class="Table1" cellpadding="0" cellspacing="0">
		<div class="CaptionContainer">
			<div class="CaptionInnerContainer">
				<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span>
				<div class="Text">
					Add Bugs
				</div>
				<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span><span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span>
			</div>
		</div>
		<tr>
			<td>
				<div class="InnerTableContainer">
					<table style="width:100%;">
					<tr>
						<td class="LabelV">
							Status
						</td>
						<td style="width:90%;">
							<table cellspacing="2" cellpadding="5">
								<tr>
									<td><input type="radio" name="status" value="2" ><img src="images/bugs/done.png" /></td>
									<td>Done</td>
								
									<td><input type="radio" name="status" value="1"><img src="images/bugs/progress.png" /></td>
									<td>In Progress</td>
								
									<td><input type="radio" name="status" value="0" checked><img src="images/bugs/pending.png" /></td>
									<td>Pending</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="LabelV">
							Description:
						</td>
						<td>
							<textarea name="desc" rows="10" cols="80"></textarea>
						</td>
					</tr>
					</table>
				</div>
				</table>
			</div>
		</td>
	</tr>
	<br/>
	<table width="100%">
	<tr align="center">
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<form action="?subtopic=accountmanagement" method="post">
					<tr>
						<td style="border:0px;">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
								<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
									<div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);">
									</div>
									<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif">
								</div>
							</div>
						</td>
					</tr>
				</form>
			</table>
			</td>
			<td>
				<table border="0" cellspacing="0" cellpadding="0">
					<form action="?subtopic=bugrecords" method="post">
						<tr>
							<td style="border:0px;">
								<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
									<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
										<div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);">
										</div>
										<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif">
									</div>
								</div>
							</td>
						</tr>
					</form>
				</table>
			</td>
		</tr>
	</table>';
			} else {
				if(empty($_POST['desc'])) {
					$main_content .= '<div style="border:1px solid #cd0a0a; padding:10px; background-color: #be2e17; color:white;">ERROR: The field <u><b>Description</b></u> is empty</div>';
					$main_content .= '<Br /><form action="?subtopic=bugrecords&mode=add" method="post">
	<div class="TableContainer">
		<table class="Table1" cellpadding="0" cellspacing="0">
		<div class="CaptionContainer">
			<div class="CaptionInnerContainer">
				<span class="CaptionEdgeLeftTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightTop" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionBorderTop" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionVerticalLeft" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span>
				<div class="Text">
					Add Bugs
				</div>
				<span class="CaptionVerticalRight" style="background-image:url('.$layout_name.'/images/content/box-frame-vertical.gif);"/></span><span class="CaptionBorderBottom" style="background-image:url('.$layout_name.'/images/content/table-headline-border.gif);"></span><span class="CaptionEdgeLeftBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span><span class="CaptionEdgeRightBottom" style="background-image:url('.$layout_name.'/images/content/box-frame-edge.gif);"/></span>
			</div>
		</div>
		<tr>
			<td>
				<div class="InnerTableContainer">
					<table style="width:100%;">
					<tr>
						<td class="LabelV">
							Status
						</td>
						<td style="width:90%;">
							<table cellspacing="2" cellpadding="5">
								<tr>
									<td><input type="radio" name="status" value="2" ><img src="images/bugs/done.png" /></td>
									<td>Done</td>
								
									<td><input type="radio" name="status" value="1"><img src="images/bugs/progress.png" /></td>
									<td>In Progress</td>
								
									<td><input type="radio" name="status" value="0" checked><img src="images/bugs/pending.png" /></td>
									<td>Pending</td>
								</tr>
							</table>
						</td>
					</tr>
					<tr>
						<td class="LabelV">
							Description:
						</td>
						<td>
							<textarea name="desc" rows="10" cols="80"></textarea>
						</td>
					</tr>
					</table>
				</div>
				</table>
			</div>
		</td>
	</tr>
	<br/>
	<table width="100%">
	<tr align="center">
		<td>
			<table border="0" cellspacing="0" cellpadding="0">
				<form action="?subtopic=accountmanagement" method="post">
					<tr>
						<td style="border:0px;">
							<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
								<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
									<div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);">
									</div>
									<input class="ButtonText" type="image" name="Submit" alt="Submit" src="'.$layout_name.'/images/buttons/_sbutton_submit.gif">
								</div>
							</div>
						</td>
					</tr>
				</form>
			</table>
			</td>
			<td>
				<table border="0" cellspacing="0" cellpadding="0">
					<form action="?subtopic=bugrecords" method="post">
						<tr>
							<td style="border:0px;">
								<div class="BigButton" style="background-image:url('.$layout_name.'/images/buttons/sbutton.gif)">
									<div onmouseover="MouseOverBigButton(this);" onmouseout="MouseOutBigButton(this);">
										<div class="BigButtonOver" style="background-image:url('.$layout_name.'/images/buttons/sbutton_over.gif);">
										</div>
										<input class="ButtonText" type="image" name="Back" alt="Back" src="'.$layout_name.'/images/buttons/_sbutton_back.gif">
									</div>
								</div>
							</td>
						</tr>
					</form>
				</table>
			</td>
		</tr>
	</table>';
				} else {
					$q = $SQL->query('INSERT INTO `z_bug_logs` (`account_id`, `status`, `description`, `time`) VALUES ("'.$account_logged->getId().'", "'.$_POST['status'].'", "'.$_POST['desc'].'", '.time().');');
					if($q) {
						$_SESSION['type'] = 1;
						header('Location: index.php?subtopic=bugrecords');
					}
				}
			}
		} $main_content .= '<br /><br /><div style="text-align:right;"><small>idealized by <a href="http://www.earth-global.com">Earth-Global</a><br />coded by <a href="http://gpedro.net/">gpedro</a><br /> [<a href="https://forums.otserv.com.br/index.php?/profile/3402-gpedro/">@OTServBrasil</a>][<a href="http://otland.net/members/gpedro/">@OTLand</a>]<br /><b>PLEASE DON\'T REMOVE COPYRIGHT</a></small></div>';
	} else { $main_content .= 'Invalid subtopic. Can\'t load page.'; }
}