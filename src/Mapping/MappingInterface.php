<?php
namespace Gwsn\Transformer\Mapping;


interface MappingInterface
{

    public function setMapping(array $mapping = []);

    public function getMapping(): array;
}