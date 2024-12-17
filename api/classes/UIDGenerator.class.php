<?php

class UIDGenerator
{
    private $now;
    private $default_permitted_chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public function __construct()
    {
        $this->now = time();
    }

    public function getUID(int $length, string $filter = null): string
    {
        $permitted_chars = $this->getPermittedChars($filter);

        // If the requested length is greater than 10, we adjust to include parts of the current timestamp
        if ($length > 10) {
            return $this->generateUIDWithTimestamp($length, $permitted_chars);
        }

        return substr(str_shuffle($permitted_chars), 0, $length);
    }

    public function splitUID(string $uid, int $groupNum): string
    {
        return implode("-", str_split($uid, $groupNum));
    }

    // Helper method to determine permitted characters based on filter
    private function getPermittedChars(?string $filter): string
    {
        switch ($filter) {
            case 'numbers':
                return '0123456789';
            case 'alphabets':
                return 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            default:
                return $this->default_permitted_chars;
        }
    }

    // Helper method to generate a UID that includes parts of the current timestamp
    private function generateUIDWithTimestamp(int $length, string $permitted_chars): string
    {
        $timestampLength = strlen($this->now);
        $remainingLength = $length - $timestampLength;

        $firstTwoChars = substr($this->now, 0, 2);
        $leftChars = substr($this->now, 2);

        $createdCode = substr(str_shuffle($permitted_chars), 0, $remainingLength);
        $divided = (int) ($remainingLength / 2);

        $firstPart = substr($createdCode, 0, $divided);
        $secondPart = substr($createdCode, $divided);

        return $firstTwoChars . $firstPart . $leftChars . $secondPart;
    }
}
?>
