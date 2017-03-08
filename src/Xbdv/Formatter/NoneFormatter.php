<?php

namespace Xbdv\Formatter;

use Monolog\Formatter\FormatterInterface;

/**
 * Description of NoneFormatter
 *
 * @author xhg
 */
class NoneFormatter implements FormatterInterface
{
    /**
     * Formats a log record.
     *
     * @param  array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record) 
    {
        return $record['message'];
    }

    /**
     * Formats a set of log records.
     *
     * @param  array $records A set of records to format
     * @return mixed The formatted set of records
     */
    public function formatBatch(array $records)
    {
        return $records;
    }
}
