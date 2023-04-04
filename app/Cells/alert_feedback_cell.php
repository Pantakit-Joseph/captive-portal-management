<?php

if (session()->getFlashdata('error')) {
    echo view_cell('AlertMessage', [
        'type'    => 'danger',
        'message' => session()->getFlashdata('error'),
    ]);
}

if (isset($error)) {
    echo view_cell('AlertMessage', [
        'type'    => 'danger',
        'message' => $error,
    ]);
}

if (session()->getFlashdata('success')) {
    echo view_cell('AlertMessage', [
        'type'    => 'success',
        'message' => session()->getFlashdata('success'),
    ]);
}

if (isset($success)) {
    echo view_cell('AlertMessage', [
        'type'    => 'success',
        'message' => $success,
    ]);
}

if (session()->getFlashdata('warning')) {
    echo view_cell('AlertMessage', [
        'type'    => 'warning',
        'message' => session()->getFlashdata('warning'),
    ]);
}
if (isset($warning)) {
    echo view_cell('AlertMessage', [
        'type'    => 'warning',
        'message' => $warning ?? null,
    ]);
}

if (session()->getFlashdata('info')) {
    echo view_cell('AlertMessage', [
        'type'    => 'info',
        'message' => session()->getFlashdata('info'),
    ]);
}
if (isset($info)) {
    echo view_cell('AlertMessage', [
        'type'    => 'info',
        'message' => $info ?? null,
    ]);
}
