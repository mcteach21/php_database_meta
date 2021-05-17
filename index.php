<?php
    /**
     * mc@2021
     */
    define('ROOT', str_replace('index.php','', $_SERVER['SCRIPT_FILENAME']));

    require_once 'db/generator.class.php';
    require_once 'dao/dao.class.php';

    $tables = Meta::tables();
    // print_r(MetaGenerator::$mapping);
    if(isset($_POST['mapit'])){

        MetaGenerator::init();

        foreach ($_POST['classes'] as $key => $class){
            $table = $_POST['tables'][$key];
            MetaGenerator::create_mapping_class($class, $table);
        }

    }
    $log='';

/*    $dao = new Dao('countrylanguage');
    $items =  $dao->all();
    print_r($items);*/


 /*   $directory =  str_replace('index.php','', $_SERVER['SCRIPT_FILENAME']).'\classes\\';
    $directory_files = array_diff(scandir($directory), array('..', '.'));
    echo '<div style="color:white">';
        print_r($directory_files);
        echo '<hr/>';
        foreach ($directory_files as $file){
            echo $file.'<br/>';
            $section = file_get_contents($directory.$file, FALSE, NULL, 5, 100);
            //echo $section;

            preg_match("/@table\((.*?)\)/", $section, $matches);
            echo $file.' ==> '.$matches[1];
            echo '<hr/>';
        }
    echo '</div>';*/

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>DB Meta</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" >
    <link rel="stylesheet" href="assets/css/main.css">
</head>
<body>

    <div class="container">

        <div class="row">
            <div class="meta col-md-4 col-sm-12">
                <div class="card" style="">
                    <img class="card-img-top" src="assets/images/mysql-logo.png" alt="logo">
                    <div class="card-body">
                        <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    </div>
                </div>
            </div>
            <div class="mapping col-md-4 col-sm-12">

            </div>
        </div>
        <hr/>
        <div class="row">
            <div class="meta col-md-8 col-sm-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Table</th>
                            <th scope="col">Rows</th>
                            <th scope="col">Class (Mapping)</th>
                        </tr>
                        </thead>
                        <tbody>

                        <?php
                            $i=1;
                            foreach ($tables as $table) {
                        ?>
                            <tr class="accordion-toggle collapsed" id="accordion<?= $i ?>" data-toggle="collapse" data-parent="#accordion<?= $i ?>" href="#collapse<?= $i ?>">
                                <td class="expand-button"></td>
                                <td><?= ucfirst($table['TABLE_NAME']) ?></td>
                                <td><?= $table['TABLE_ROWS'] ?></td>
                                <td><?= MetaGenerator::mapped_class($table['TABLE_NAME']) ?></td>
                            </tr>
                                <tr class="hide-table-padding">
                                    <td></td>
                                    <td colspan="3">
                                        <div id="collapse<?= $i ?>" class="collapse in p-3">
                                            <div class="row">
                                            <?php
                                                echo '<table  class="table table-striped table-bordered">';
                                                    echo '<thead class="thead">
                                                    <tr>
                                                        <th scope="col">NAME</th>
                                                        <th scope="col">TYPE</th>
                                                        <th scope="col">INDEX</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody class="details-table">';
                                                    $columns = Meta::columns($table['TABLE_NAME']);

                                                    foreach ($columns as $column) {
                                                    echo '<tr><td>'.$column['COLUMN_NAME'] . '</td><td>' . $column['DATA_TYPE'] . '</td><td>' . $column['COLUMN_KEY'] . '</td></tr>';
                                                    }
                                                    echo '</tbody></table>';
                                            ?>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                                $i++;
                            }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="mapping col-md-4 col-sm-12">
                <form class="rounded" method="post" action="">
                    <button class="btn btn-primary" type="submit" name="mapit">Create Classes (Mapping)</button>
                    <div class="form-group">
                    <?php
                        foreach ($tables as $table) {
                            ?>
                            <input class="form-input" type="hidden" value="<?= ucfirst($table['TABLE_NAME']) ?>" name="tables[]" required>
                            <input class="form-input" type="text" value="<?= ucfirst($table['TABLE_NAME']) ?>" name="classes[]" required>
                            <?php
                        }
                    ?>
                    </div>
                </form>
                <div class="msg">
                    <?= $log ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"  ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</body>
</html>


