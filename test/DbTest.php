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
        $this->pdo_statement_swoole = $this->pdo_swoole->prepare('SELECT 1 AS name');
        $this->pdo_statement_swoole->setFetchMode(PDO::FETCH_ASSOC);
        $this->pdo_statement_swoole->execute([]);
        $result1 = $this->pdo_statement_swoole->fetchAll();


        $this->pdo_statement_native = $this->pdo_native->prepare('SELECT 1 AS name');
        $this->pdo_statement_native->setFetchMode(PDO::FETCH_ASSOC);
        $this->pdo_statement_native->execute([]);
        $result2 = $this->pdo_statement_native->fetchAll();

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
        foreach ($this->pdo_swoole->query('SELECT 1 AS name', PDO::FETCH_ASSOC) as $row) {
            $row1 = $row;
            break;
        }

        foreach ($this->pdo_native->query('SELECT 1 AS name', PDO::FETCH_ASSOC) as $row) {
            $row2 = $row;
            break;
        }

        $this->assertEquals($row1['name'] ?? null, $row2['name'] ?? null);
    }
}