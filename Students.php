<?php
namespace Models;

class Students extends ObjectModel
{

    public $id;

    public $name;

    public $birthday;

    /**
     * @var boolean
     * 0 - отчислен, 1 - учится
     */
    public $studying;

    public $average_scope;

    public static $definition = [
        'table'             => 'students',
        'primary'           => 'id',
        'multilang'         => true,
        'fields' => [
            'name'          => ['type' => self::TYPE_STRING, 'lang' => true, 'validate' => 'isString', 'required' => true, 'size' => 50],
            'birthday'      => ['type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true],
            'studying'      => ['type' => self::TYPE_BOOL, 'validate' => 'isBool', 'required' => true],
            'average_scope' => ['type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'required' => true],
        ]
    ];

    public function __construct($id = null, $id_lang = null)
    {
        parent::__construct($id, $id_lang);
    }

    public function getAll()
    {
        $sql = new DbQuery();
        $sql->select('s.`name`, s.`birthday`, s.`studying`, s.`average_scope`');
        $sql->from('students', 's');
        $sql->orderBy('s.`name` ASC');
        $students = Db::getInstance()->executeS($sql);

        return $students;
    }

    public function getStudentByTopAverageScope()
    {
        $sql = new DbQuery();
        $sql->select('s.`name`, s.`birthday`, s.`studying`, s.`average_scope`');
        $sql->from('students', 's');
        $sql->orderBy('s.`average_scopes` DESC');
        $sql->limit(1);
        $students = Db::getInstance()->executeS($sql);

        return $students[0];
    }

    public function getTopAverageScope()
    {
        $student = $this->getStudentByTopAverageScope();

        return $student['average_scope'];
    }
}