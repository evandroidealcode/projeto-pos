<?php

namespace App\Repository;

use App\Data\ITask;
use App\Model\Tasks;
use PDO;

class TasksRepository  implements ITask {

  private $model;

  public function __construct() {
    $this->model = new Tasks();
  }

  public function get(int $id): array {
    return $this->model
      ->select("id = " . $id)->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public function get_all_tasks(): array {
    return $this->model
      ->select()->fetchAll(PDO::FETCH_CLASS,self::class);
  }

  public function create_task(string $titulo): int {
    $id = $this->model->insert([
      'titulo'          => $titulo,
      'concluido'       => 0,
      'dataCriacao'     => date("Y-m-d"),
      'dataAtualizacao' => date("Y-m-d")
    ]);

    return $id;
  }

  public function change_task(int $id, string $titulo): bool {
    return $this->model->update('id = ' . $id, [
      'titulo'          => $titulo,
      'dataAtualizacao' => date("Y-m-d")
    ]);
  }

  public function delete_task(int $id): bool {
    return $this->model->delete('id = ' . $id);
  }

  public function change_task_status(int $id, $concluido): bool {
    return $this->model->update('id = ' . $id, [
      'concluido'       => $concluido,
      'dataAtualizacao' => date("Y-m-d")
    ]);
  }
}