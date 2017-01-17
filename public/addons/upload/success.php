<?php
	require dirname(__DIR__) . '/../../private/autoload.php';
  use Glass\UserManager;
  use Glass\AddonFileHandler;
  $user = UserManager::getCurrent();

  $_PAGETITLE = "Blockland Glass | Upload Success";

  include(realpath(dirname(dirname(__DIR__)) . "/../private/header.php"));
  include(realpath(dirname(dirname(__DIR__)) . "/../private/navigationbar.php"));
?>
<style>
  .typebox {
    width: 150px;
    background-color:#ccc;
    padding: 40px 15px;
    border-radius:10px;
    text-align:center;
    display: inline-block;
    margin: auto 0;
    vertical-align: middle;
    margin: 30px;
    text-decoration: none;
  }

  .typebox:hover {
    background-color: #eee;
    color: #222;
    text-decoration: none !important;
  }
</style>
<div class="maincontainer">
  <div class="tile">
    <h2>Success!</h2>
    <p>
      Your add-on uploaded successfully. It'll now be carefully reviewed by our reviewers and hopefully approved.
    </p>
    <p>
      <a href="/addons/">Back to Add-ons</a>
    </p>
  </div>
</div>

<?php include(realpath(dirname(dirname(__DIR__)) . "/../private/footer.php")); ?>