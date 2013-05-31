<?php
/**
 * Created by JetBrains PhpStorm.
 * User: ofeige
 * Date: 25.05.13
 * Time: 14:20
 * To change this template use File | Settings | File Templates.
 */

namespace Opf\Http;


class Request implements RequestInterface {

   private $parameters;

   public function __construct() {
      $this->parameters = $_REQUEST;
   }

   public function issetParameter($name) {
      return isset($this->parameters[$name]);
   }

   public function getParameter($name) {
      if (isset($this->parameters[$name])) {
         return $this->parameters[$name];
      }
      return null;
   }

   public function getParameterNames() {
      return array_keys($this->parameters);
   }

   public function getHeader($name) {
      $name = 'HTTP_' . strtoupper(str_replace('-', '_', $name));
      if (isset($_SERVER[$name])) {
         return $_SERVER[$name];
      }
      return null;
   }

   public function getAuthData() {
      if (!isset($_SERVER['PHP_AUTH_USER'])) {
         return null;
      }
      return array('user' => $_SERVER['PHP_AUTH_USER'], 'password' => $_SERVER['PHP_AUTH_PW']);
   }

   public function getRemoteAddress() {
      return $_SERVER['REMOTE_ADDR'];
   }
}