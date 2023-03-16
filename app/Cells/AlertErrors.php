<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertErrors extends Cell
{
    public $errors;

    protected string $view = 'alert_errors_cell';
}
