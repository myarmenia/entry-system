<?php

namespace App\Interfaces;

interface DepartmentInterface
{
    public function store(array $data);
    public function edit($id);
    public function update($dto, $id);

}

