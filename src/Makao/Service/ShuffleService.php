<?php
namespace Makao\Service;

/**
 * @codeCoverageIgnore
 */
class ShuffleService
{
    public function shuffle(array $data) : array
    {
        shuffle($data);

        return $data;
    }

}