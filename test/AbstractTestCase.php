<?php
namespace KuaiappTest\Db;

use PHPUnit\Framework\TestCase;
use Dotenv\Dotenv;
use Kuaiapp\Db\Pdo\PDO as KuaiPDO;
use Kuaiapp\Db\Pdo\PDOStatement as KuaiPDOStatement;
use PDO as NativePDO;
use PDOStatement as NativePDOStatement;

class AbstractTestCase extends TestCase
{
    /**
     * PDO Swoole
     * 
     * @var KuaiPDO
     */
    public $pdo_swoole = null;

    /**
     * PDO Native
     * 
     * @var NativePDO
     */
    public $pdo_native = null;

    /**
     * PDOStatement Swoole
     * 
     * @var KuaiPDOStatement
     */
    public $pdo_statement_swoole = null;

    /**
     * PDOStatement Native
     * 
     * @var NativePDOStatement
     */
    public $pdo_statement_native = null;

    /**
     * 初始化
     */
    public function __construct()
    {
        $dotenv = new Dotenv(__DIR__.'/../');
        $dotenv->load();
    }

    /**
     * 初始化数据库
     *
     * @return void
     */
    private function _initDB()
    {
        //print_r(['mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD')]);
        $this->pdo_swoole = new KuaiPDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $this->pdo_native = new NativePDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
    }

    /**
     * 结束
     *
     * @return void
     */
    private function _terminate()
    {
        exit;
    }

    /**
     * Run all tests
     *
     * @return void
     */
    public function testAll()
    {
        go(
            function () {
                $methods = get_class_methods($this);
                foreach ($methods as $method) {
                    if (preg_match('/^__PDO/', $method)) {
                        $this->_initDB();
                        $this->$method();
                    }
                }
                $this->_terminate();
            }
        );
    }
}