<?php
require_once __DIR__.'/../config.php';
require_once __DIR__.'/../controllers/StatusMessageController.php';
require_once __DIR__.'/../controllers/StringHandlerController.php';
require_once __DIR__.'/../controllers/SessionManagementController.php';

$sessionManager = new SessionManagementController(SESSION_COOKIE_PATH);
$sessionManager->CheckValidPage('../index.php', true);
$sessionManager->RemoveActivity();

$redirectURL = StatusMessageController::GetCleanRedirectURL();
header('Location: '.$redirectURL);