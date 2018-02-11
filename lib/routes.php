<?php

Flight::route('/', function(){
	$v = Flight::vincent();
	
	Flight::render('header', ['title'=>'Vincent admin', 'menu'=>$v->menu()]);
	Flight::render('footer');
});

Flight::route('/@table/list', function($table){
	$v = Flight::vincent();
	$rows = Flight::rows();
	
	$tables = $v->tables();
	if (empty($tables[$table]['list'])) {
		Flight::notFound();
	}
	$fields = explode(' ', $tables[$table]['list']);
	
	$pageNo = 1;
	if (!empty($_GET['page'])) $pageNo = $_GET['page'];
 	$recordCount = $rows->count($table);
	$page = $rows->page($table, [], [], $pageNo);
	$pageCount = $rows->pages;
	
	Flight::render('header', ['title'=>$table, 'menu'=>$v->menu()]);
	Flight::render('list', ['table'=>$table, 'fields'=>$fields, 'page'=>$page, 'pageNo'=>$pageNo, 'pageCount'=>$pageCount, 'recordCount'=>$recordCount]);
	Flight::render('footer');
});

Flight::route('/@table/create', function($table){
	$v = Flight::vincent();
	$form = $v->form($table);
	if (empty($form)) Flight::notFound();
	
	
	Flight::render('header', ['title'=>$table, 'menu'=>$v->menu()]);
	Flight::render('form', ['form'=>$form]);
	Flight::render('footer');
});

Flight::route('/@table/edit/@id', function($table, $id){
	$v = Flight::vincent();
	$rows = Flight::rows();
	$form = $v->form($table);
	$data = $rows->one($table, $id);
	$form->fill($data);
	
	Flight::render('header', ['title'=>$table, 'menu'=>$v->menu()]);
	Flight::render('form', ['form'=>$form]);
	Flight::render('footer');
});

Flight::route('/@table/delete/@id', function($table, $id){
	Flight::forbidden(); // not yet implemented
	$v = Flight::vincent();
	$form = $v->form($table);
	
	Flight::render('header');
	Flight::render('form', ['form'=>$form]);
	Flight::render('footer');
});