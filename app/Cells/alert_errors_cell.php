<?php
if (session()->getFlashdata('error')) {
    echo view_cell('AlertMessage', [
        'type' => 'danger',
        'messages' => session()->getFlashdata('error')
    ]);
}

if (isset($errors)) {
    echo view_cell('AlertMessage', [
        'type' => 'danger',
        'messages' => $errors
    ]);
}
