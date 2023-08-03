<?php

namespace common\components;

use yii\base\Component;
use Yii;

class Helper extends Component
{

    //convert dd-mm-yyyy to yyyy-mm-dd
    public function konversiDate($date)
    {
        $date = preg_replace('/\s+/', '', $date);
        if (preg_match("/^(0[1-9]|[1-2][0-9]|3[0-1])-(0[1-9]|1[0-2])-[0-9]{4}$/", $date)) {
            $pis = explode("-", $date);
            $tgl = $pis[0];
            $bln = $pis[1];
            $thn = $pis[2];
            $new_data = $thn . "-" . $bln . "-" . $tgl;
            $konversiDate = date($new_data);
            return $konversiDate;
        }
        return $date;
    }

    public function getTrimCepatKodeV2($cepatkode)
    {
        $kode = rtrim($cepatkode, 0);
        if (strlen($kode) == 2) {
            return $kode . "00000000";
        } elseif (strlen($kode) == 3 || strlen($kode) == 5) {
            return $kode . "0";
        } elseif (strlen($kode) == 4) {
            if ($kode == '0201' || $kode == '0202' || $kode == '0203' || $kode == '0204' || $kode == '0205' || $kode == '0206') {
                return $kode . "000000";
            } else {
                return $kode;
            }
        } else {
            return $kode;
        }
    }

    //convert rupiah ke integer
    public function rupiah_to_int($rupiah)
    {
        return intval(preg_replace('/[^0-9]/s', '', $rupiah));
    }
    public function setChangeStepsIP($steps, $step)
    {
        foreach ($steps as $k => $v) {
            if ($v['id'] == $step) {
                \Yii::$app->globalstateIP->set('curStepIP#' . Yii::$app->user->identity->nip, $step);
                $steps[$k]['status'] = 'active';
            }
            if ($steps[$k]['id'] < $step) {
                $steps[$k]['status'] = 'complete';
            }
        }
        return $steps;
    }
    public function updateGlobalStateIP()
    {
        $nip = Yii::$app->user->identity->nip;
        $isBack =  \Yii::$app->globalstateIP->get('isBackIP#' . $nip);
        if (!$isBack) {
            $currentStep =  \Yii::$app->globalstateIP->get('curStepIP#' . Yii::$app->user->identity->nip);
            $params = \Yii::$app->request->queryParams;
            unset($params['step']);
            \Yii::$app->globalstateIP->set('valPrevStepIP#' . $nip . '#' . $currentStep,  $params);
        }
    }
    public function setChangeSteps($steps, $step)
    {

        foreach ($steps as $k => $v) {
            if ($v['id'] == $step) {
                \Yii::$app->globalstate->set('curStep#' . Yii::$app->user->identity->nip, $step);
                $steps[$k]['status'] = 'active';
            }
            if ($steps[$k]['id'] < $step) {
                $steps[$k]['status'] = 'complete';
            }
        }
        return $steps;
    }
    public function findArray($arr, $key, $value)
    {
        $result = array_filter($arr, function ($val) use ($key, $value) {
            return ($val[$key] == $value);
        });

        return array_merge(...$result);
    }
    public function updateGlobalState()
    {
        $nip = Yii::$app->user->identity->nip;
        $isBack =  \Yii::$app->globalstate->get('isBack#' . $nip);
        if (!$isBack) {
            $currentStep =  \Yii::$app->globalstate->get('curStep#' . Yii::$app->user->identity->nip);
            $params = \Yii::$app->request->queryParams;
            unset($params['step']);
            \Yii::$app->globalstate->set('valPrevStep#' . $nip . '#' . $currentStep,  $params);
        }
        \Yii::$app->globalstate->set('isBack#' . $nip, false);
    }
    public function convertNumberDashboard($num)
    {
        $tab = explode(",", $num);
        $arrayNumber = array_reverse($tab);
        if (intval(isset($arrayNumber[0])) != 0) {

            $str[] = $arrayNumber[0];
        }
        if (intval(isset($arrayNumber[1])) != 0) {
            $str[] = $arrayNumber[1] . '.';
        }
        if (intval(isset($arrayNumber[2])) != 0) {
            $str[] = $arrayNumber[2] . '.';
        }
        $strArr = array_reverse($str);
        $data['first']  = $strArr[0];
        unset($strArr[0]);
        $newarr = join('', $strArr);
        $data['last']  = $newarr;
        return $data;
    }
    public function getBulan($id)
    {
        switch ($id) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            default:
                return "Desember";
        }
    }
}
