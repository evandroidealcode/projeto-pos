<?php

namespace App\Data;

interface ITask
{
  public function get(int $id): array;

  public function get_all_tasks(): array;

  public function create_task(string $titulo): int;

  public function change_task(int $id, string $titulo): bool;

  public function delete_task(int $id): bool;
}