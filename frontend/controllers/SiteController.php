<?php
namespace frontend\controllers;

use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
//            'error' => [
//                'class' => 'yii\web\ErrorAction',
//            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionError() {
        $url =  Yii::$app->request->getUrl();

        $this->categoryRedirect($url);

        $this->productsRedirect($url);


        return $this->render('error', ['name' => '404 Страница не нейдена.']);
    }

    public function categoryRedirect($url) {

        if ($url == "/catalog/podarki_suveniry/podarki_na_svadbu.html") {
            $this->redirect('/podarki-suveniry/podarki-na-svadbu.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarki_na_svadbu.html") {
            $this->redirect('/podarki-suveniry/podarki-na-svadbu.html', 301);
        }
    }

    public function productsRedirect ($url) {

        if ($url == "/catalog/kubachinskoe_serebro/podkovy/serebrjanaja_podkova_143.html" ||
            $url == "/catalog/podarki_suveniry/jubilejj_godovshhinu/podkova_iz_serebra_316.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_svadbu/podkova_iz_serebra_380.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_novyjj_god/serebrjanaja_podkova_659.html" ) {

            $this->redirect('/143/serebrjanaja_podkova.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/podkovy/serebrjanaja_podkova_602.html") {
            $this->redirect('/602/serebrjanaja_podkova.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/podkovy/serebrjanaja_podkova_462.html") {
            $this->redirect('/462/serebrjanaja_podkova.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/podkovy/podkova_iz_serebra_463.html") {
            $this->redirect('/463/podkova_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/podkovy/serebrjanaja_podkova_410.html") {
            $this->redirect('/410/serebrjanaja_podkova.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/serebrjanyjj_portsigar_160.html") {
            $this->redirect('/160/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/portsigar_iz_serebra_599.html") {
            $this->redirect('/599/portsigar_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/serebrjanyjj_portsigar_damskijj_315.html") {
            $this->redirect('/315/serebrjanyjj_portsigar_damskijj.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/serebrjanyjj_portsigar_338.html" ||
            $url == "/catalog/ehkskljuzivnaja_serebrjanaja_rabota/portsigar_iz_serebra_183.html" ) {

            $this->redirect('/338/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/serebrjanyjj_portsigar_637.html") {
            $this->redirect('/637/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/serebrjanyjj_portsigar_654.html") {
            $this->redirect('/654/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/portsigar_iz_serebra_367.html") {
            $this->redirect('/367/portsigar_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/portsigary/portsigar_iz_serebra_464.html") {
            $this->redirect('/464/portsigar_iz_serebra.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarki_man/portsigar_i_futljar_dlja_zazhigalki_iz_serebra_434.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/serebrjanyjj_portsigar_i_futljar_dlja_zazhigalki_465.html" ||
            $url == "/catalog/podarki_suveniry/jubilejj_godovshhinu/portsigar_i_futljar_dlja_zazhigalki_469.html" ) {

            $this->redirect('/434/portsigar_i_futljar_dlja_zazhigalki_iz_serebra.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarochnye_nabory/portsigar_i_futljar_dlja_zazhigalki_466.html") {
            $this->redirect('/466/portsigar_i_futljar_dlja_zazhigalki.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarki_man/serebrjanyjj_portsigar_361.html") {
            $this->redirect('/361/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarki_na_novyjj_god/serebrjanyjj_portsigar_660.html") {
            $this->redirect('/660/serebrjanyjj_portsigar.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/fljazhki/serebrjanaja_fljazhka_161.html" ||
            $url == "/catalog/podarki_suveniry/jubilejj_godovshhinu/serebrjanaja_fljazhka_308.html" ||
            $url == "/catalog/podarki_suveniry/podarki_man/fljazhka_iz_serebra_364.html") {

            $this->redirect('/161/serebrjanaja_fljazhka.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/fljazhki/fljazhka_damskaja_iz_serebra_370.html") {
            $this->redirect('/370/fljazhka_damskaja_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/fljazhki/serebrjanaja_fljazhka_547.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_novyjj_god/serebrjanaja_fljazhka_671.html" ) {

            $this->redirect('/547/serebrjanaja_fljazhka.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/fljazhki/fljazhka_iz_serebra_gerb_rf_565.html") {
            $this->redirect('/565/fljazhka_iz_serebra_gerb_rf.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/serebrjanaja_fotoramka_640.html") {
            $this->redirect('/640/serebrjanaja_fotoramka.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/shkatulka_iz_serebra_702.html") {
            $this->redirect('/702/shkatulka_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/serebrjanaja_shkatulka_241.html" ||
            $url == "/catalog/podarki_suveniry/jubilejj_godovshhinu/serebrjanaja_shkatulka_510.html" ||
            $url == "/catalog/ehkskljuzivnaja_serebrjanaja_rabota/serebrjanaja_shkatulka_275.html" ) {

            $this->redirect('/241/serebrjanaja_shkatulka.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/serebrjanaja_ramka_dlja_foto_639.html" ||
            $url == "/catalog/podarki_suveniry/podarki_woman/serebrjanaja_ramka_dlja_foto_628.html" ||
            $url == "/catalog/podarki_suveniry/podarki_children/serebrjanaja_ramka_dlja_foto_630.html" ) {

            $this->redirect('/639/serebrjanaja_ramka_dlja_foto.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/serebrjanaja_ramka_dlja_foto_638.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_svadbu/ramka_dlja_foto_iz_serebra_631.html" ||
            $url == "/catalog/podarki_suveniry/podarki_children/ramka_dlja_foto_iz_serebra_629.html" ) {

            $this->redirect('/638/serebrjanaja_ramka_dlja_foto.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/serebrjanaja_shkatulka_237.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_svadbu/serebrjanaja_shkatulka_447.html" ||
            $url == "/catalog/podarki_suveniry/podarki_woman/serebrjanaja_shkatulka_351.html" ) {

            $this->redirect('/237/serebrjanaja_shkatulka.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/shkatulki_fotoramki/shkatulka_iz_serebra_238.html") {
            $this->redirect('/238/shkatulka_iz_serebra.html', 301);
        }

        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_bismark_229.html") {
            $this->redirect('/229/serebrjanyjj_braslet_bismark.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_470.html") {
            $this->redirect('/470/serebrjanyjj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/kubachinskijj_braslet_267.html") {
            $this->redirect('/267/kubachinskijj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_272.html") {
            $this->redirect('/272/serebrjanyjj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_471.html") {
            $this->redirect('/471/serebrjanyjj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanaja_cepochka_bismark_520.html") {
            $this->redirect('/520/serebrjanaja_cepochka_bismark.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/kubachinskijj_braslet_268.html") {
            $this->redirect('/268/kubachinskijj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_273.html") {
            $this->redirect('/273/serebrjanyjj_braslet.html', 301);
        }
        if ($url == "/catalog/kubachinskoe_serebro/cepochki_braslety/serebrjanyjj_braslet_274.html") {
            $this->redirect('/274/serebrjanyjj_braslet.html', 301);
        }

        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_148.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_novyjj_god/serebrjanyjj_bokal_670.html") {

            $this->redirect('/148/serebrjanyjj_bokal.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_gerb_rossii_649.html") {
            $this->redirect('/649/serebrjanyjj_bokal_gerb_rossii.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_156.html") {
            $this->redirect('/156/serebrjanyjj_bokal.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_nabor_iz_6_bokalov_489.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/nabor_iz_6_serebrjanykh_bokalov_479.html") {

            $this->redirect('/489/serebrjanyjj_nabor_iz_6_bokalov.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_fuzher_499.html" ||
            $url == "/catalog/podarki_suveniry/podarki_na_novyjj_god/serebrjanyjj_fuzher_665.html") {

            $this->redirect('/499/serebrjanyjj_fuzher.html', 301);
        }

        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/bokal_iz_serebra_700.html") {
            $this->redirect('/700/bokal_iz_serebra.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_580.html") {
            $this->redirect('/580/serebrjanyjj_bokal.html', 301);
        }

        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/nabor_iz_6_serebrjanykh_fuzherov_203.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/nabor_iz_6_serebrjanykh_fuzherov_480.html" ) {
            $this->redirect('/203/nabor_iz_6_serebrjanykh_fuzherov.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_nabor_iz_6_fuzherov_530.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/serebrjanyjj_nabor_iz_6_fuzherov_495.html" ) {
            $this->redirect('/530/serebrjanyjj_nabor_iz_6_fuzherov.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/fuzher_iz_serebra_529.html") {
            $this->redirect('/529/fuzher_iz_serebra.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_581.html") {
            $this->redirect('/581/serebrjanyjj_bokal.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/6_serebrjanykh_konjachnykh_bokalov_622.html") {
            $this->redirect('/622/6_serebrjanykh_konjachnykh_bokalov.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/bokal_iz_serebra_571.html") {
            $this->redirect('/571/bokal_iz_serebra.html', 301);
        }
        if ($url == "/catalog/stolovoe_serebro/bokaly_i_fuzhery/serebrjanyjj_bokal_615.html") {
            $this->redirect('/615/serebrjanyjj_bokal.html', 301);
        }
        if ($url == "/catalog/podarki_suveniry/jubilejj_godovshhinu/serebrjanye_bokaly_rossija_648.html") {
            $this->redirect('/648/serebrjanye_bokaly_rossija.html', 301);
        }

        if ($url == "/catalog/podarki_suveniry/podarki_na_svadbu/serebrjanyjj_nabor_iz_2_fuzherov_379.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/serebrjanyjj_nabor_iz_2_fuzherov_428.html" ) {
            $this->redirect('/379/serebrjanyjj_nabor_iz_2_fuzherov.html', 301);
        }
        if ($url == "/catalog/podarki_suveniry/podarki_na_svadbu/podarochnyjj_nabor_iz_2_serebrjanykh_bokalov_325.html" ||
            $url == "/catalog/podarki_suveniry/podarochnye_nabory/nabor_iz_2_serebrjanykh_bokalov_423.html" ) {
            $this->redirect('/325/podarochnyjj_nabor_iz_2_serebrjanykh_bokalov.html', 301);
        }

    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            $user = $model->signup();
            if ($user) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->getSession()->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}
