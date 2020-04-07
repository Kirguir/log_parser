<?php

/**
 * Parser for nginx `access.log`.
 */
class LogParser
{
    protected $pattern = '/^(?P<remote_host>\d{1,3}.\d{1,3}.\d{1,3}.\d{1,3}) '
    . '([^ ]+) (?P<remote_user>[^ ]+) '
    . '\[(?P<time>[^\]]+)\] '
    . '"(?P<method>GET|POST) (?P<request>.*) (?P<protocol>.*)" '
    . '(?P<status>[0-9\-]+) (?P<bytes>[0-9\-]+) '
    . '"(?P<referer>.*)" "(?P<user_agent>.*)"$/';

    /**
     * @param $log
     * @return array
     */
    public function parse(string $log): array
    {
        if (strlen($log) === 0) {
            return [];
        }

        if (preg_match($this->pattern, $log, $matches)) {
            return [
                'remote_host' => ip2long($matches['remote_host']),
                'remote_user' => trim($matches['remote_user'], " \t\n\r\0\x0B-"),
                'time' => DateTime::createFromFormat('d/M/Y:H:i:s O', $matches['time'])
                    ->format('Y-m-d H:i:s'),
                'method' => $matches['method'],
                'request' => $matches['request'],
                'protocol' => $matches['protocol'],
                'status' => $matches['status'],
                'bytes' => $matches['bytes'],
                'referer' => trim($matches['referer'], " \t\n\r\0\x0B-"),
                'user_agent' => $matches['user_agent'],
            ];
        }

        return [];
    }
}
