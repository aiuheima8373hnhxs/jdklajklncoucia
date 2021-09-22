<?php
$search = isset($_GET['searchMenu']) ? ($_GET['searchMenu']==''?' ':$_GET['searchMenu']) : ' ';
$searchArray = include('../file/search.php');
?>
<div class='content pt-3'>
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Wyszukiwanie frazy "<?php echo $search ?>"</div>
            </div>
            <div class="card-body">
                <?php
                foreach($searchArray as $data){
                    if(strpos(' '.$data['tags'], $search) != false){
                        echo '<div class="post">
                            <a href="'.$data['link'].'">'.$data['name'].'</a>
                            <p>'.$data['description'].'</p>
                        </div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>