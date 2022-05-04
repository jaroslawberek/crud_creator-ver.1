$request->validate([
'login'=>'required|min:1|max:30',
'wzrost'=>'required|numeric',
'canLogin'=>'|numeric',
'born'=>'required|date',
'sex'=>'required|in:m,k',
'position'=>'|in:b,o,p,n',
],['login.required'=>'Nie podano :attribute',
'login.min'=>'Za krótki :attribute. Podaj maksymalnie :min znaków',
'login.max'=>'Za długi :attribute. Podaj maksymalnie :max znaków',
'wzrost.required'=>'Nie podano :attribute',
'born.required'=>'Nie podano :attribute',
'born.date'=>'Nie prawidłowa data w  :attribute',
'sex.required'=>'Nie podano :attribute',
'sex.in'=>'Nie prawidłow0 w  :attribute',
'position.in'=>'Nie prawidłow0 w  :attribute',
]);

 Player::create($parametrs);     
        return redirect('players');