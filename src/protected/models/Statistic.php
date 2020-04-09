<?php

/**
 * This is the model class for table "tbl_statistic".
 *
 * The followings are the available columns in table 'tbl_statistic':
 * @property integer $id
 * @property string $remote_host
 * @property string $remote_user
 * @property string $time_from
 * @property string $time_to
 * @property string $time
 * @property string $method
 * @property string $request
 * @property string $protocol
 * @property integer $status
 * @property integer $bytes
 * @property string $referer
 * @property string $user_agent
 */
class Statistic extends CActiveRecord implements AjaxResponseInterface
{
    public $time_from;
    public $time_to;
    public $group_by;

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Statistic the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'tbl_statistic';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            //array('remote_host, time, method, request, protocol, status, bytes, user_agent', 'required'),
            //array('status, bytes', 'numerical', 'integerOnly'=>true),
            //array('remote_host', 'length', 'max'=>11),
            //array('remote_user, method, protocol, referer, user_agent', 'length', 'max'=>255),
            // The following rule is used by search().
            array('remote_host, time_from, time_to, method, status, group_by', 'safe', 'on' => 'search'),
            //array('time_from, time_to, method, status', 'default', 'setOnEmpty' => true, 'value' => null),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array();
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'remote_host' => 'Remote Host',
            'remote_user' => 'Remote User',
            'time' => 'Request time',
            'method' => 'Method',
            'request' => 'Request',
            'protocol' => 'Protocol',
            'status' => 'Status',
            'bytes' => 'Bytes',
            'referer' => 'Referer',
            'user_agent' => 'User Agent',
            'group_by' => 'Group by',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        if (is_array($this->group_by) && !empty($this->group_by)) {
            $criteria->select = ['SUM(bytes) as bytes'];
            $criteria->select[] = "concat_ws(' : ', date_format(MIN(time), '%Y-%m-%d'), date_format(MAX(time), '%Y-%m-%d')) as time";
            foreach ($this->group_by as $field) {
                $criteria->select[] = $field;
                $criteria->group .= ($criteria->group ? ',' : '') . $field;
            }
        }

        if ($this->time_from && $this->time_to) {
            $criteria->addBetweenCondition(
                'time',
                date('Y-m-d 00:00:00', strtotime($this->time_from)),
                date('Y-m-d 23:59:59', strtotime($this->time_to))
            );
        } elseif ($this->time_from) {
            $criteria->addCondition('t.time > :time_from');
            $criteria->params[':time_from'] = date('Y-m-d', strtotime($this->time_from)) . ' 00:00:00';
        } elseif ($this->time_to) {
            $criteria->addCondition('t.time < :time_to');
            $criteria->params[':time_to'] = date('Y-m-d', strtotime($this->time_to)) . ' 23:59:59';
        }

        $criteria->compare('remote_host', ip2long($this->remote_host));
        $criteria->compare('method', strtoupper($this->method));
        $criteria->compare('status', $this->status);

        return new ActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageVar' => 'page',
            ),
            'sort' => array(
                'sortVar' => 'sort',
                'attributes' => array(
                    'remote_host',
                    'time' => array(
                        'asc' => 'time ASC',
                        'desc' => 'time DESC',
                    ),
                    'bytes' => array(
                        'asc' => 'bytes ASC',
                        'desc' => 'bytes DESC',
                    )
                )
            )
        ));
    }

    public function getResponseData()
    {
        return $this->getAttributes();
    }
}
