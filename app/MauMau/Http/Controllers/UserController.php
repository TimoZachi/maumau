<?php
namespace MauMau\Http\Controllers;

use Auth;
use Config;
use Illuminate\Http\Request;
use Image;
use MauMau\Models\User;

class UserController extends Controller
{
    /**
     * Show the form for editing the logged in user.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        $user = null;
        if(Auth::check()) $user = Auth::user();

        if(!empty($user->avatar))
        {
            $upload_path = Config::get('app.image_upload_path') . 'avatars' . DIRECTORY_SEPARATOR;

            $user->avatar = Image::make($upload_path . $user->avatar);
        }

        $id = $user->id;

        return view('users.edit', compact(['id', 'user']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        $id = $user->id;

        $this->validate($request, [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $id,
            'avatar' => 'image'
        ]);

        $input = $request->all();
        unset($input['password']);

        if(!empty($input['avatar']))
        {
            $image = $input['avatar'];
            $upload_path = Config::get('app.image_upload_path') . 'avatars' . DIRECTORY_SEPARATOR;
            do {
                $image_name = str_random(8) . '.' . $image->getClientOriginalExtension();
            } while(file_exists($upload_path . $image_name));
            $input['avatar'] = $image_name;
            $image->move($upload_path, $image_name);

	        if(!empty($user['avatar']) && file_exists($upload_path . $user['avatar']))
	        {
		        unlink($upload_path . $user['avatar']);
	        }

	        $full_path = $upload_path . $image_name;
	        Image::make($full_path)->fit(120, 150)->save($full_path);
        }
        else unset($input['image']);

        $success = $user->update($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Perfil atualizado com sucesso',
            'user' => $user->toArray()
        ]);
    }
}