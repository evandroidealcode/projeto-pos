<?php

namespace App\Controllers;

use App\Repository\TasksRepository;
use App\Helper\Http;
use Exception;

class TasksController {

  private $TasksRepository;

  public function __construct()
  {
    $this->TasksRepository = new TasksRepository();
  }
  
  public function get($id): string {
    try {
      $data = $this->TasksRepository->get($id);

      return Http::response($data, 200);
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }

  public function get_all(): string {
    try {
      $data = $this->TasksRepository->get_all_tasks();

      return Http::response($data, 200);
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }

  public function create(): string {
    try {
      $request = Http::request();

      if ($request["titulo"]) {
        $data["id"] = $this->TasksRepository->create_task($request['titulo']);
        $data["message"] = "Task adicionada com sucesso!";

        return Http::response([$data], 200);
      } else {
        return Http::response(["erro" => "O título da task deve ser preenchido."], 400);
      }
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }

  public function change(): string {
    try {
      $request = Http::request();

      if ($request["id"] && $request["titulo"]) {
        $this->TasksRepository->change_task(
          $request["id"], 
          $request['titulo']
        );

        $data["message"] = "Task alterada com sucesso!";

        return Http::response([$data], 200);
      } else {
        $response = "";
        $response = ($response == "" && empty($request["id"])) ? "O id da task deve ser preenchido." : $response;
        $response = ($response == "" && empty($request["titulo"])) ? "O título da task deve ser preenchido.": $response;

        return Http::response(["erro" => $response], 400);
      }
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }

  public function task_status(): string {
    try {
      $request = Http::request();

      if ($request["id"]) {
        $data_check = $this->TasksRepository->get($request["id"]);

        if(count($data_check) == 0) {
          $data["message"] = "Task não encontrada.";
        } else {
          $this->TasksRepository->change_task_status(
            $request["id"], 
            $data_check[0]->concluido ? 0 : 1
          );

          $data["message"] = "Status da task alterada com sucesso!";
        }

        return Http::response([$data], 200);
      } else {
        return Http::response(["erro" => "O ID da task deve ser informado."], 400);
      }
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }

  public function delete($id): string {
    try {
      if ($id) {
        $data_check = $this->TasksRepository->get($id);

        if(count($data_check) == 0) {
          $data["message"] = "Essa task já foi removida!";
        } else {
          $this->TasksRepository->delete_task($id);
          $data["message"] = "Task removida com sucesso!";
        }

        return Http::response([$data], 200);
      } else {
        return Http::response(["erro" => "ID da task deve ser informado."], 400);
      }
    } catch (Exception $e) {
      return Http::response([$e->getMessage()], 500);
    }
  }
}