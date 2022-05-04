if ($request->hasFile('<*<name>*>')) {
            $img_tmp = $request->file('<*<name>*>')->store('img', 'public');
            $avatar_img_filename = $request->file('<*<name>*>')->move(public_path("img/tmp"), $img_tmp);
            $parametrs['<*<name>*>'] = $avatar_img_filename->getFilename();
         }