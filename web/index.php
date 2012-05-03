<?php

require_once __DIR__.'/../silex.phar';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;


$app = new Silex\Application();
$app['debug'] = true;

$app->get('/', function() use($app)
{
  return 'Hello, this is facebook mock app. Go to https://github.com/nixilla/FacebookMocker for details.';
});

$app->get('/dialog/oauth', function(Request $request) use($app)
{
  return new RedirectResponse(sprintf('%s?state=%s&code=1234',$request->get('redirect_uri'), $request->get('state')));
});

$app->get('/oauth/access_token', function(Request $request) use($app)
{
  return sprintf('access_token=%s&expires=%s', md5(uniqid()), time() + rand(600, 3600));
});

$app->get('/me', function(Request $request) use($app)
{
  $output = array(
    'id' => '123456789',
    'name' => 'John Smith',
    'first_name' => 'John',
    'last_name' => 'Smith',
    'link' => 'http://www.facebook.com/123456789',
    'gender' => 'male',
    'locale' => 'en_GB',
    'email' => 'john.smith@example.test',
    'birthday' => '12/31/1981'
  );

  return json_encode($output);
});

$app->run();