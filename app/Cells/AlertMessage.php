<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertMessage extends Cell
{
    public $type;
    public $messages;

    protected string $view = 'alert_message_cell';
}
