<?php

class StudentSubjectMark extends CActiveRecord
{

    /**
     * Returns the static model of the specified AR class.
     * @return CActiveRecord the static model class
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
        return 'student_subject_marks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('student_id,subject_id,subject_type, mark', 'required')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'Id',
            'student_id' => 'Student',
            'subject_id' => 'Subject',
            'mark' => 'Mark',
        );
    }

    /**
     * Generates the password hash.
     * @param string password
     * @return string hash
     */
    public static function getStudentSubjectMark($id)
    {
        return self::model()->findByPk($id);
    }

    public function isAlreadyExist($id = "")
    {
        $condition = "";
        if ($id)
            $condition = "id !=" . $id;
        $subjectResult = self::model()->findByAttributes(array('course_year_id' => $this->course_year_id,'semester_id' => $this->semester_id,'subject_id' => $this->subject_id, 'student_id' => $this->student_id, 'mark' => $this->mark), $condition);
        if ($subjectResult)
            return true;
        else
            return false;
    }
    
    public function isRowAlreadyExist()
    {                    
        $subjectResult = self::model()->findByAttributes(array('subject_id' => $this->subject_id, 'student_id' => $this->student_id));       
        if ($subjectResult)
            return $subjectResult->id;
        else
            return false;
    }

    public function getGradeArray()
    {
        $grades = Grade::getAll();
        $result = array();
        foreach($grades as $key=> $model )
        {
            $result[$model->percentage_from."-".$model->percentage_to] = $model->grade;            
        }
        return $result;
    }
    public function getGrade($percentage)
    {
        $grade = $this->getGradeArray();        
        if ($percentage)
        {
            foreach ($grade as $key => $val)
            {
                list($lowerBound, $upperBound) = explode("-", $key);
                if ($percentage >= $lowerBound && $percentage <= $upperBound)
                    return $val;
            }
        }
        return "N/A";
    }

}
