<?php
if (session()->getFlashdata('error')) {
    echo view_cell('AlertMessage', [
        'type' => 'danger',
        'message' => session()->getFlashdata('error')
    ]);
}

if (isset($error)) {
    echo view_cell('AlertMessage', [
        'type' => 'danger',
        'message' => $error
    ]);
}
