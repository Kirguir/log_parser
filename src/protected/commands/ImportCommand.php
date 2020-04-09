<?php

/**
 * Command for import data from nginx `access.log` into DB.
 */
class ImportCommand extends CConsoleCommand
{
    /**
     * Path to dir with log files.
     *
     * @var string
     */
    public $path = '';

    /**
     * Pattern for logs filename.
     *
     * @var string
     */
    public $pattern = '/^access\.log$/i';

    public function actionIndex($path = null, $pattern = null)
    {
        $path = $path ?? $this->path;
        $pattern = $pattern ?? $this->pattern;
        $logs = [];
        $dh = opendir($path) or exit($php_errormsg);
        if ($dh) {
            while (($filename = readdir($dh)) !== false) {
                if (preg_match($pattern, $filename)) {
                    $logs[] = $filename;
                }
            }
            closedir($dh);
        }
        if (empty($logs)) {
            return 0;
        }

        $command = Yii::app()->db->createCommand();
        $last = $command->select('time')
            ->from('tbl_statistic')
            ->order('id desc')
            ->limit(1)
            ->queryRow();
        $last_time = strtotime($last['time']);

        $parser = new LogParser();
        foreach ($logs as $log) {
            $fh = fopen($path . $log, 'r') or exit($php_errormsg);
            while (!feof($fh)) {
                $line = trim(fgets($fh));
                if (!empty($statistic = $parser->parse($line))) {
                    if (strtotime($statistic['time']) > $last_time) {
                        $command->reset();
                        $command->insert('tbl_statistic', $statistic);
                    }
                }
            }
            fclose($fh);
        }

        return 0;
    }
}
