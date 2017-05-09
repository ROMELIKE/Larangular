<?php

namespace App\Http\Controllers;

use App\Business\MemberObject;
use App\Http\Requests\MemberRequest;
use App\Model\MemberModel;
use Illuminate\Http\Request;
use File;

class MemberController extends Controller
{
    /**
     * Function: show form add (don't really necessary)
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getAdd()
    {
        return view('admin.user.add');
    }

    /**
     * Function: Add new member.
     *
     * @param MemberRequest $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postAdd(MemberRequest $request)
    {
        //check input request and filter to get data:

        $member = new MemberObject();
        $model = new MemberModel();
        $listMember = $model->getListMember()->result;
//        dd($listMember);

        if (isset($request->name) && $request->name != 'undefined') {
            $member->name = $request->name;
        }
        if (isset($request->email) && $request->email != 'undefined') {
            $member->email = $request->email;
        }
        if (isset($request->address) && $request->address != 'undefined') {
            $member->address = $request->address;
        }
        if (isset($request->age) && $request->age != 'undefined') {
            $member->age = $request->age;
        }
        if (isset($request->status) && $request->status != 'undefined') {
            $member->status = 1;
        }
        //Handle images:
        if (isset($request->avatar) && $request->avatar != 'undefined'
            && $request->avatar
        ) {

            //validate extension of upload image:
            $ext = $request->avatar->getMimeType();
            if (in_array($ext,
                ['image/jpeg', 'image/png', 'image/jpg', 'gif'])) {
                //validate capacity of upload image:
                if (!($request->avatar->getSize() > 10485760)) {
                    //get original name of picture.
                    $thumbnail = $request->avatar->getClientOriginalName();

                    //get the extension of picture.
                    $arrayImage = explode('.', $thumbnail);
                    $extension = end($arrayImage);

                    //get the only name of the picture.
                    $cutName = explode(".".$extension, $thumbnail);
                    $newName = time()."-".reset($cutName);

                    //create new picture.
                    $newThumbnail = $newName.".".$extension;

                    //move image to appropriate Folder:
                    $request->avatar->move('admin/images/avatars/',
                        $newThumbnail);

                    $member->avatar = $newThumbnail;
                } else {
                    return response()->json([
                        'level' => 'danger',
                        'message' => 'Image upload too large',
                        'listmember' => $listMember
                    ]);
                }
            } else {
                return response()->json([
                    'level' => 'danger',
                    'message' => 'Image upload not in correct form',
                    'listmember' => $listMember
                ]);
            }
        }
        $member->created_at = date('y-m-d H:i:s');


        //Handle Add member:
        $action = $model->addMember($member);
        if ($action->messageCode) {

            //reload new data list.
            $listMember = $model->getListMember()->result;

            return response()->json([
                'level' => 'success',
                'message' => $action->message,
                'listmember' => $listMember
            ]);

        } else {
            return response()->json([
                'level' => 'danger',
                'message' => $action->message,
                'listmember' => $listMember
            ]);
        }
    }

    /**
     * Function: get the infomation of member.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getEdit($id)
    {
        $model = new MemberModel();
        $action = $model->getMemberById($id);
        if ($action->messageCode) {
            $thisMember = $model->getMemberById($id)->result;

            return response()->json(['thisMember' => $thisMember]);
        } else {
            return response()->json([
                'level' => 'danger',
                'message' => $action->message
            ]);
        }
    }

    /**
     * Function: Update member
     *
     * @param MemberRequest $request
     * @param               $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function postEdit(MemberRequest $request, $id)
    {
        $model = new MemberModel();

        $member = new MemberObject();
        $thisMember = $model->getMemberById($id)->result;

        $action = $model->getListMember();
        $listMember = $action->result;

        if (isset($request->name) && $request->name
            && $request->name != 'undefined'
        ) {
            $member->name = $request->name;
        }
        if (isset($request->email) && $request->email
            && $request->email != 'undefined'
        ) {
            $member->email = $request->email;
        }
        if (isset($request->address) && $request->address
            && $request->address != 'undefined'
        ) {
            $member->address = $request->address;
        }
        if (isset($request->avatar) && $request->avatar != 'undefined'
            && $request->avatar
        ) {
            //validate extension of upload image:
            $ext = $request->avatar->getMimeType();
            if (in_array($ext,
                ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'])) {
                //validate capacity of upload image:
                if (!($request->avatar->getSize() > 10485760)) {
                    //get original name of picture.
                    $thumbnail = $request->avatar->getClientOriginalName();

                    //get the extension of picture.
                    $arrayImage = explode('.', $thumbnail);
                    $extension = end($arrayImage);
                    //get the only name of the picture.
                    $cutName = explode(".".$extension, $thumbnail);
                    $newName = time()."-".reset($cutName);
                    //create new picture.
                    $newThumbnail = $newName.".".$extension;

                    //move image to appropriate Folder:
                    $request->avatar->move('admin/images/avatars/',
                        $newThumbnail);

                    //delete current avatar if exist.
                    $thisMember = $model->getMemberById($id)->result;
                    $current_avatar = 'admin/images/avatars/'
                        .$thisMember->avatar;
                    if (File::exists($current_avatar)) {
                        File::delete($current_avatar);
                    }

                    $member->avatar = $newThumbnail;
                } else {
                    return response()->json([
                        'level' => 'danger',
                        'message' => 'Image upload too large',
                        'listmember' => $listMember
                    ]);
                }
            } else {
                return response()->json([
                    'level' => 'danger',
                    'message' => 'Image upload not in correct form',
                    'listmember' => $listMember
                ]);
            }

        } elseif ($request->avatar == $thisMember->avatar) {
            $member->avatar = $request->avatar;
        }
        if (isset($request->status) && $request->status) {
            $member->status = $request->status;
        }
        if (isset($request->age) && $request->age) {
            $member->age = $request->age;
        }
        $member->id = $id;
        $member->updated_at = date('y-m-d H:i:s');
        //-------------------------------------------------//

        //Handle to update member:
        $action = $model->updateMember($member);
        if ($action->messageCode) {
            $newListMember = $model->getListMember()->result;
            return response()->json([
                'level' => 'success',
                'message' => $action->message,
                'listmember' => $newListMember
            ]);
        } else {
            return response()->json([
                'level' => 'danger',
                'message' => $action->message,
                'listmember' => $listMember
            ]);
        }
    }

    /**
     * Function: get the member list.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getList()
    {
        $model = new MemberModel();
        $action = $model->getListMember();
        $listMember = $action->result;
        $by = $action->info;

        return response()->json(['members' => $listMember]);
    }

    /**
     * Function: delete a member.
     *
     * @param $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDelete($id)
    {

        $model = new MemberModel();
        //check id:
        $action = $model->getMemberById($id);
        if ($action->messageCode) {
            //delete member in Db + avatar in server:
            $thisUser = $action->result;
            if ($thisUser->avatar) {
                $thumbnail = "admin/images/avatars/"
                    .$thisUser->avatar;
                if (File::exists($thumbnail)) {
                    File::delete($thumbnail);
                }
            }
            //delete in DB:
            $delete = $model->deleteMember($id);
            if ($delete->messageCode) {
                $level = 'success';
                $message = $delete->message;
            } else {
                $level = 'danger';
                $message = $delete->message;
            }
        } else {
            $level = 'danger';
            $message = $action->message;
        }

        //get the new list member:
        $model = new MemberModel();
        $listMember = $model->getListMember()->result;

        return response()->json([
            'level' => $level,
            'message' => $message,
            'listmember' => $listMember
        ]);
    }
    /**************************************************************************/
    /*************************       ENDFILE         **************************/
    /**************************************************************************/

}
