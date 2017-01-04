 <?php

$routes->post('/vesistot', function(){
  VesistoController::store();
});

$routes->get('/vesistot', function() {
    VesistoController::index();
});

$routes->get('/vesistot/uusi', function() {
    VesistoController::lomake();
});

$routes->get('/vesistot/:id', function($id){
  VesistoController::show($id);
});

$routes->get('/', function() {
    VesistoController::index();
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

