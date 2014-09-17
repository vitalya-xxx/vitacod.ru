<?php
class FeedbackForm extends CFormModel
{
    public $name;
    public $email;
    public $message;

    public function rules()
    {
        return array(
            array('name, email, message', 'required'),
            array('email', 'email'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'name'=>'Ваше имя',
            'email'=>'Email',
            'message'=>'Опишите задачу',
        );
    }
}