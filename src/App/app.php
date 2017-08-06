<?php

namespace UAP\App;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use UPA\CoreDomain\UriParser;
use UPA\CoreDomain\UriResolver;

$app = new Application();

$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->post('/uris', function (Request $request) use ($app) {

    $uriString = $request->request->get('uri_string', null);
    if (!$uriString) {
        $app->abort('400');
    }

    $uriResolver = new UriResolver(new UriParser());

    try {
        $uri = $uriResolver->resolve($uriString);
    } catch (\InvalidArgumentException $exception) {
        return $app->json(['error' => $exception->getMessage()], '422');
    }


    return $app->json($uri->getValue());
});

$app->run();
