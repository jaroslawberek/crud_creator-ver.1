<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CrudCreator
 *
 * @author Acer
 */
class CrudCreator {

    private $pdo;
    public $webPath;
    private $project_name;
    private $base_host;
    private $base_name;
    private $base_user;
    private $base_password;
    private $table_name;
    private $viewFolder;
    private $controller_header;
    public $tableAttributess;
    public $attrInputData;
    private $controler_name;
    private $model_name;
    private $controlersPath = "app\\Http\\Controllers\\";
    private $requestsPath = "app\\Http\\Requests\\";
    private $modelsPath = "app\\";
    private $routesPath = "routes\\web.php";
    public $useRequestForm = false;
    public $setHasManyCount = true;
    public $belongsTo;
    public $hasMany;
    public $addSelect2_Fk;
    public $selects_tables="";
    public $joins="";
    public $tableAttributessForHtmlTable;

    /*
     * DBOject - Pobieranie listy pol o okreslonym type
     */

    public function getFirldsOfType($param) {
        $query = "select col.table_schema as database_name,
                    col.table_name,
                    col.ordinal_position as column_id,
                    col.column_name,
                    col.data_type,
                   REPLACE(trim(leading 'enum(' from col.column_type),')','') as enum_values
             from information_schema.columns col
             join information_schema.tables tab on tab.table_schema = col.table_schema
                                                and tab.table_name = col.table_name
                                                and tab.table_type = 'BASE TABLE'
             where col.data_type in ('{$param}')
                   and col.table_schema not in ('information_schema', 'sys',
                                                'performance_schema', 'mysql')
                  and col.table_schema = '{$this->base_name}'
             order by col.table_schema,
                      col.table_name,
                      col.ordinal_position";
        return $this->pdo->query($query)->fetchAll();
    }

    public function createCrudForTable($baseName, $tableName, $notIn = null) {
die("huj");
        if (($baseName != "") && ($tableName!="")){
            $query = "SELECT * FROM information_schema.`TABLES`WHERE TABLE_SCHEMA ='{$baseName}' AND TABLE_NAME ='{$tableName}'";
            $tables = $this->pdo->query($query)->fetchAll();
            print_r($tables);
            die();
            foreach ($tables as $table) {
                $this->attrInputData = ['char' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                    'varchar' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                    'text' => ['type' => 'textarea', 'class' => 'form-control', 'add_class' => ''],
                    'enum' => ['type' => 'enum', 'class' => 'form-control', 'add_class' => ''],
                    'int' => ['type' => 'number', 'class' => 'form-control', 'add_class' => ''],
                    'date' => ['type' => 'date', 'class' => 'form-control', 'add_class' => 'date'],
                    'timestamp' => ['type' => 'datetime', 'class' => 'form-control', 'add_class' => 'date'],
                ];

                $this->controler_name = ucfirst($table['TABLE_NAME']);
                $this->model_name = substr(ucfirst($table['TABLE_NAME']), 0, -1);
                $this->table_name = $table['TABLE_NAME'];
//                 if( file_exists($this->getPathController())||(file_exists($this->getPathModel())) ){
//                     echo("Controler lib model dla tabeli {$table['TABLE_NAME']} już istnieje!")."<br>";
//                     continue;
//                 }
                $this->setTableAttributes((['id', 'created_at', 'updated_at', 'del']));
                $this->useRequestForm = true;
                // $this->setHasManyCount = true; // czy ma wstawic ->withCount() i with dla HasMany
                echo "<pre>hasMany: " . print_r($this->hasMany, true);
                echo "<pre>belongsTo: " . print_r($this->belongsTo, true);
                echo "..................Create crud for {$table['TABLE_NAME']}...<br>";
                echo "makeController...<br>";
                file_put_contents($this->getPathController(), $this->makeController());

                echo "makeWebRoute...<br>";
                file_put_contents($this->getPathWeb(), $this->makeWebRoute(), FILE_APPEND);

                echo "makeModel...<br>";
                file_put_contents($this->getPathModel(), $this->makeModel());

                echo "makeViewTable...<br>";
                file_put_contents($this->getPathViewTable(), $this->makeViewTable());

                echo "makeViewAjaxTable...<br>"; //   
                file_put_contents($this->getPathViewAjaxTable(), $this->getViewAjaxTable());

                echo "makeViewForm...<br>"; //
                file_put_contents($this->getPathViewForm(), $this->makeViewForm());
//                die();
            }
        } else
            throw new Exception(__FUNCTION__ . ": Nie podano nazwy bazy danych lub nazwy tabeli!");
    }
    public function createCrudAllTables($baseName, $notIn = null) {

        if ($baseName != "") {
            $query = "SELECT * FROM information_schema.`TABLES`WHERE TABLE_SCHEMA ='{$baseName}'";
            $tables = $this->pdo->query($query)->fetchAll();

            foreach ($tables as $table) {
                $this->attrInputData = ['char' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                    'varchar' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                    'text' => ['type' => 'textarea', 'class' => 'form-control', 'add_class' => ''],
                    'enum' => ['type' => 'enum', 'class' => 'form-control', 'add_class' => ''],
                    'int' => ['type' => 'number', 'class' => 'form-control', 'add_class' => ''],
                    'date' => ['type' => 'date', 'class' => 'form-control', 'add_class' => 'date'],
                    'timestamp' => ['type' => 'datetime', 'class' => 'form-control', 'add_class' => 'date'],
                ];

                $this->controler_name = ucfirst($table['TABLE_NAME']);
                $this->model_name = substr(ucfirst($table['TABLE_NAME']), 0, -1);
                $this->table_name = $table['TABLE_NAME'];
//                 if( file_exists($this->getPathController())||(file_exists($this->getPathModel())) ){
//                     echo("Controler lib model dla tabeli {$table['TABLE_NAME']} już istnieje!")."<br>";
//                     continue;
//                 }
                $this->setTableAttributes((['id', 'created_at', 'updated_at', 'del']));
                $this->useRequestForm = true;
                // $this->setHasManyCount = true; // czy ma wstawic ->withCount() i with dla HasMany
                echo "<pre>hasMany: " . print_r($this->hasMany, true);
                echo "<pre>belongsTo: " . print_r($this->belongsTo, true);
                echo "..................Create crud for {$table['TABLE_NAME']}...<br>";
                echo "makeController...<br>";
                file_put_contents($this->getPathController(), $this->makeController());

                echo "makeWebRoute...<br>";
                file_put_contents($this->getPathWeb(), $this->makeWebRoute(), FILE_APPEND);

                echo "makeModel...<br>";
                file_put_contents($this->getPathModel(), $this->makeModel());

                echo "makeViewTable...<br>";
                file_put_contents($this->getPathViewTable(), $this->makeViewTable());

                echo "makeViewAjaxTable...<br>"; //   
                file_put_contents($this->getPathViewAjaxTable(), $this->getViewAjaxTable());

                echo "makeViewForm...<br>"; //
                file_put_contents($this->getPathViewForm(), $this->makeViewForm());
//                die();
            }
        } else
            throw new Exception(__FUNCTION__ . ": Nie podano nazwy bazy danych!");
    }

