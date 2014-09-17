<?php
/**
 * Created by JetBrains PhpStorm.
 * User: vit
 * Date: 18.01.14
 * Time: 23:07
 * To change this template use File | Settings | File Templates.
 */
class AuxiliaryFunctions
{
    /**
     * Возвращает строку или массив из тегов
     * @param $tags
     * @param bool $arr
     * @return array|string
     */
    public static function getTagsList($tags, $arr = true){
        if ($arr) {
            $tagsArray = array();
            foreach ($tags as $key => $tag) {
                if (!empty($tag['idTag0']['textTag'])) {
                    $tagsArray[$key]['idTag']   = $tag['idTag0']['idTag'];
                    $tagsArray[$key]['textTag'] = $tag['idTag0']['textTag'];
                }
            }
            $resultArray = Tags::getMenu($tagsArray);
            return $resultArray;
        }
        else {
            $tmpArray = array();
            foreach ($tags as $tag) {
                if (!empty($tag['idTag0']['textTag'])) {
                    $tmpArray[] = $tag['idTag0']['textTag'];
                }
            }
            $tagsString = implode(",", $tmpArray);
            return $tagsString;
        }

    }

    /**
     * Сохраняет файл на диск
     * @param $model
     * @param $fileName
     * @param $oldFile
     */
    public static function savePhoto($model, $fileName, $oldFile = null){
        $classModel = get_class($model);
        $id         = $model->primaryKey;

        if ($fileName) {
            $dirName = 'uploads/'.strtolower($classModel);
            if (!is_dir($dirName)) {
                mkdir($dirName, 0755);
            }

            $folderForSave = $dirName.'/'.(int)$id;
            if (!is_dir($folderForSave)) {
                mkdir($folderForSave, 0755);
            }

            // Сохраняем файл
            $model->image = CUploadedFile::getInstance($model, 'image');
            $model->image->saveAs($folderForSave.'/'.$fileName);

            if (!empty($oldFile) && file_exists($folderForSave.'/'.$oldFile)) {
                unlink($folderForSave.'/'.$oldFile);
            }
        }
    }

    /**
     * Заполняет ХЛЕБНЫЕ КРОШКИ
     * @param $id
     * @param $type (mainMenu, category, article)
     * @return array
     */
    public static function fillingBreadcrumbs($id, $type){
        $breadcrumbs = array();

        switch ($type) {

            case 'mainMenu' :
                $modelMenu      = Mainmenu::model()->findByPk($id);
                $breadcrumbs    = array($modelMenu->title => array('articles/list_articles', 'listType' => 'razdel', 'idMenu' => $modelMenu->idMenu));
                break;

            case 'category' :
                $modelCategory  = Categorys::model()->findByPk($id);
                $modelMenu      = Mainmenu::model()->findByPk($modelCategory->idMenu);
                $breadcrumbs    = array($modelMenu->title => array('articles/list_articles', 'listType' => 'razdel', 'idMenu' => $modelMenu->idMenu));
                $breadcrumbs    = $breadcrumbs + array($modelCategory->title => array('articles/list_articles', 'listType' => 'category', 'idMenu' => $modelMenu->idMenu, 'idCategory' => $modelCategory->idCategory));
                break;

            case 'article' :
                $modelArticle   = Articles::model()->findByPk($id);
                $modelMenu      = Mainmenu::model()->findByPk($modelArticle->idMenu);
                $breadcrumbs    = array($modelMenu->title => array('articles/list_articles', 'listType' => 'razdel', 'idMenu' => $modelMenu->idMenu));

                if (!empty($modelArticle->idCategory)) {
                    $modelCategory  = Categorys::model()->findByPk($modelArticle->idCategory);
                    $breadcrumbs    = $breadcrumbs + array($modelCategory->title => array('articles/list_articles', 'listType' => 'category', 'idMenu' => $modelMenu->idMenu, 'idCategory' => $modelCategory->idCategory));
                }

                $breadcrumbs = $breadcrumbs + array($modelArticle->title);
                break;
        }

        return $breadcrumbs;
    }

    /**
     * Генерирует уникальное имя файла.
     * @param string $fileName
     * @return string
     */
    public static function getUniquNamePhoto($fileName){
        $fileName = uniqid().'.'.end(explode(".", $fileName));
        return $fileName;
    }
}
