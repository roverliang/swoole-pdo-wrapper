<?php
namespace KuaiappTest\Db;

use Swoole\Coroutine as co;
use Kuaiapp\Db\Pdo\PDO as PDO;
use KuaiappTest\Db\AbstractTestCase;

/**
 * 测试用例
 */
class DbTest extends AbstractTestCase
{
    /**
     * PDO::prepare + PDOStatement::fetchAll
     *
     * @return void
     */
    public function __PDO_prepare_and_PDOStatement_fetchAll()
    {
        // 常规fetch PDO::FETCH_ASSOC
        $db = new PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $stmt = $db->prepare('SELECT 1 AS name');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([]);
        $result1 = $stmt->fetchAll();


        $db = new \PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        $stmt = $db->prepare('SELECT 1 AS name');
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute([]);
        $result2 = $stmt->fetchAll();

        $this->assertEquals($result2, $result1);

        // @todo: 转Model  PDO::FETCH_CLASS
    }

    /**
     * PDO::query
     *
     * @return void
     */
    public function __PDO_query()
    {
        $row1 = $row2 = [];
        $db = new \PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        foreach ($db->query('SELECT 1 AS name', PDO::FETCH_ASSOC) as $row) {
            $row1 = $row;
            break;
        }

        $db = new PDO('mysql:host='.getenv('DB_HOST').';dbname='.getenv('DB_NAME').'', getenv('DB_USERNAME'), getenv('DB_PASSWORD'));
        foreach ($db->query('SELECT 1 AS name', PDO::FETCH_ASSOC) as $row) {
            $row2 = $row;
            break;
        }

        $this->assertEquals($row1, $row2);
    }
}