    public function setTableAttributes($columnNameNotIn) {

        $this->pdo = new PDO('mysql' . ":host={$this->base_host}" . ';dbname=' . $this->base_name, 'root', $this->base_password);

        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!$this->pdo) {
            throw new Exception("Błąd połączenia z bazą danych");
            die;
        }
        $notIn = "";
        foreach ($columnNameNotIn as $value) {
            $notIn .= "'{$value}',";
        }
        $notIn = substr($notIn, 0, strlen($notIn) - 1);

        //pobieram wszytskie informacje o wystepowaniu klucza glownego w innych tabelach: lista tab
        $foriegen_key_in = "SELECT 
                            COLUMN_NAME, REFERENCED_TABLE_NAME, REFERENCED_COLUMN_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                            WHERE
                            CONSTRAINT_NAME <>'PRIMARY' AND 
                            TABLE_SCHEMA = '{$this->base_name}' AND
                            TABLE_NAME = '{$this->table_name}'";
        $this->belongsTo = $this->pdo->query($foriegen_key_in)->fetchAll();

        $foriegen_key_out = "SELECT 
                            TABLE_NAME, COLUMN_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE
                            WHERE
                            CONSTRAINT_NAME <>'PRIMARY' AND 
                            TABLE_SCHEMA = '{$this->base_name}' AND
                            REFERENCED_TABLE_NAME = '{$this->table_name}'";
        $this->hasMany = $this->pdo->query($foriegen_key_out)->fetchAll();

        //Wszytskie pola typu enum w bazie danych
        $enums_fileds = "select col.table_schema as database_name,
                    col.table_name,
                    col.ordinal_position as column_id,
                    col.column_name,
                    col.data_type,
                   REPLACE(trim(leading 'enum(' from col.column_type),')','') as enum_values
             from information_schema.columns col
             join information_schema.tables tab on tab.table_schema = col.table_schema
                                                and tab.table_name = col.table_name
                                                and tab.table_type = 'BASE TABLE'
             where col.data_type in ('enum')
                   and col.table_schema not in ('information_schema', 'sys',
                                                'performance_schema', 'mysql')
                  and col.table_schema = '{$this->base_name}'
             order by col.table_schema,
                      col.table_name,
                      col.ordinal_position";
        $this->enums_fileds = $this->pdo->query($enums_fileds)->fetchAll();
        $query = "  SELECT TABLE_SCHEMA,`TABLE_NAME`, COLUMN_NAME, IS_NULLABLE,DATA_TYPE,
                    CHARACTER_MAXIMUM_LENGTH, NUMERIC_PRECISION, NUMERIC_SCALE, 
                    COLUMN_COMMENT, if(isc.DATA_TYPE = 'enum', REPLACE(trim(leading 'enum(' from isc.column_type),')',''),isc.column_type ) as specyfic_kolumn,
                     (SELECT 
                            REFERENCED_TABLE_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE isk
                            WHERE
                            CONSTRAINT_NAME <>'PRIMARY' AND  isk.`COLUMN_NAME` = isc.`COLUMN_NAME` AND
                            TABLE_SCHEMA = '{$this->base_name}' AND
                            TABLE_NAME = '{$this->table_name}') as foriegen_table,
                      (SELECT 
                            REFERENCED_COLUMN_NAME
                            FROM
                            INFORMATION_SCHEMA.KEY_COLUMN_USAGE isk
                            WHERE
                            CONSTRAINT_NAME <>'PRIMARY' AND  isk.`COLUMN_NAME` = isc.`COLUMN_NAME` AND
                            TABLE_SCHEMA = '{$this->base_name}' AND
                            TABLE_NAME = '{$this->table_name}') as foriegen_field
                    FROM information_schema.COLUMNS  isc                 
                   WHERE COLUMN_NAME not in ({$notIn}) AND TABLE_SCHEMA ='{$this->base_name}' and `TABLE_NAME` like '%{$this->table_name}%' ";

        $stmt = $this->pdo->query($query);

