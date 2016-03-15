<?php
class DeleteMappingRequestOptions {

    private $MappingId;

    public function setMappingId($MappingId)
    {
        $this->MappingId = $MappingId;
    }

    public function getMappingId()
    {
        return $this->MappingId;
    }
}