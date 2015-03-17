<?php

namespace Opf\Mvc;

use Opf\Filter\Chain;
use Opf\Filter\FilterInterface;
use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class Controller implements ControllerInterface
{
    private $resolver;
    private $preFilters;
    private $postFilters;

    public function __construct(CommandResolverInterface $resolver)
    {
        $this->resolver    = $resolver;
        $this->preFilters  = new Chain();
        $this->postFilters = new Chain();
    }

    public function handleRequest(RequestInterface $request, ResponseInterface $response)
    {
        $this->preFilters->processFilters($request, $response);
        $command = $this->resolver->getCommand($request, $response);

        /*
         * test about ?cmd=xxx to choose the right controller
         * if cmd not found, we use cmd=main as default
         */
        if ($request->issetParameter('action') === false) {
            $cmd = 'main';
        } else {
            $cmd = $request->getParameter('action');
        }

        if (method_exists($command, $cmd) === false) {
            throw new \Exception('There is no method "' . $cmd . '"', 404);
        }

        if (extension_loaded ('newrelic')) {
            newrelic_name_transaction (join('', array_slice(explode('\\', get_class($command)), -1)) . '/' . $cmd);
        }

        $command->$cmd();

        $this->postFilters->processFilters($request, $response);

        $response->flush();
    }

    public function addPreFilter(FilterInterface $filter)
    {
        $this->preFilters->addFilter($filter);
    }

    public function addPostFilter(FilterInterface $filter)
    {
        $this->postFilters->addFilter($filter);
    }
}
