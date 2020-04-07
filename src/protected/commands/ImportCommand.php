<?php

/**
 * Command for import data from nginx `access.log` into DB.
 */
class ImportCommand extends CConsoleCommand
{
    /**
     * Path to dir with 'access.log`.
     *
     * @var string
     */
    public $path = '';

    public function actionIndex($path = null)
    {
        $file = ($path ?? $this->path) . '/access.log';
        $logs = fopen($file, 'r') or exit($php_errormsg);

        $command = Yii::app()->db->createCommand();
        $last = $command->select('time')
            ->from('tbl_statistic')
            ->order('id desc')
            ->limit(1)
            ->queryRow();
        $last_time = strtotime($last['time']);

        $parser = new LogParser();
        while (!feof($logs)) {
            $line = trim(fgets($logs));
            if (!empty($statistic = $parser->parse($line))) {
                if (strtotime($statistic['time']) > $last_time) {
                    $command->reset();
                    $command->insert('tbl_statistic', $statistic);
                }
            }
        }
    }
}
