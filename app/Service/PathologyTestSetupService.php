<?php

namespace App\Service;

use Exception;
use Illuminate\Support\Facades\DB;

class PathologyTestSetupService
{

  function Store($data)
  {
    DB::beginTransaction();
    try {
      dd($data);
    } catch (Exception $e) {
      DB::rollBack();
      dd($e->getMessage());
    }
  }
}
