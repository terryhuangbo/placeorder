<?php

namespace common\base;

use yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\ArrayHelper;

/**
 * 对ActiveRecord功能的扩展
 * 有些是改造过的，比如[[getAll]]、[[getOne]]，有些方法是新增的，比如insertReplace
 * 这个类继承自\yii\db\ActiveRecord，在实际项目中的model可以继承此类实现功能的扩展。
 * @see yii\db\ActiveRecord
 * @author Bo Huang <Terry1987101@163.com>
 * @since 2016-09-22
 */

class BaseModel extends ActiveRecord
{
    /**
     * 数据库连接
     */
    protected static $db_link = 'db';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%' . yii\helpers\Inflector::camel2id(
            yii\helpers\StringHelper::basename(get_called_class()),
            '_'
        ) . '}}';
    }

    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get(static::$db_link);
    }

    /**
     * 以数组形式获取AR列表
     * @param array $where
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param array $format
     * @return array|boolean
     */
    public function getAll($where = [], $order = '', $page = 1, $limit = 20, $format = [])
    {
        $query = static::find();
        
        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else if (is_array($where))
        {
            $query->where($where);
        }

        if(empty($order)){
            $query->orderBy($order);
        }

        if (!empty($limit))
        {
            $offset = max(($page - 1), 0) * $limit;
            $query->offset($offset)->limit($limit);
        }

        if (!empty($format) && is_array($format))
        {
            return ArrayHelper::toArray($query->all(), [static::className() => $format]);
        }

        return $query->asArray()->all();
    }

    /**
     * 以数组形式获取单个AR
     * @param $where array
     * @return array|boolean
     */
    public function getOne($where = [])
    {
        $query = static::find();

        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else if (is_array($where))
        {
            $query->where($where);
        }

        return $query->asArray()->one();
    }

    /**
     * 获取AR记录总数
     * @param $where array
     * @return int
     */
    public function getCount($where = [])
    {
        $query = static::find();

        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else
        {
            $query->where($where);
        }

        return intval($query->count());
    }

    /**
     * 以数组形式获取AR连同关联AR列表
     * 获取的关联AR的方式是贪懒加载方式
     * @param mixed $select
     * @param array $with 关联关系，分为with和joinWith两部分
     * @param array $where
     * @param string $order
     * @param int $page
     * @param int $limit
     * @param $format array 输出格式
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelationAll(
        $select = '*',
        $where = [],
        $with = [],
        $order = '',
        $page = 1,
        $limit = 20,
        $format = []
    ) {
        $query = static::find();

        if (!empty($select))
        {
            $query->select($select);
        }

        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else if (is_array($where))
        {
            $query->where($where);
        }

        if (!empty($with['with']))
        {
            $query->with($with['with']);
        }

        if (!empty($with['joinWith']))
        {
            $query->joinWith($with['joinWith']);
        }

        if (!empty($order))
        {
            $query->orderBy($order);
        }

        if (!empty($limit))
        {
            $offset = max(($page - 1), 0) * $limit;
            $query->offset($offset)->limit($limit);
        }

        if (!empty($format) && is_array($format))
        {
            return ArrayHelper::toArray($query->all(), [static::className() => $format]);
        }

        return $query->asArray()->all();
    }

    /**
     * 以数组形式获取单个AR连同关联AR
     * 获取的关联AR的方式是贪懒加载方式
     * @param array $where
     * @param array $with 关联关系，分为with和joinWith两部分
     * @param $format array 输出格式
     * @return array|\yii\db\ActiveRecord[]
     */
    public function getRelationOne($where = [], $with = [], $format) {

        $query = static::find();

        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else if (is_array($where))
        {
            $query->where($where);
        }

        if (!empty($with['with']))
        {
            $query->with($with['with']);
        }

        if (!empty($with['joinWith']))
        {
            $query->joinWith($with['joinWith']);
        }


        if (!empty($format) && is_array($format))
        {
            return ArrayHelper::toArray($query->all(), [static::className() => $format]);
        }

        return $query->asArray()->one();
    }

    /**
     * 获取AR及关联AR记录总数
     * @param $where array
     * @param array $joinWith 关联关系
     * @return int
     */
    public function getRelationCount($where = [], $joinWith = [])
    {
        $query = static::find();

        if (isset($where['sql'], $where['params']))
        {
            $query->where($where['sql'], $where['params']);
        }
        else
        {
            $query->where($where);
        }

        if (!empty($joinWith))
        {
            $query->joinWith($joinWith);
        }

        return intval($query->count());
    }

    /**
     * 插入不重复数据，如果存在则跳过
     * 判断两条记录是否相同是根据主键primary或者唯一索引unique的值是否相同，因此必须使用主键primary或者唯一索引unique保证记录的唯一性
     * 如果有重复记录，那插入不会执行，影响行数为0；否则和正常的insert语句一样执行，影响行数为1
     * @param array $columns 要插入的列，必须为Hash数组形式
     * @return int 影响的行数 0或1
     * @throws \yii\db\Exception
     */
    public function insertIgnore($columns)
    {
        $schema = static::getDb()->getSchema();
        $table = static::tableName();
        $params = [];
        if (($tableSchema = $schema->getTableSchema($table)) !== null) {
            $columnSchemas = $tableSchema->columns;
        } else {
            $columnSchemas = [];
        }
        $names = [];
        $placeholders = [];
        foreach ($columns as $name => $value) {
            $names[] = $schema->quoteColumnName($name);
            if ($value instanceof Expression) {
                $placeholders[] = $value->expression;
                foreach ($value->params as $n => $v) {
                    $params[$n] = $v;
                }
            } else {
                $phName = ':qp' . count($params);
                $placeholders[] = $phName;
                $params[$phName] = !is_array($value) && isset($columnSchemas[$name]) ? $columnSchemas[$name]->dbTypecast($value) : $value;
            }
        }

        $sql =  'INSERT IGNORE INTO ' . $schema->quoteTableName($table)
        . ' (' . implode(', ', $names) . ') VALUES ('
        . implode(', ', $placeholders) . ')';

        return static::getDb()->createCommand($sql, $params)->execute();
    }

    /**
     * 插入不重复数据，如果存在则替换
     * 判断两条记录是否相同是根据主键primary或者唯一索引unique的值是否相同，因此必须使用主键primary或者唯一索引unique保证记录的唯一性
     * 如果有重复记录，那在插入新纪录之前，旧记录被删除，影响行数为2；否则和正常的insert一样执行，影响行数为2
     * @param array $columns 要插入的列，必须为Hash数组形式
     * @return int 影响的行数 0或2
     * @throws \yii\db\Exception
     */
    public function insertReplace($columns)
    {
        $schema = static::getDb()->getSchema();
        $table = static::tableName();
        $params = [];
        if (($tableSchema = $schema->getTableSchema($table)) !== null) {
            $columnSchemas = $tableSchema->columns;
        } else {
            $columnSchemas = [];
        }
        $names = [];
        $placeholders = [];
        foreach ($columns as $name => $value) {
            $names[] = $schema->quoteColumnName($name);
            if ($value instanceof Expression) {
                $placeholders[] = $value->expression;
                foreach ($value->params as $n => $v) {
                    $params[$n] = $v;
                }
            } else {
                $phName = ':qp' . count($params);
                $placeholders[] = $phName;
                $params[$phName] = !is_array($value) && isset($columnSchemas[$name]) ? $columnSchemas[$name]->dbTypecast($value) : $value;
            }
        }

        $sql =  'REPLACE INTO  ' . $schema->quoteTableName($table)
            . ' (' . implode(', ', $names) . ') VALUES ('
            . implode(', ', $placeholders) . ')';

        return static::getDb()->createCommand($sql, $params)->execute();
    }

}