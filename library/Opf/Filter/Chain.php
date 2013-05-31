<?php

namespace Opf\Filter;

use Opf\Http\RequestInterface;
use Opf\Http\ResponseInterface;

class Chain
{
   private $filters = array();

   public function addFilter(FilterInterface $filter)
   {
      $this->filters[] = $filter;
   }

   public function processFilters(RequestInterface $request, ResponseInterface $response)
   {
      foreach ($this->filters as $filter) {
         $filter->execute($request, $response);
      }
   }
}

?>