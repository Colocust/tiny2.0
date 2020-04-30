<?php


namespace Tiny\MySQL;


abstract class Model {

  abstract protected function table(): string;

  /**
   * @var $db_ MySQL
   */
  protected $db_;

  public function __construct() {
    $this->db_ = new MySQL($this->table());
  }

  final protected function find(string $sql): array {
    $results = $this->db_->getConnect()->query($sql);
    if (!$results) {
      throw new \Exception("$sql is a wrong sql");
    }
    $data = [];
    while ($result = $results->fetch_object()) {
      $data[] = $result;
    }
    return $data;
  }

  final protected function create() {

  }

  final protected function update() {

  }

  final protected function delete() {

  }
}
