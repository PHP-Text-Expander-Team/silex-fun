<?php

// web/index.php
require_once __DIR__.'/../vendor/autoload.php';

// Dependencies
use Silex\Application;
use Silex\Provider\TwigServiceProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

// Set up app
$app = new Application();
$app->register(new TwigServiceProvider(), array(
  'twig.path' => __DIR__.'/../views',
));
$app['debug'] = true;

// Landing page (with param fun)
$app->get('/hello/{name}', function ($name) use ($app) {
  return $app['twig']->render('hello.twig', array(
    'name' => $name,
  ));
});

// Post route that serves no pages, simply takes message val
$app->post('/article/new', function(Request $request) {
  $message = $request->get('message');

  // Go do MySQL stuff here, success response below

  return new Response('Success! Your message was: ' . $message, 201);
});

$app->get('/article/{id}', function($id) use ($app) {
  // Go do heavy mysql lookup here based in $id
  return $app->json(['id' => $id, 'stuff' => 'blah']);
});

$app->run();
