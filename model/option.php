<?php
return new class(){
    private $data = '';
    public function generateOption(array $data){
        core::setError();
        foreach($data as $item){
            if(isset($item['type'])){
                switch($item['type']){
                    case 'container-fluid':
                        $this->addData('<div class="content mt-3"><div class="container-fluid">');
                        if(isset($item['data'])) $this->generateOption($item['data']);
                        $this->addData('</div></div>');
                        break;
                    case 'card':
                        $this->addData('<div class="card">');
                        if(isset($item['header']))
                            if(isset($item['header'])){
                                $this->addData('<div class="card-header">');
                                if(isset($item['header']['title']))
                                $this->addData('<h3 class="card-title">'.$item['header']['title'].'</h3>');
                                $this->addData('</div>');
                            }
                        if(isset($item['data'])) $this->generateOption($item['data']);
                        $this->addData('</div>');
                        break;
                    case 'card-body':
                        $this->addData('<div class="card-body">');
                        if(isset($item['data'])) $this->generateOption($item['data']);
                        $this->addData('</div>');
                        break;
                    case 'card-configTable':
                        $this->addData('<form method="POST"><div class="card-body p-0 table-responsive"><table class="table table-sm"><thead><tr><th style="min-width: 200px; width: 200px">Nazwa</th><th style="min-width: 200px; width: 200px">Dane</th><th style="min-width: 500px;">Opis</th></tr></thead><tbody>');
                        if(isset($item['data'])) $this->generateOption($item['data']);
                        $this->addData("</tbody></table></div><div class='card-footer'><input type='submit' class='btn btn-primary w-100' name='config_save' value='Zapisz konfigurację' /></div></form>");
                        break;
                    case 'tableDataInput':
                        $data = core::$model['config']->read($item['configName'], isset($item['default'])?$item['default']:'');
                        $this->addData('<tr>
                            <td>'.(isset($item['name'])?$item['name']:$item['configName']).'</td>
                            <td><input type="text" class="form-control" style="min-width: 200px;" placeholder="Puste" name="'.$item['configName'].'" value="'.htmlspecialchars($data).'" /></td>
                            <td>'.$item['description'].'</td>
                        </tr>');
                        break;
                    case 'tableDataCheckBootstrap':
                        $data = core::$model['config']->read($item['configName'], isset($item['default'])?$item['default']:'');
                        $idElement = 'form'.$item['configName'].'_switch';
                        $this->addData('<tr>
                            <td>'.(isset($item['name'])?$item['name']:$item['configName']).'</td>
                            <td class="custom-control custom-switch">
                                <input type="checkbox" class="custom-control-input" id="'.$idElement.'" '.(boolval($data)?'checked':'').'>
                                <label class="custom-control-label" for="'.$idElement.'"></label>
                                <input type="hidden" id="'.$idElement.'_value" placeholder="Puste" name="'.$item['configName'].'" value="'.$data.'" />
                                <script>
                                $("#'.$idElement.'").change(function() {
                                    if ($(this).is(":checked") == true) {
                                        $("#'.$idElement.'_value").val("1");
                                    } else {
                                        $("#'.$idElement.'_value").val("0");
                                    }
                                });
                                </script>
                            </td>
                            <td>'.$item['description'].'</td>
                        </tr>');
                        break;
                    case 'tableDataSelectBootstrap':
                        $data = core::$model['config']->read($item['configName'], isset($item['default'])?$item['default']:'');
                        $this->addData('<tr>
                            <td>'.(isset($item['name'])?$item['name']:$item['configName']).'</td>
                            <td class="form-group">
                                <select name="'.$item['configName'].'" class="custom-select">');
                                if(isset($item['data'])){
                                    foreach($item['data'] as $value => $name){
                                        $this->addData('<option value="'.$value.'" '.(strval($data)==strval($value)?'selected':'').'>'.$name.'</option>');
                                    }
                                }
                                $this->addData('</select>
                            </td>
                            <td>'.$item['description'].'</td>
                        </tr>');
                        break;
                    case 'text':
                        $this->addData($item['value']);
                }
            }
        }
    }
    public function showOption(){
        core::setError();
        echo $this->data;
        $this->clearOption();
    }
    public function clearOption(){
        core::setError();
        $this->data = '';
    }
    private function addData($data=''){
        core::setError();
        $this->data .= $data;
    }
}
?>