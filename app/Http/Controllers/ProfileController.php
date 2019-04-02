<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\UpdatePasswordRequest;

use App\User;

class ProfileController extends Controller
{

	protected $user_profile_picture = NULL;
    protected $user_profile_picture_to_delete = '';

    public function index()
    {
    	$user = User::findOrFail(\Auth::user()->id);
        //lock cheking
        $checker = \DB::table('lock_configurations')->select('user_id')
                ->where('facility_name', '=', 'create_internal_request')
                ->where('user_id','=', $user->id)
                ->get();
        $lock_create_internal_request = count($checker);
        return view('my-profile.index')
            ->with('lock_create_internal_request', $lock_create_internal_request)
            ->with('user', $user);
    }

    public function edit()
    {
    	$user = User::findOrFail(\Auth::user()->id);

    	return view('my-profile.edit')
    		->with('user', $user);
    }


    public function update(Request $request, $id)
    {
    	$user = User::findOrFail($id);

        if($request->hasFile('image')){
            //if there is an uploaded image, fire the upload process,set the new profile picture name
            // and collect this profile picture name (to be deleted from the server).
            $this->upload_process($request);
            $this->user_profile_picture_to_delete = $user->profile_picture;
        }
        else{
            //no image uploaded, it means the profile picture name stays still
            $this->user_profile_picture = $user->profile_picture;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        /*$user->nik = $request->number_id;
        $user->salary = floatval(preg_replace('#[^0-9.]#', '', $request->salary));*/
        $user->profile_picture = $this->user_profile_picture;
        $user->save();


        //delete old user profile and it's thumbnail from the server if any
        \File::delete(public_path().'/img/user/'.$this->user_profile_picture_to_delete);
        \File::delete(public_path().'/img/user/thumb_'.$this->user_profile_picture_to_delete);

        return redirect('my-profile/edit')
            ->with('successMessage', "Your profile has been updated");
    }

    //Image upload handling process
    protected function upload_process(Request $request){
        $upload_directory = public_path().'/img/user/';
        $extension = $request->file('image')->getClientOriginalExtension();
        $profile_picture_to_be_inserted = time().'.'.$extension;
        $this->user_profile_picture = $profile_picture_to_be_inserted;
        $save_image = \Image::make($request->image)->save($upload_directory.$profile_picture_to_be_inserted);
        //make the thumbnail
        $thumbnail = \Image::make($request->image)->resize(171,180)->save($upload_directory.'thumb_'.$this->user_profile_picture);
        //free the memory
        $save_image->destroy();

    }
    //ENDImage upload handling process



    public function updatePassword(UpdatePasswordRequest $request)
    {
        $user = User::findOrFail(\Auth::user()->id);
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->back()
            ->with('successMessage', 'Your password has been changed');
    }

}
