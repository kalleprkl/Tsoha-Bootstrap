 <?php
 
function check_logged_in(){
  BaseController::check_logged_in();
}

$routes->get('/raportit/:tutkimus_id', 'check_logged_in', function($tutkimus_id){
    RaporttiController::nayta($tutkimus_id);
});

$routes->get('/mittauspaikat/:koordinaatit/muokkaa', 'check_logged_in', function($koordinaatit){
    MittauspaikkaController::muokkaa($koordinaatit);
});

$routes->post('/mittauspaikat/:koordinaatit/paivita', 'check_logged_in', function($koordinaatit){
  MittauspaikkaController::paivita($koordinaatit);
});

$routes->post('/mittauspaikat/:koordinaatit/poista', 'check_logged_in', function($koordinaatit){
    MittauspaikkaController::poista($koordinaatit);
});

$routes->post('/mittauspaikat', 'check_logged_in', function(){
  MittauspaikkaController::tallenna();
});

$routes->get('/vesistot/:vesisto/uusi', 'check_logged_in', function($vesisto){
  MittauspaikkaController::uusi($vesisto);
});

$routes->get('/vesistot/:id/raportit', 'check_logged_in', function($id){
  RaporttiController::listaa($id);
});

$routes->post('/logout', function(){
  TutkijaController::logout();
});
 
 $routes->get('/login', function() {
    TutkijaController::login();
});
 
 $routes->post('/login', function(){
  TutkijaController::kasittele();
});
 
$routes->post('/vesistot', 'check_logged_in', function(){
  VesistoController::store();
});

$routes->get('/vesistot', 'check_logged_in', function() {
    VesistoController::index();
});

$routes->get('/vesistot/uusi', 'check_logged_in', function() {
    VesistoController::lomake();
});

$routes->get('/vesistot/:id', 'check_logged_in', function($id){
  VesistoController::show($id);
});

 $routes->get('/vesistot/:id/muokkaa', 'check_logged_in', function($id){
  VesistoController::muokkaa($id);
});

$routes->post('/vesistot/:id/paivita', 'check_logged_in', function($id){
  VesistoController::paivita($id);
});

$routes->post('/vesistot/:id/poista', 'check_logged_in', function($id){
    VesistoController::poista($id);
});

$routes->get('/', function() {
    View::make('/etusivu/etusivu.html');
});

$routes->get('/hiekkalaatikko', function() {
    HelloWorldController::sandbox();
});

$routes->get('/kohteet', function() {
    HelloWorldController::kohteet();
});

$routes->get('/kohde', function() {
    HelloWorldController::kohde();
});

$routes->get('/paikka', function() {
    HelloWorldController::paikka();
});

$routes->get('/raportti', function() {
    HelloWorldController::raportti();
});

$routes->get('/tyyppi', function() {
    HelloWorldController::tyyppi();
});

$routes->get('/muokkaaKohde', function() {
    HelloWorldController::muokkaaKohde();
});

$routes->get('/muokkaaPaikka', function() {
    HelloWorldController::muokkaaPaikka();
});

$routes->get('/muokkaaRaportti', function() {
    HelloWorldController::muokkaaRaportti();
});

$routes->get('/muokkaaNayte', function() {
    HelloWorldController::muokkaaNayte();
});

