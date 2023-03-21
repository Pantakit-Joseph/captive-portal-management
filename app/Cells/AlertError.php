<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertError extends Cell
{
    public $error;

    protected string $view = 'alert_error_cell';
}
