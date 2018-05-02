<?php
namespace KuaiappTest\Db;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;

class AbstractTestCase extends TestCase
{
    public function __construct()
    {
        $dotenv = new Dotenv(__DIR__.'/../');
        $dotenv->load();
    }

    public function testAll()
    {
        go(
            function () {
                $methods = get_class_methods($this);
                foreach ($methods as $method) {
                    if (preg_match('/^__PDO/', $method)) {
                        $this->$method();
                    }
                }
            }
        );
    }
}