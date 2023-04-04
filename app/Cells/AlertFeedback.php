<?php

namespace App\Cells;

use CodeIgniter\View\Cells\Cell;

class AlertFeedback extends Cell
{
    public $error;
    public $success;
    public $warning;
    public $info;
    protected string $view = 'alert_feedback_cell';
}
