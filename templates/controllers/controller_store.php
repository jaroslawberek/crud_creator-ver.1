$parametrs = $request->all();
//      $parametrs[''] = isset($parametrs[''])? '1':'0'; // przygotowane dla checkboxow.
<*<valid>*>
<*<img_file_create>*>
 <*<model>*>::create($parametrs);     
        return redirect('<*<controller>*>')->with('update', false);