        $this->tableAttributess = $stmt->fetchAll();
        foreach ($this->tableAttributess as $index => $value) {
            $value['huj'] = "kutas";
            $comment = $value['COLUMN_COMMENT'];
            if ($comment != "") {
                $v = explode(',', $comment);        //tu mamy np input:combo,label: plec itp       
                foreach ($v as $f) {
                    $f = explode(':', $f);
                    $this->tableAttributess[$index][trim($f[0])] = trim($f[1]);
                }
            }
        }
        if (count($this->tableAttributess) == 0)
            throw new Exception("Nie można ustalić struktury tabeli {$this->table_name} dla bazy {$this->base_name}" . print_r($this->tableAttributess, true));
        else
           
            return true;
    }
    
    public function setColumnsForTable($columns=[]){
         $this->tableAttributessForHtmlTable=[];
         $tmp=[];
          foreach ( $this->tableAttributess as $index =>$value) {
              $tmp[$value['COLUMN_NAME']]=$value;             
          }
          foreach ($columns as $columns_value) {
              $this->tableAttributessForHtmlTable[]=$tmp[$columns_value];
              
          }
         echo "<pre>". print_r($this->tableAttributessForHtmlTable,true);
    }

    /*
     * ModelObject - Tworzenie funkcji  relacji hasmany
     */

    public function makeHasManyFunctions() {

        $fun = "";
        foreach ($this->hasMany as $has) {

            // $has['TABLE_NAME'] = 
            $h = substr(ucfirst($has['TABLE_NAME']), 0, -1);
            $fun .= PHP_EOL;
            $fun .= "public function {$has['TABLE_NAME']}()" . PHP_EOL;
            $fun .= "{" . PHP_EOL;
            $fun .= "   return \$this->hasMany({$h}::class,'{$has['COLUMN_NAME']}','id');" . PHP_EOL;
            $fun .= "}";
        }
        return $fun;
    }

    /*
     * 
     */

    public function makeWithCount_HasMany() {
        $h = "";
        foreach ($this->hasMany as $has) {
            $h .= "->withCount('{$has['TABLE_NAME']}')";
        }
        if ($this->setHasManyCount == true)
            return $h;
        else
        if ($h != "")
            return "/*" . $h . "*/";
        else
            return $h;
    }

    /*
     * 
     */

    public function makeWith_HasMany() {
        $h = "";
        foreach ($this->hasMany as $has) {
            $h .= "->with('{$has['TABLE_NAME']}')";
        }
        if ($this->setHasManyCount == true)
            return $h;
        else
        if ($h != "")
            return "/*" . $h . "*/";
        else
            return $h;
    }

    /*
     * ModelObject - Tworzenie funkcji  relacji BelongsTo
     */

    public function makeBelongsToFunctions() {
        $fun = "";
        foreach ($this->belongsTo as $belong) {

            $h = substr(ucfirst($belong['REFERENCED_TABLE_NAME']), 0, -1);
            $fun .= PHP_EOL;
            $fun .= "public function {$belong['REFERENCED_TABLE_NAME']}()" . PHP_EOL;
            $fun .= "{" . PHP_EOL;
            $fun .= "   return \$this->belongsTo($h::class,'" . substr($belong['REFERENCED_TABLE_NAME'], 0, -1) . "_id'" . ",'id');" . PHP_EOL;
            $fun .= "}" . PHP_EOL;
        }
        return $fun;
    }

    public function makeWith_BelongsTo() {
        $h = "";
        foreach ($this->belongsTo as $belongsTo) {
            $h .= "->with('{$belongsTo['REFERENCED_TABLE_NAME']}')";
        }
        return $h;
    }

    public function __construct($project_name, $viewFolder, $webPath = "C:\\xampp\htdocs\\") {

        $this->webPath = $webPath;
        if (($project_name != "") && (is_string($project_name)))
            $this->project_name = $project_name;
        else
            throw new Exception("Nie podano nazwy projektu lub nazwa projektu nie jest poprawna!");

        if (($viewFolder != "") && (is_string($viewFolder)))
            $this->viewFolder = lcfirst($viewFolder);
        else
            throw new Exception("Nie podano nazwy katalogu widoku lub nazwa katalogu  nie jest poprawna!");
        $this->webPath = $this->webPath . $this->project_name . '\\';
        $this->attrInputData = ['char' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                                'varchar' => ['type' => 'text', 'class' => 'form-control', 'add_class' => ''],
                                'text' => ['type' => 'textarea', 'class' => 'form-control', 'add_class' => ''],
                                'enum' => ['type' => 'enum', 'class' => 'form-control', 'add_class' => ''],
                                'int' => ['type' => 'number', 'class' => 'form-control', 'add_class' => ''],
                                'date' => ['type' => 'date', 'class' => 'form-control', 'add_class' => 'date'],
                                'timestamp' => ['type' => 'datetime', 'class' => 'form-control', 'add_class' => 'date'],
        ];
    }

    public function setCrud($controler, $model, $table, $base_name, $base_host = "localhost", $base_user = "root", $base_password = "") {

        if (($controler != "") && (is_string($controler)))
            $this->controler_name = ucfirst($controler);
        else
            throw new Exception("Nie podano nazwy kontrolera lub nazwa nie jest poprawna!");


        if (($model != "") && (is_string($model)))
            $this->model_name = ucfirst($model);
        else
            throw new Exception("Nie podano nazwy modelu lub nazwa nie jest poprawna!");


        if (($table != "") && (is_string($table)))
            $this->table_name = $table;
        else
            throw new Exception("Nie podano nazwy tabeli lub nazwa nie jest poprawna!");


        if (($base_name != "") && (is_string($base_name)))
            $this->base_name = $base_name;
        else
            throw new Exception("Nie podano nazwy bazy danych lub nazwa nie jest poprawna!");


        if (($base_host != "") && (is_string($base_host)))
            $this->base_host = $base_host;
        else
            throw new Exception("Nie podano hosta bazy danych lub host nie jest poprawny!");


        if (($base_user != "") && (is_string($base_user)))
            $this->base_user = $base_user;
        else
            throw new Exception("Nie podano użytkownika bazy danych lub nazwa nie jest poprawna!");



        $this->base_password = $base_password;
    }

    private function makeFormRequest() {
        $viewRequest = file_get_contents("templates/requests/wiev_requests.php");
        $viewRequest = str_replace("<*<controller>*>", $this->controler_name, $viewRequest);
        $validate = $this->makeValid(true);
        $viewRequest = str_replace("<*<request>*>", $this->getNameRequests(), $viewRequest);
        $viewRequest = str_replace("<*<date_create>*>", date("F j, Y, g:i a"), $viewRequest);
        $viewRequest = str_replace("<*<request_rules>*>", $validate['rules'], $viewRequest);
        $viewRequest = str_replace("<*<request_messages>*>", $validate['messages'], $viewRequest);

        file_put_contents($this->getPathRequestsFolder(), $viewRequest);
        return "//      Retrieve the validated input data..." . PHP_EOL . "\$validated = \$request->validated();";
    }

    private function makeValid($isRequestForm = false) {
        $messages = "";
        $valid = "";

        foreach ($this->tableAttributess as $ta) {
            $v = "";
            if ($ta['IS_NULLABLE'] == "NO") {
                $v .= "required";
                $messages .= "'{$ta['COLUMN_NAME']}.required'=>" . "'Nie podano :attribute'," . PHP_EOL;
            }
            if ($ta['DATA_TYPE'] == "int") {
                $v .= "|numeric";
            } else if (($ta['DATA_TYPE'] == "varchar") || ($ta['DATA_TYPE'] == "char")) {
                if ((isset($ta['type'])) && ($ta['type'] == 'img')) {
                    $v .= "|image|mimes:jpeg,png,jpg,gif,svg|max:2048";
                    $messages .= "'{$ta['COLUMN_NAME']}.date'=>" . "'Nie prawidłowy format pliku'," . PHP_EOL;
                } else {
                    $v .= "|min:1|max:{$ta['CHARACTER_MAXIMUM_LENGTH']}";
                    $messages .= "'{$ta['COLUMN_NAME']}.min'=>" . "'Za krótki :attribute. Podaj maksymalnie :min znaków'," . PHP_EOL;
                    $messages .= "'{$ta['COLUMN_NAME']}.max'=>" . "'Za długi :attribute. Podaj maksymalnie :max znaków'," . PHP_EOL;
                }
            } else if ($ta['DATA_TYPE'] == "date") {
                $v .= "|date";
                $messages .= "'{$ta['COLUMN_NAME']}.date'=>" . "'Nie prawidłowa data w  :attribute'," . PHP_EOL;
                ;
            } else if ($ta['DATA_TYPE'] == "enum") {
                $v .= "|in:" . str_replace("'", '', $ta['specyfic_kolumn']);
                $messages .= "'{$ta['COLUMN_NAME']}.in'=>" . "'Nie prawidłowo w  :attribute'," . PHP_EOL;
            } else if ($ta['DATA_TYPE'] == "file") {
                $v .= "|image|mimes:jpeg,png,jpg,gif,svg|max:2048";
                $messages .= "'{$ta['COLUMN_NAME']}.date'=>" . "'Nie prawidłowy format pliku'," . PHP_EOL;
                ;
            }
            if ($v != "")
                $valid .= "'{$ta['COLUMN_NAME']}'=>'{$v}'," . PHP_EOL;
        }
        if ($isRequestForm == false) {
            $valid = "\$validator = Validator::make(\$request->all(), [" . PHP_EOL . $valid;
            $valid .= "],[" . $messages . "])->valid();" . PHP_EOL;

            return $valid;
        } else {
            return ['rules' => $valid, 'messages' => $messages];
        }
    }

    private function makeFillable() {

        $f = [];
        foreach ($this->tableAttributess as $ta) {
            $f[] = "'" . $ta['COLUMN_NAME'] . "'";
        }

        return implode(',', $f);
    }

    public function makeViewForm() {

        $viewForm = file_get_contents("templates/views/forms/view_form_container.php");
        $viewForm = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewForm);
        $viewForm = str_replace("<*<model>*>", strtolower($this->model_name), $viewForm);
        $viewForm = str_replace("<*<date_create>*>", date("F j, Y, g:i a"), $viewForm);
        $viewFormGroup = file_get_contents("templates/views/forms/view_form_group.php");
        $viewFormInputGroup = file_get_contents("templates/views/forms/view_form_input_group.php");
        $view_Select2_Fk = file_get_contents("templates/views/forms/view_form_function_Select2_Fk.php");
        $view_form_select2_fk = file_get_contents("templates/views/forms/view_form_select2_fk.php");
        $viewFormCheckbox = file_get_contents("templates/views/forms/view_form_checkbox.php");
        $viewFormTextArea = file_get_contents("templates/views/forms/view_form_textarea.php");
        $viewFormSelect = file_get_contents("templates/views/forms/view_form_select.php");
        $viewFormOption = file_get_contents("templates/views/forms/view_form_option.php");
        $viewFormCombo = file_get_contents("templates/views/forms/view_form_combo.php");
        $fields = "";
        $input = "";
        $select2_fun ="";
        $fun="";
        foreach ($this->tableAttributess as $ta) {
            $input = "";
            $textArea = "";
            $fun="";
            if (($ta['DATA_TYPE'] == "int") && ($ta['specyfic_kolumn'] == "int(1)")) { //checkbox
                $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewFormCheckbox);
                $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<class>*>", '' . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $input);
            } else if (($ta['DATA_TYPE'] == "int") && ($ta['foriegen_field'] != "")) {
                $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $view_form_select2_fk);
                $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<class>*>", 'form-control ', $input);
                $input = str_replace("<*<model_fk>*>", $ta['foriegen_table'], $input);
               // $this->addSelect2_Fk .= " sel(\"" . strtolower($this->controler_name) . "_" . $ta['COLUMN_NAME'] . "\",\"/ " . strtolower($this->controler_name) . "/getOne\");" . PHP_EOL;
                
                $fun = str_replace("<*<model>*>", strtolower($this->model_name),$view_Select2_Fk);
                $fun = str_replace("<*<controller>*>", strtolower($this->controler_name),$fun);
                $fun = str_replace("<*<name>*>", $ta['COLUMN_NAME'],$fun);
                $fun = str_replace("<*<search>*>", $ta['search']??"",$fun);
                //$this->controller_update_select2 .= "\$player = Player::find(\$" . strtolower($this->controler_name) . "->" . $ta['COLUMN_NAME'] . "\");" . PHP_EOL;
            } else if ($ta['DATA_TYPE'] == "text") { //textarea
                $textArea = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewFormTextArea);
                $textArea = str_replace("<*<model>*>", strtolower($this->model_name), $textArea);
                $textArea = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $textArea);
                $textArea = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $textArea);
                $textArea = str_replace("<*<class>*>", $this->attrInputData[$ta['DATA_TYPE']]['class'] . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $textArea);
            } else if ($ta['DATA_TYPE'] == "enum") {

                if ($ta['type'] == "select") {
                    $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewFormSelect);
                    $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                    $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                    $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                    $input = str_replace("<*<class>*>", $this->attrInputData[$ta['DATA_TYPE']]['class'] . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $input);
                    $enums = explode(',', $ta['specyfic_kolumn']);
                    // print_r($enums);
                    $options = "";
                    foreach ($enums as $enum) {
                        $opt = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $viewFormOption);
                        $opt = str_replace("<*<option>*>", trim($enum, "'"), $opt);
                        $opt = str_replace("<*<model>*>", strtolower($this->model_name), $opt);
                        $opt = str_replace("<*<option_label>*>", trim($enum, "'"), $opt);
                        $options .= $opt . PHP_EOL;
                    }
                    $input = str_replace("<*<options>*>", $options, $input);
                } else if ($ta['type'] == "combo") {
                    $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewFormGroup);
                    $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                    $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                    $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                    $input = str_replace("<*<class>*>", $this->attrInputData[$ta['DATA_TYPE']]['class'] . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $input);
                    $enums = explode(',', $ta['specyfic_kolumn']);
                    // print_r($enums);
                    $options = "";
                    foreach ($enums as $enum) {
                        $opt = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $viewFormCombo);
                        $opt = str_replace("<*<option>*>", trim($enum, "'"), $opt);
                        $opt = str_replace("<*<model>*>", strtolower($this->model_name), $opt);
                        $opt = str_replace("<*<option_label>*>", trim($enum, "'"), $opt);
                        $options .= $opt . PHP_EOL;
                    }
                    $input = str_replace("<*<content>*>", $options, $input);
                }
            } else {

                $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewFormInputGroup);
                $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                if ((isset($ta['type'])) && ($ta['type'] == 'img')) {
                    $input = str_replace("<*<typ>*>", 'file', $input);
                } else {
                    $input = str_replace("<*<typ>*>", $this->attrInputData[$ta['DATA_TYPE']]['type'], $input);
                }
                $input = str_replace("<*<class>*>", $this->attrInputData[$ta['DATA_TYPE']]['class'] . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $input);
            }
            $fields .= PHP_EOL . $input . PHP_EOL . $textArea . PHP_EOL;
            $select2_fun .= $fun;
        }
        $viewForm = str_replace("$<*<form_inputs>*>", $fields, $viewForm);
        $viewForm = str_replace("<*<addSelect2_Fk_body>*>", $select2_fun, $viewForm);
        file_put_contents("TEST.txt", $viewForm);
        return $viewForm;
    }

    public function makeViewTable() {
        $table = "@extends('layouts.{$this->viewFolder}')" . PHP_EOL . "@section('content')" . PHP_EOL;
        $table .= $this->getViewTable();
        $table .= PHP_EOL . "@endsection";
        return $table;
    }

    public function makeWebRoute() {
        $wr = " ";
        $wr .= "//------ Route for {$this->controler_name} ------" . PHP_EOL;
        $wr .= " Route::get('/" . strtolower($this->controler_name) . "/destroy/{id}', '{$this->controler_name}@destroy')->name('destroy-" . strtolower($this->model_name) . "');
                 Route::get('/" . strtolower($this->controler_name) . "/ajaxField','" . strtolower($this->controler_name) . "@ajaxField')->name('ajaxField');" . PHP_EOL ."
                 Route::get('/" . strtolower($this->controler_name) . "/select2_ajax','" . strtolower($this->controler_name) . "@select2_ajax')->name('select2_ajax');". PHP_EOL."
                 Route::get('/" . strtolower($this->controler_name) . "/getOne','" . strtolower($this->controler_name) . "@getOne')->name('getOne');". PHP_EOL.
                "Route::resource('" . strtolower($this->controler_name) . "', " . strtolower($this->controler_name) . "::class);" . PHP_EOL;

        return $wr;
    }

    public function makeModel() {
        $model = "<?php
" . PHP_EOL . "//" . date("F j, Y, g:i a") . "
namespace App;

use Illuminate\Database\Eloquent\Model;

class {$this->model_name} extends Model
{
    //protected \$table='';
     protected \$fillable = [{$this->makeFillable()}];         
     //Relacje  
     " . $this->makeHasManyFunctions() . "
     " . $this->makeBelongsToFunctions() . "
}
";
        return $model;
    }
    
    private function replacePrimaryValues($target){
        
          if($target=="")
             die("Nie podano nazwy repozytorium lub nazwy gatway");
          
        $target = str_replace("<*<controller>*>", strtolower($this->controler_name), $target);
        $target = str_replace("<*<controller_name>*>", $this->controler_name, $target);
        $target = str_replace("<*<model>*>", strtolower($this->model_name), $target);
        $target = str_replace("<*<date_create>*>", date("F j, Y, g:i a"), $target);
        $target = str_replace("<*<repository>*>", $this->reposytory_name, $target);
        $target = str_replace("<*<gateways>*>", $this->gatway_name, $target);
        
        return $target;
    }

    public function makeControllerForGatwayReposytory() {
         
         if((!$this->reposytory_name)||(!$this->gatway_name))
             die("Nie podano nazwy repozytorium lub nazwy gatway");
         
        $controller = file_get_contents("templates/ControllerForGetwayReposytory/controller_class.php");
        
        $index = file_get_contents("templates/ControllerForGetwayReposytory/index.php");
        $index = $this->replacePrimaryValues($index);
        
        $create = file_get_contents("templates/ControllerForGetwayReposytory/create.php");
        $create = $this->replacePrimaryValues($create);
         
        $store = file_get_contents("templates/ControllerForGetwayReposytory/store.php");
        $store = $this->replacePrimaryValues($store);
         
        $update = file_get_contents("templates/ControllerForGetwayReposytory/update.php");
        $update = $this->replacePrimaryValues($update);
         
        $destroy = file_get_contents("templates/ControllerForGetwayReposytory/destroy.php");
        $destroy = $this->replacePrimaryValues($destroy);
         
        $show = file_get_contents("templates/ControllerForGetwayReposytory/show.php");
        $show = $this->replacePrimaryValues($show);
        
        
     }
    public function makeController() {
        if ($this->useRequestForm == true) {
            $requ = ucfirst($this->controler_name) . "FormRequest";
            $header = "use App\Http\Requests\\" . $this->controler_name . "FormRequest;" . PHP_EOL;
        } else {
            $requ = "Request";
        }
        if ($this->setHasManyCount == true) {
            foreach ($this->hasMany as $has) {
                $header .= "use App\\" . substr($has['TABLE_NAME'], 0, -1) . ";" . PHP_EOL;
            }
        }
        if ($this->setHasManyCount == true) {
            foreach ($this->belongsTo as $has) {
                $header .= "use App\\" . substr($has['REFERENCED_TABLE_NAME'], 0, -1) . ";" . PHP_EOL;
            }
        }

        $checkBoxes = "";
        foreach ($this->tableAttributess as $value) {
            if ($value['specyfic_kolumn'] == "int(1)") {
                $checkBoxes .= "\$parametrs['{$value['COLUMN_NAME']}'] = isset(\$parametrs['{$value['COLUMN_NAME']}']) ? '1' : '0'; // checkbox - {$value['COLUMN_NAME']}" . PHP_EOL;
            }
        }

        $img_update_file = "";
        foreach ($this->tableAttributess as $value) {
            if ((isset($value['type'])) && ($value['type'] == 'img')) {
                $img_update_file .= " if (\$request->hasFile('{$value['COLUMN_NAME']}')) {
                    \$img_tmp =\$request->file('{$value['COLUMN_NAME']}')->store('img', 'public');
                    \$avatar_img_filename = \$request->file('{$value['COLUMN_NAME']}')->move(public_path('img/tmp'), \$img_tmp);
                    \$parametrs['{$value['COLUMN_NAME']}'] = \$avatar_img_filename->getFilename();
                }" . PHP_EOL;
            }
        }
        $this->controller_update_select2 = "";
        $with_foriegen_keys="";
        foreach ($this->tableAttributess as $value) {
            if ((isset($value['foriegen_field'])) && ($value['foriegen_field'] != "")) {
                $this->controller_update_select2 .= "\$". substr($value['foriegen_table'], 0, -1) ."=". substr(ucfirst($value['foriegen_table']), 0, -1) ."::find(\$" . strtolower($this->model_name) . "->" . $value['COLUMN_NAME'] . ");" . PHP_EOL;
                $with_foriegen_keys .="->with('".strtolower(substr($value['foriegen_table'], 0, -1))."',\$".strtolower(substr($value['foriegen_table'], 0, -1)).")";
            }
        }
        if(count($this->belongsTo)>0){
        $this->selects_tables="\$logowanias->select('{$this->table_name}.*'";
        $this->joins="";
        foreach ($this->tableAttributess as $value) {
            if ((isset($value['foriegen_field'])) && ($value['foriegen_field'] != "")) {
                $this->selects_tables .=",'{$value['foriegen_table']}.id as {$value['foriegen_table']}_id'";
                $this->joins .= "->join('{$value['foriegen_table']}','{$value['foriegen_table']}.{$value['foriegen_field']}','=','{$this->table_name}.{$value['COLUMN_NAME']}')".PHP_EOL;
                
            }
        }
         $this->selects_tables .= ")".PHP_EOL;
         $this->joins .= ";";
        }
        $controller = "<?php
