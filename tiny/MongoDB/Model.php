<?php declare(strict_types=1);


namespace Tiny\MongoDB;

use MongoDB\BSON\ObjectId;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Cursor;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Query;
use Tiny\Converter;
use Tiny\Logger;

abstract class Model {
    protected $db_;

    public function __construct(Config $config) {
        $this->db_ = new MongoDB($config);
    }

    abstract public function getCollection(): string;

    protected function find(Filter $filter, ?QueryOptions $queryOptions = null): Cursor {
        return $this->db_->getManager()->executeQuery($this->db_->getNs(),
            new Query($filter->getFilter(), $queryOptions->getQueryOptions() ?? []));
    }

    protected function update(Filter $filter, NewObject $newObject): bool {
        $bulk = new BulkWrite();
        $bulk->update($filter->getFilter(), $newObject->getNewObject(), ['upsert' => false, 'multi' => false]);
        try {
            $this->db_->getManager()->executeBulkWrite($this->db_->getNs(), $bulk);
            return true;
        } catch (BulkWriteException $e) {
            Logger::getInstance()->warn("executeBulkWrite BulkWriteException" . $e);
        } catch (\Exception $e) {
            Logger::getInstance()->error("executeBulkWrite" . $e);
        }
        return false;
    }

    protected function updateOrCreateWhenNotExists(Filter $filter, NewObject $newObject): bool {
        $bulk = new BulkWrite();
        $bulk->update($filter->getFilter(), $newObject->getNewObject(), ['upsert' => true, 'multi' => false]);
        try {
            $this->db_->getManager()->executeBulkWrite($this->db_->getNs(), $bulk);
            return true;
        } catch (BulkWriteException $e) {
            Logger::getInstance()->warn("executeBulkWrite BulkWriteException" . $e);
        } catch (\Exception $e) {
            Logger::getInstance()->error("executeBulkWrite" . $e);
        }
        return false;
    }

    protected function updateAll(Filter $filter, NewObject $newObject) {
        $bulk = new BulkWrite();
        $bulk->update($filter->getFilter(), $newObject->getNewObject(), ['upsert' => false, 'multi' => true]);
        try {
            $this->db_->getManager()->executeBulkWrite($this->db_->getNs(), $bulk);
            return true;
        } catch (BulkWriteException $e) {
            Logger::getInstance()->warn("executeBulkWrite BulkWriteException" . $e);
        } catch (\Exception $e) {
            Logger::getInstance()->error("executeBulkWrite" . $e);
        }
        return false;
    }

    protected function delete(Filter $filter): bool {
        try {
            $bulk = new BulkWrite();
            $bulk->delete($filter->getFilter());
            $this->db_->getManager()->executeBulkWrite($this->db_->getNs(), $bulk);
            return true;
        } catch (\Exception $e) {
            Logger::getInstance()->error("error remove");
        }
        return false;
    }

    protected function insert(Info $info): bool {
        $document = Converter::toStdClass($info);

        $bulk = new BulkWrite();
        $bulk->insert($document);
        try {
            $this->db_->getManager()->executeBulkWrite($this->db_->getNs(), $bulk);
            return true;
        } catch (BulkWriteException $e) {
            Logger::getInstance()->warn("executeBulkWrite BulkWriteException" . $e);
        } catch (\Exception $e) {
            Logger::getInstance()->error("executeBulkWrite" . $e);
        }
        return false;
    }

    public static function newObjectId(): string {
        return new ObjectId() . '';
    }
}