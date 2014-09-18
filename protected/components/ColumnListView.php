<?php

Yii::import('zii.widgets.CListView');

class ColumnListView extends CListView
{

    public $columns = array("leftblock", "midblock", "rightblock");

    //@override)
    public function renderItems()
    {
        $y = 0;
        if(sizeof($this->columns))
            foreach ($this->columns as $column)
            {
                echo CHtml::openTag('div',array('class'=>'column '.$column,))."\n";
                $columns = sizeof($this->columns);

                $data=$this->dataProvider->getData();
                if(count($data)>0)
                {
                    $owner=$this->getOwner();
                    $render=$owner instanceof CController ? 'renderPartial' : 'render';
                    foreach($data as $i=>$item)
                    {
                        if( ($i+ ($columns - $y)) % $columns == 0)
                        {
                            $data=$this->viewData;
                            $data['index']=$i;
                            $data['data']=$item;
                            $data['widget']=$this;
                            $owner->$render($this->itemView,$data);
                        }
                    }
                }
                else
                    $this->renderEmptyText();
                echo CHtml::closeTag('div');
                $y++;
            }
    }

}