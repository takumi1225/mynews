<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Profile;

class ProfileController extends Controller
{
    public function add()
    {
    return view('admin.profile.create');
    }

public function create(Request $request)
    {
        $this->validate($request, Profile::$rules);

      $profile = new Profile;
      $form = $request->all();

      // フォームから送信されてきた_tokenを削除する
      unset($form['_token']);
      
      // データベースに保存する
      $profile->fill($form);
      $profile->save();

      return redirect('admin/profile/create');
    }

public function edit(Request $request)
    {
      $profile = Profile::find($request->id);
      if (empty($profile)) {
        abort(404);    
      }
    return view('admin.profile.edit',['profile_form' => $profile]);
    } 

public function update(Request $request)
    {
    // Validationをかける
    $this->validate($request, Profile::$rules);
    // Profile Modelからデータを取得する
    $profile = Profile::find($request->id);
    // 送信されてきたフォームデータを格納する
    $profile_form = $request->all();
    if (isset($profile_form['image'])) {
      $path = $request->file('image')->store('public/image');
      $profile->image_path = basename($path);
      unset($profile_form['image']);
    } elseif (0 == strcmp($request->remove, 'true')) {
      $profile->image_path = null;
    }
    unset($profile_form['_token']);
    unset($profile_form['remove']);

    // 該当するデータを上書きして保存する
    $profile->fill($profile_form)->save();
    }

   
}
