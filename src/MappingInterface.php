<?php
namespace Gwsn\LumenTransformer\Models;


interface MappingInterface
{

    public function setMapping(array $mapping = []);

    public function getMapping(): array;
}