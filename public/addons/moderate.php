<?php
	require dirname(__DIR__) . '/../private/autoload.php';
	use Glass\BoardManager;
	use Glass\AddonManager;
	use Glass\AddonObject;
	use Glass\UserManager;
	use Glass\UserLog;
//	use Glass\UserHandler;
	require_once(realpath(dirname(__DIR__) . "/../private/lib/Parsedown.php"));

	$user = UserManager::getCurrent();
	if(!$user->inGroup("Moderator")) {
		header('Location: /addons/addon.php?id=' . $addonObject->getId());
		return;
	}

	if($_POST['update'] ?? false) {
		AddonManager::updateInfo($_GET['id'] + 0,
			array(
				"description" => $_POST['description'],
				"name"        => $_POST['name'],
				"board"       => $_POST['board']
			)
		);
	}

	if(isset($_GET['id'])) {
		try {
			$addonObject = AddonManager::getFromId($_GET['id'] + 0);
			$boardObject = BoardManager::getFromID($addonObject->getBoard());
		} catch(Exception $e) {
			//board doesn't exist
			header('Location: /addons');
			die("addon doesnt exist");
		}
	} else {
		header('Location: /addons');
		die();
	}

	if(!$addonObject->getApproved()) {
		include 'unapproved.php';
		die();
	}

	$_PAGETITLE = "Blockland Glass | " . $addonObject->getName();

	include(realpath(dirname(__DIR__) . "/../private/header.php"));
	include(realpath(dirname(__DIR__) . "/../private/navigationbar.php"));
?>
<div class="maincontainer">
	<span style="font-size: 9pt;">
		<a href="addon.php?id=<?php echo $addonObject->getId() ?>"><?php echo $addonObject->getName() ?></a> >> <b>Moderate</b>
	</span>

	<div class="tile">

		<h2 style=\"margin-bottom: 0px;\">Moderating: <i><?php echo $addonObject->getName() ?></i></h2>
		<?php
			$author = $addonObject->getAuthor();
			echo "Uploaded by " . htmlspecialchars(utf8_encode($author->getUsername()));
		?>
		<div style="margin-top: 15px; margin-bottom: 15px; display: inline-block; width: 100%; font-size: 0.8em">
			<div class="addoninfoleft">
				<image style="height:1.5em" src="http://blocklandglass.com/img/icons32/tag.png" />
				<?php
				echo utf8_encode($boardObject->getName());
				?>
				<br />
				<image style="height:1.5em" src="http://blocklandglass.com/img/icons32/folder_vertical_zipper.png" />
				<?php
				echo $addonObject->getFilename();
				?>
				<br />
				<image style="height:1.5em" src="http://blocklandglass.com/img/icons32/time.png" />
				<?php echo date("M jS Y, g:i A", strtotime($addonObject->getUploadDate())); ?>
			</div>
			<div class="addoninforight">
				<?php
				echo ($addonObject->getDownloads("web") + $addonObject->getDownloads("ingame"));
				?>
				 <image style="height:1.5em" src="http://blocklandglass.com/img/icons32/inbox_download.png" /><br />
			</div>
		</div>
		<hr />
		<p>
			<?php
				$Parsedown = new Parsedown();
				$Parsedown->setBreaksEnabled(true);
				$Parsedown->setMarkupEscaped(true);

				//External links appearing in the description should open in a new tab and switch to that tab instead of replacing the current one
				echo $Parsedown->text($addonObject->getDescription());
			?>
		</p>
		<hr />
		<form method="post">
			<input type="hidden" name="update" value="1" />
		  <table class="formtable">
		    <tbody>
		      <tr>
		        <td style="width: 10%"><b>Title</b></td>
		        <td><input type="text" name="name" value="<?php echo htmlspecialchars($addonObject->getName()) ?>"/></td>
		      </tr>
		      <tr>
		        <td><b>Board</b></td>
		        <td>
							<select name="board">
								<?php

								foreach(BoardManager::getAllBoards() as $board) {
									if($board->getId() == $addonObject->getBoard()) {
										$selected = " selected";
									} else {
										$selected = "";
									}
									echo '<option value="' . $board->getId() . '"' . $selected . '>' . htmlspecialchars($board->getName()) . '</option>';
								}

								?>
							</select>
						</td>
		      </tr>
		      <tr>
		        <td><b>Description</b></td>
		        <td>
							<textarea name="description"><?php echo $addonObject->getDescription() ?></textarea>
						</td>
		      </tr>
		      <tr>
		        <td colspan="2">
		          <input type="submit" value="Update" />
		        </td>
		      </tr>
		    </tbody>
		  </table>
		</form>
	</div>
</div>
<?php include(realpath(dirname(__DIR__) . "/../private/footer.php")); ?>
