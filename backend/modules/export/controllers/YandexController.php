<?php
/**
 * Created by PhpStorm.
 * User: pashaevs
 * Date: 02.10.14
 * Time: 13:18
 */

namespace backend\modules\export\controllers;

use common\helpers\CString;
use common\modules\catalog\models\Product;
use common\modules\catalog\models\ProductCategory;
use Yii;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\admin\models\AdminUsers;

class YandexController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],

            ],
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['market-yml'],
                'rules' => [
                    [
                        'allow' => true,
                        'actions' => ['market-yml'],
//                        'roles' => ['@']
                        'matchCallback' => function ($rule, $action) {
//                                if ($action != 'logout') {
                            $model = AdminUsers::findIdentity(Yii::$app->user->getId());
                            if (!empty($model)) {
                                return $model->getRoleId() == 1; // Администратор
                            }
                            return false;
//                                }
//                                return false;
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionMarketYml()
    {

        if (Yii::$app->request->post('yandex-export') == "do-yandex-export-yml") {


            $xml = "<?xml version=\"1.0\" encoding=\"windows-1251\"?>\n";
            $xml .= "<!DOCTYPE yml_catalog SYSTEM \"shops.dtd\">\n";


            $xml .= "<yml_catalog date=\"" . date("Y-m-d H:i") . "\">\n";

            //TODO: Получить данные о магазине
            $xml .= "<shop>\n";
            $xml .= "\t<name>Короткое название магазина</name>\n";
            $xml .= "\t<company>Полное наименование компании</company>\n";
            $xml .= "\t<url>http://site.ru/</url>\n";
            $xml .= "\t<platform>Kagama eCommerce</platform>\n";
            $xml .= "\t<version>2.0.1</version>\n";
            $xml .= "\t<agency>Компания Кагама - разработка, продвижение и поддержка сайтов</agency>\n";
            $xml .= "\t<email>office@kagama.ru</email>\n";
            $xml .= "\t<currencies>\n\t\t<currency id=\"RUR\" rate=\"1\"/>\n\t</currencies>\n";
            $xml .= "\t<categories>\n" . $this->prepareCategory() . "</categories>\n";

            $xml .= "\t<local_delivery_cost>300</local_delivery_cost>\n";

            $xml .= $this->offers();

            $xml .= "</shop>\n";


            $xml .= "</yml_catalog>\n";

            $handler = fopen(Yii::$app->basePath."/../files/yandex/yml_catalog.xml", "w+");
            fwrite($handler, $xml);
            fclose($handler);

        }
        return $this->render('market-yml');
    }


    private function offers()
    {
        $xml = "\t<offers>\n";
        $product = Product::find()->where('yandex_export = 1 and visible = 1')->all();
        foreach ($product as $prod) {
            $xml .= $this->offer($product);
        }
        $xml .= "\t</offers>\n";
        return $xml;
    }

    private function offer($_prod)
    {
        $xml = "";

        $xml .= "<offer id=\"".$_prod->id."\" available=\"true\">\n";
        $xml .=     "\t<url>".Url::to('/product/'.$_prod->code_number)."</url>\n";
        $xml .=     "\t<price>".$_prod->price."</price>\n";
        $xml .=     "\t<currencyId>RUR</currencyId>\n";
        $xml .=     "\t<categoryId>".$_prod->category_id."</categoryId>\n";

        if ( ($photo = $_prod->photos[0]) != null ) {
            $xml .=  "<picture>".$photo->doCache('600x600', 'auto', '600x600')."</picture>\n";
        }

        $xml .=     "\t<store>true</store>\n";
        $xml .=     "\t<pickup>true</pickup>\n";
        $xml .=     "\t<delivery>true</delivery>\n";
        $xml .=     "\t<local_delivery_cost>300</local_delivery_cost>\n";
        $xml .=     "\t<name>".CString::subStr($_prod->h1_name, 0, 255)."</name>\n";
        $xml .=     "\t<vendor>".$_prod->manufacture->name."</vendor>\n";
        $xml .=     "\t<description>".CString::subStr($_prod->description, 0, 512)."</description>\n";
        $xml .=     "\t<manufacturer_warranty>true</manufacturer_warranty>\n";
        $xml .= "</offer>\n";
        return $xml;
    }

    /**
     * @return Yandex YML Element <category>
     */
    private function prepareCategory()
    {
        $objArray = ProductCategory::find()->orderBy(['level' => 'ASC'])->all();

        $_xml = "";
        $_xml = $this->getTree($objArray, NULL);
        return $_xml;
    }

    /**
     * @param Array ProductCategory
     * @param null $parent_id
     * @return Yandex YML Element <category>
     */
    private function getTree($arr, $parent_id = NULL)
    {
        $_xml = "";
        foreach ($arr as $index => $obj) {
            if ($obj->parent_id == $parent_id) {
                $tempObj = $obj;
                unset($arr[$index]);
                $_xml .= "\t\t<category id=\"" . $tempObj->id . "\"  " . ($tempObj->parent_id == NULL ? "" : 'parent_id="' . $tempObj->parent_id . '"') . ">" . $tempObj->name . "</category>\n";
                $_xml .= $this->getTree($arr, $tempObj->id);
            }
        }
        return $_xml;
    }


}
