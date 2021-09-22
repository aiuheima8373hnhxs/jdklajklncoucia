<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Szablony</h3>
                <div class="card-tools"></div>
            </div>
            <div class="card-body">
                <?php
                foreach(core::$model['template']->templateList() as $template){
                    echo '<div class="card float-left mr-3" style="width: 300px;">
                        <img class="card-img-top" src="'.$template['image'].'" alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">'.$template['name'].'</h5>
                            <p class="card-text">'.$template['description'].'</p>
                        </div>
                        <div class="card-footer">';
                            if($template['templateName'] == core::$model['config']->read('template_name'))
                                echo '<a href="#" class="btn btn-success btn-block disabled">AKTYWNY</a>';
                            else
                                echo '<a href="siteTemplateActive-'.$template['templateName'].'.html" class="btn btn-primary btn-block">Aktywuj</a>';
                        echo '</div>
                    </div>';
                }
                ?>
            </div>
        </div>
    </div>
</div>