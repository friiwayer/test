<?
echo '<!DOCTYPE html><html lang="en">';
require_once 'view/index.php';
$page = new Page;
$page->head();
echo '<body>';
$page->form();
$page->footer;
$page->exec_js();
echo '<body/></html>';
