  $("document").ready(function(){      
        addSelect2("<*<model>*>_<*<name>*>",                                                                         //  ID selecta
                    "/<*<controller>*>/getOne",                                                                           //  funkcja do szukania pojedynczego rekordu (do szablonów)
                    "/<*<controller>*>/select2_ajax",                                                                     //  funkcja do wyszukiwania
                    "<*<search>*>",                                                                                         //  po jakim polu ma szukac
                    "<div><span><img class='avatar' style='width: 30px' ></span><span class='<*<search>*>'></span></div>",   //  szablon na liscie
                    "<div><span></span><span style='color:red' class='<*<search>*>'></span></div>");                         //     szablon w kontrolce select
  });