<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertMessage extends Cell
{
    public $type;
    public $message;
    protected string $view = 'alert_message_cell';
}
