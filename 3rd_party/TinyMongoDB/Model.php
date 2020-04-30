<?php


namespace Tiny\MongoDB;

use MongoDB\BSON\ObjectId;
use MongoDB\Driver\BulkWrite;
use MongoDB\Driver\Command;
use MongoDB\Driver\Exception\BulkWriteException;
use MongoDB\Driver\Exception\Exception;
use MongoDB\Driver\Query;
use Tiny\Logger;
use Tiny\Util\Clazz;
use Tiny\Util\Validator;

abstract class Model {
  /**
   * @var MongoDB
   */
  private $db_;

  abstract protected function collection(): string;

  abstract protected function info(): Clazz;

  public function __construct() {
    $this->db_ = new MongoDB($this->collection());
  }

  private $objectHasUsed = false;

  /**
   * @return array|null
   * @throws \ReflectionException
   */
  protected function find(): ?array {
    $this->checkIfObjectUsed();
    try {
      $cursors = $this->db_->getManager()->executeQuery(
        $this->db_->getNs(), new Query($this->filter, $this->options));
    } catch (Exception $exception) {
      Logger::getInstance()->error("executeBulkWrite" . $exception);
      return null;
    }

    $clazz = new \ReflectionClass($this->info()->getName());
    $instance = $clazz->newInstanceWithoutConstructor();

    $results = [];
    foreach ($cursors as $result) {
      $validator = new Validator();
      $validator->goCheck($result, $instance);

      $infoClass = $this->info()->getName();
      $info = new $infoClass;
      foreach ($result as $key => $value) {
        $info->{$key} = $value;
      }

      $results[] = $info;
    }

    return $results;
  }

  /**
   * @param Info $info
   * @return bool
   * @throws \ReflectionException
   */
  protected function create(Info $info): bool {
    $clazz = new \ReflectionClass($this->info()->getName());
    $instance = $clazz->newInstanceWithoutConstructor();

    $validator = new Validator();
    $validator->goCheck($info, $instance);

    $bulk = new BulkWrite();
    $bulk->insert($info->toArray());
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

  /**
   * @param bool $upsert
   * @param bool $multi
   * @return bool
   * @throws \Exception
   */
  protected function update(bool $upsert = false, bool $multi = false): bool {
    $this->checkIfObjectUsed();
    $bulk = new BulkWrite();
    $bulk->update($this->filter, $this->newObject, ['upsert' => $upsert, 'multi' => $multi]);
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

  private function checkIfObjectUsed() {
    if ($this->objectHasUsed) {
      throw new \Exception('This object has used');
    }
    return true;
  }

  protected function aggregate(array $pipeline): array {
    $cmd['aggregate'] = $this->collection();
    $cmd['pipeline'] = $pipeline;
    $cmd['cursor'] = new \stdClass();
    try {
      return $this->db_->getManager()->executeCommand($this->db_->getDBName(), new Command($cmd))->toArray();
    } catch (\MongoDb\Driver\Exception\Exception $e) {
      Logger::getInstance()->error($e->getMessage());
    }
    return [];
  }

  protected function where(string $field, string $op, $value): self {
    $opClass = new Op();
    $this->filter[$field] = $opClass->getOp($op, $value);
    return $this;
  }

  protected function in(string $filed, array $value): self {
    $this->filter[$filed] = ['$in' => $value];
    return $this;
  }

  protected function or(string $field, string $op, $value): self {
    $opClass = new Op();
    $this->filter['$or'][] = [$field => $opClass->getOp($op, $value)];
    return $this;
  }

  protected function limit(int $num): self {
    $this->options['limit'] = $num;
    return $this;
  }

  protected function sort(string $field, int $sort): self {
    $this->options['sort'] = [$field => $sort];
    return $this;
  }

  protected function field(string $fields): self {
    $fields = explode(',', $fields);
    foreach ($fields as $field) {
      $this->options['projection'][$field] = 1;
    }
    return $this;
  }

  protected function set(string $field, $value): self {
    $this->newObject['$set'][$field] = $value;
    return $this;
  }

  protected function inc(string $field, int $value): self {
    $this->newObject['$inc'][$field] = $value;
    return $this;
  }

  protected function unset(string $field): self {
    $this->newObject['$unset'][$field] = 1;
    return $this;
  }

  protected function push(string $field, $value): self {
    $this->newObject['$push'][$field] = $value;
    return $this;
  }

  protected function addToSet(string $field, $value): self {
    $this->newObject['$addToSet'][$field] = $value;
    return $this;
  }

  protected function pop(string $field, $value): self {
    $this->newObject['$pop'][$field] = $value;
    return $this;
  }

  protected function pull(string $field, $value): self {
    $this->newObject['$pull'][$field] = $value;
    return $this;
  }

  public $filter = [];
  public $options = [];
  public $newObject = [];

  public static function newId(): string {
    return new ObjectId() . '';
  }
}