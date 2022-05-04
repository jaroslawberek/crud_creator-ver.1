<?php
echo phpinfo();
//die();
include 'classes/CrudCreator.php';

try {
    $crud = new CrudCreator("laravel-test", "frontend");
    $crud->setCrud("Categories", "Category", "Categories", "testowa");
    $crud->setTableAttributes(['id', 'created_at', 'updated_at', 'del']); //najpierw zrobic $crud->generate(); a ww nim ustawienie not in
    $crud->setColumnsForTable(['name', 'type_category']);
    $crud->useRequestForm = true;
    $crud->setHasManyCount = true; // czy ma wstawic ->withCount() i with dla HasMany
    
    // $crud->createCrudAllTables("testowa");
    //$crud->createCrudForTable("testowa", "categories");

   /* echo "makeController...<br>";
    file_put_contents($crud->getPathController(), $crud->makeControllerForGetwayReposytory());
    
    
    */
   /* echo "makeController...<br>";
    file_put_contents($crud->getPathController(), $crud->makeController());
    
    echo "makeModel...<br>";
    file_put_contents($crud->getPathModel(), $crud->makeModel());

    echo "makeWebRoute...<br>";
    file_put_contents($crud->getPathWeb(), $crud->makeWebRoute(),FILE_APPEND);
   
    echo "makeModel...<br>";
    file_put_contents($crud->getPathModel(), $crud->makeModel());

     echo "makeViewTable...<br>";
    file_put_contents($crud->getPathViewTable(), $crud->makeViewTable());
    
    echo "makeViewAjaxTable...<br>"; //   
    file_put_contents($crud->getPathViewAjaxTable(), $crud->getViewAjaxTable());
//    
    echo "makeViewForm...<br>"; //
    file_put_contents($crud->getPathViewForm(),$crud->makeViewForm());
    */
//    //echo "<pre>" . print_r($crud->tableAttributess, true) . "</pre>";
////    echo "hasMany"."<br>";
////    echo "<pre>" . print_r($crud->hasMany, true) . "</pre>";
////    echo "belongsTo"."<br>";
////    echo "<pre>" . print_r($crud->belongsTo, true) . "</pre>";
////    echo"<br>";
//    
////    echo "makeController...<br>";
////    file_put_contents($crud->getPathController(), $crud->makeController());
//////    echo $crud->makeHasManyFunctions();
//
////    echo($crud->getPathViewTable())."<br>";
////    file_put_contents($crud->getPathViewAjaxTable(), $crud->getViewAjaxTable());
//////    file_put_contents($crud->getPathViewAjaxTable(), $crud->getViewAjaxTable());
//  //  $crud->makeWebRoute();
    echo "Zakonczono.";
} catch (Exception $ex) {
    print_r($ex);
}

//echo "<br><br><br><br><br><br>";
//echo($crud->getPathController())."<br>";
//echo($crud->getPathWeb())."<br>";
//echo($crud->getPathViewForm())."<br>";

//  $crud->getSearch_tr();
  //  $crud->getOrder_tr();
    //$crud->getBody_tr(); 
//    echo "getController_Store...<br>";
//    $crud->getController_Store();