" . PHP_EOL . "//" . date("F j, Y, g:i a") . "
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use App\ $this->model_name;
{$header};

class " . ucfirst($this->controler_name) . " extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request \$request)
    {
         " . $this->getControllerIndex() . "
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request \$request)
    {
        
           return view('{$this->viewFolder}.form_" . strtolower($this->controler_name) . "');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @return \Illuminate\Http\Response
     */
    public function store({$requ} \$request)
    {
    //nowe
          {$checkBoxes}
         " . $this->getController_Store() . "
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function show(\$id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function edit(\$id)
    {
        \$" . strtolower($this->model_name) . " = " . $this->model_name . "::find(\$id);            
          {$this->controller_update_select2}              
        // show the edit form and pass the shark
        return View('" . $this->viewFolder . ".form_" . strtolower($this->controler_name) . "')".PHP_EOL.
                   "->with('" . strtolower($this->model_name) . "', $" . strtolower($this->model_name) . ")
                   ->with('update',true)
            ".$with_foriegen_keys.";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  \$request
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function update({$requ} \$request, \$id)
    {
       \$parametrs = \$this->clearArray(\$request->all(), ['_token','_method']);  
      // \$parametrs[''] = isset(\$parametrs['']) ? '1' : '0'; // przygotowane dla checkboxow.
      {$checkBoxes}
         \$validated = \$request->validated();
         {$img_update_file}
        $this->model_name::where('id', \$id)->update(\$parametrs);
    return redirect('" . strtolower($this->controler_name) . "');
    }
    
public function ajaxField(Request \$request) {
       
        \$f = new PlayersFormRequest();
        \$validator = Validator::make([\$request->get(\"field\") => \$request->get(\"value\")], [\"{\$request->get(\"field\")}\" => \$f->my_rules[\$request->get(\"field\")]]);
        if (\$validator->fails()) {
            return response()->json([\"messages\" => \$validator->errors()->first(\$request->get(\"field\"))]);
        } else {
            return response()->json([\"messages\" => \"OK\"]);
        }
    }
    ".$this->getControllerGetOne()."
    ".$this->getControllerSelect2_ajax()."
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  \$id
     * @return \Illuminate\Http\Response
     */
    public function destroy(\$id)
    {
        DB::table('{$this->table_name}')->where('id', \$id)->delete();
        return redirect('" . strtolower($this->controler_name) . "');
    }
       private function clearArray(\$source = [], \$target = []) {

        foreach (\$target as \$value) {
            unset(\$source[\$value]);
}

        return \$source;
    }
}

";
        return $controller;
    }

    public function getPathController() {
        return $this->webPath . $this->controlersPath . $this->controler_name . '.php';
    }

    public function getNameRequests() {
        return $this->controler_name . 'FormRequest';
    }

    public function getPathRequestsFolder() {
        return $this->webPath . $this->requestsPath . $this->controler_name . 'FormRequest.php';
    }

    public function getPathModel() {
        return $this->webPath . $this->modelsPath . $this->model_name . '.php';
    }

    public function getPathWeb() {
        return $this->webPath . $this->routesPath;
    }

    public function getPathViewForm() {
        return $this->webPath . 'resources\\views\\' . $this->viewFolder . "\\form_" . strtolower($this->controler_name) . '.blade.php';
    }

    public function getPathViewTable() {
        return $this->webPath . 'resources\\views\\' . $this->viewFolder . "\\table_" . strtolower($this->controler_name) . '.blade.php';
    }

    public function getPathViewAjaxTable() {
        return $this->webPath . 'resources\\views\\' . $this->viewFolder . "\\ajax_table_" . strtolower($this->controler_name) . '.blade.php';
    }

    public function __toString() {
        return ("Projekt name: {$this->project_name}");
    }

    public function getControllerIndex() {
        $index = file_get_contents("templates/controllers/controller_index.php");
        $index = str_replace("<*<controller>*>", strtolower($this->controler_name), $index);
        $index = str_replace("<*<model>*>", $this->model_name, $index);
        $index = str_replace("<*<table>*>", $this->table_name, $index);
        $index = str_replace("<*<selects>*>", $this->selects_tables, $index);
        $index = str_replace("<*<joins>*>",  $this->joins, $index);
        
        $index = str_replace("<*<hasMany_Count>*>", $this->makeWithCount_HasMany() ?? "", $index);
        $index = str_replace("<*<hasMany>*>", $this->makeWith_HasMany() ?? "", $index);
        $index = str_replace("<*<belongsTo>*>", $this->makeWith_BelongsTo() ?? "", $index);

        return $index;
    }
    public function getControllerGetOne() {
        $index = file_get_contents("templates/controllers/controller_getOne.php");
//        $index = str_replace("<*<controller>*>", strtolower($this->conextroler_name), $index);
        return $index;
    }
    public function getControllerSelect2_ajax() {
        $index = file_get_contents("templates/controllers/controller_select2_ajax.php");
//        $index = str_replace("<*<controller>*>", strtolower($this->conextroler_name), $index);
        return $index;
    }

    public function getViewTable() {
        $index = file_get_contents("templates/views/tables/view_table.txt");
        $index = str_replace("<*<controller>*>", strtolower($this->controler_name), $index);
        $index = str_replace("<*<date_create>*>", date("F j, Y, g:i a"), $index);
        $index = str_replace("<*<viewfolder>*>", strtolower($this->viewFolder), $index);
        return $index;
    }

    public function getSearch_tr() {
        $tmp = "<tr class=\"search-tr\" >" . PHP_EOL;
        $input_template = file_get_contents("templates/views/tables/view_ajax_table_search-tr.php");
        foreach ($this->tableAttributessForHtmlTable as $ta) {
            
            if ($ta['DATA_TYPE'] == 'enum') {
                $viewTableSelect = file_get_contents("templates/views/tables/view_ajax_table_search-select.php");
                $input = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewTableSelect);
                $input = str_replace("<*<model>*>", strtolower($this->model_name), $input);
                $input = str_replace("<*<label>*>", $ta['label'] ?? $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                $input = str_replace("<*<class>*>", $this->attrInputData[$ta['DATA_TYPE']]['class'] . ' ' . $this->attrInputData[$ta['DATA_TYPE']]['add_class'], $input);
                $enums = explode(',', $ta['specyfic_kolumn']);
                // print_r($enums);
                $options = "";
                $viewTableOption = file_get_contents("templates/views/tables/view_ajax_table_search-options.php");
                foreach ($enums as $enum) {
                    $opt = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $viewTableOption);
                    $opt = str_replace("<*<option>*>", trim($enum, "'"), $opt);
                    $opt = str_replace("<*<model>*>", strtolower($this->model_name), $opt);
                    $opt = str_replace("<*<option_label>*>", trim($enum, "'"), $opt);
                    $options .= $opt . PHP_EOL;
                }
                $input = str_replace("<*<options>*>", $options, $input); //toDo Stworzyc do enum  funkcje. To samo jest w formularu
                $tmp .= $input;
            } else {
                $input = str_replace("<*<typ>*>", "text", $input_template);
                $input = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $input);
                $tmp .= $input;
            }
        }
        $tmp .= PHP_EOL . "</tr>";
        //file_put_contents("TEST.php", $tmp);
        return $tmp;
    }

    public function getOrder_tr() {
        $tmp = "<tr class=\"order-tr\" >" . PHP_EOL;
        $order_template = file_get_contents("templates/views/tables/view_ajax_table_order-tr.php");
        foreach ($this->tableAttributessForHtmlTable as $ta) {

            $order = str_replace("<span ><*<name>*></span>", " <span >" . ucfirst($ta['label'] ?? $ta['COLUMN_NAME']) . "</span>", $order_template);
            $order = str_replace("<*<name>*>", $ta['COLUMN_NAME'], $order);
            $tmp .= $order;
        }
        if ($this->setHasManyCount == true) {
            foreach ($this->hasMany as $has) {

                $order = str_replace("<span ><*<name>*></span>", " <span >" . ucfirst($has['TABLE_NAME']) . "_count" . "</span>", $order_template);
                $order = str_replace("<*<name>*>", $has['TABLE_NAME'] . "_count", $order);
                $tmp .= $order;
            }
        }
        $tmp .= PHP_EOL . "</tr>";
        //file_put_contents("TEST.php", $tmp);
        return $tmp;
    }

    public function getBody_tr() {

        $body_template = file_get_contents("templates/views/tables/view_ajax_table_body.php");
        $body = str_replace("<*<controller>*>", lcfirst($this->controler_name), $body_template);
        $body = str_replace("<*<model>*>", lcfirst($this->model_name), $body);
        $body = str_replace("<*<col_count>*>", count($this->tableAttributess), $body);
        $fields = "";
        foreach ($this->tableAttributessForHtmlTable as $ta) {
            if ((isset($ta['type'])) && ($ta['type'] == 'img')) {
                $fields .= "<td>
                            <img class='td-img' src=\"{{asset('img/tmp')}}/{{\$" . lcfirst($this->model_name) . "->" . $ta['COLUMN_NAME'] . "}}\"
                          </td>";
            } else {

                $fields .= "<td>{{" . "$" . lcfirst($this->model_name) . "->" . $ta['COLUMN_NAME'] . "}}</td>" . PHP_EOL;
            }
        }
        foreach ($this->hasMany as $has) {

            $fields .= "<td>{{" . "$" . lcfirst($this->model_name) . "->" . $has['TABLE_NAME'] . "_count" . "}}</td>" . PHP_EOL;
        }

        $body = str_replace("<*<fields>*>", $fields, $body);

        //ile_put_contents("TEST.php", $body);
        return $body;
    }

    public function getViewAjaxTable() {
        $viewAjax = file_get_contents("templates/views/tables/view_ajax_table.php");
        $viewAjax = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewAjax);
        $viewAjax = str_replace("<*<date_create>*>", date("F j, Y, g:i a"), $viewAjax);

        $search = $this->getSearch_tr();
        $order = $this->getOrder_tr();
        $body = $this->getBody_tr();
        $viewAjax = str_replace("<*<search-tr>*>", $search, $viewAjax);
        $viewAjax = str_replace("<*<order-tr>*>", $order, $viewAjax);
        $viewAjax = str_replace("<*<body>*>", $body, $viewAjax);
        return $viewAjax;
    }

    public function getController_Store() {
        $viewControllerStore = file_get_contents("templates/controllers/controller_store.php");
        $img_file_create = file_get_contents("templates/controllers/img_file_create.php");
        $viewControllerStore = str_replace("<*<controller>*>", strtolower($this->controler_name), $viewControllerStore);
        $viewControllerStore = str_replace("<*<model>*>", $this->model_name, $viewControllerStore);
        $viewControllerStore = str_replace("<*<valid>*>", $this->makeFormRequest(), $viewControllerStore);
        $img = "";
        foreach ($this->tableAttributess as $value) {

            if ((isset($value['type'])) && ($value['type'] == "img")) {
                $img .= str_replace("<*<name>*>", $value['COLUMN_NAME'], $img_file_create);
            }
        }
        $viewControllerStore = str_replace("<*<img_file_create>*>", $img, $viewControllerStore);
//        file_put_contents("TEST.php", $viewControllerStore);
        return $viewControllerStore;
    }

}
