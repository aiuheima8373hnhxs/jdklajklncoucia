<?php
include('../script/krumo/class.krumo.php');

class debug{
    public static $arrayData = [];
    public static $formatString = '';
    static function addMessage($data, string $name=null, string $type=''){
        $array = self::$arrayData[] = [
            'date' => date('Y-m-d H:i:s'),
            'name' => $name,
            'data' => $data,
            'type' => $type
        ];
        self::$formatString .= '<li>';
        switch($type){
            case 'danger':
                self::$formatString .= '<i class="fas fa-times-circle mr-1 text-danger"></i>';
                break;
            case 'info':
                self::$formatString .= '<i class="fas fa-info-circle text-info mr-1"></i>';
                break;
            case 'check':
                self::$formatString .= '<i class="fas fa-check-circle text-success mr-1"></i>';
                break;
            case 'question':
                self::$formatString .= '<i class="fas fa-question-circle text-secondary mr-1"></i>';
                break;
            case 'warning':
                self::$formatString .= '<i class="fas fa-exclamation-circle mr-1 text-warning"></i>';
                break;
        }
        $random = rand(1000, 9999).rand(1000, 9999).rand(1000, 9999);
        self::$formatString .= '<small class="text-muted">['.$name.']</small> <span class="text-info float-right">'.$array['date'].'</span>'.(is_array($data)?'<span class="badge badge-info" data-toggle="collapse" href="#_debugCoolapse'.$random.'">ARRAY</span>':$data).'</li>';
        if(is_array($data))
            self::$formatString .= '<div class="collapse multi-collapse" id="_debugCoolapse'.$random.'">'.krumo($data, KRUMO_RETURN).'</div>';
    }
}
?>