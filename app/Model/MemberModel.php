<?php

namespace App\Model;

use App\Business\ResultObject;
use Illuminate\Database\Eloquent\Model;
use DB;

class MemberModel extends Model
{
    protected $table = 'member';
    protected $fillable
        = [
            'name',
            'address',
            'age',
            'avatar',
            'created_at',
            'update_at',
            'email',
            'status'
        ];

    /**
     * Function: get List of members.
     *
     * @param string $orderBy
     * @param string $by
     *
     * @return ResultObject
     */
    public function getListMember($orderBy = 'created_at', $by = 'DESC')
    {
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->orderBy($orderBy, $by)->get()
                ->toArray();
            if ($sql) {
                $result->message = 'get member list successfully';
                $result->messageCode = 1;
                $result->result = $sql;
                $result->info = $by;
            } else {
                $result->message = 'get member list failure';
                $result->messageCode = 0;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }

    /**
     * Function: add new member.
     *
     * @param $member
     *
     * @return ResultObject
     */
    public function addMember($member)
    {
        $param = [];
        if ($member->name) {
            $param['name'] = $member->name;
        } elseif ($member->name == 0) {
            $param['name'] = '0';
        } else {
            $param['name'] = '';
        }
        if ($member->address) {
            $param['address'] = $member->address;
        } elseif ($member->address == 0) {
            $param['address'] = '0';
        } else {
            $param['address'] = null;
        }
        if ($member->age) {
            $param['age'] = $member->age;
        } else {
            $param['age'] = null;
        }
        if ($member->avatar) {
            $param['avatar'] = $member->avatar;
        } else {
            $param['avatar'] = '';
        }
        if ($member->email) {
            $param['email'] = $member->email;
        } else {
            $param['email'] = null;
        }
        if ($member->status) {
            $param['status'] = 1;
        } else {
            $param['status'] = 0;
        }
        if ($member->created_at) {
            $param['created_at'] = $member->created_at;
        } else {
            $param['created_at'] = null;
        }
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->insertGetId($param);
            if ($sql) {
                $result->message = 'insert new member successfully';
                $result->messageCode = 1;
                $result->result = $sql;
            } else {
                $result->message = 'insert member failure';
                $result->messageCode = 0;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }

    /**
     * Function: Update member:
     *
     * @param $member
     *
     * @return ResultObject
     */
    public function updateMember($member)
    {
        $param = [];
        if ($member->name) {
            $param['name'] = $member->name;
        }elseif ($member->name == 0) {
            $param['name'] = '0';
        }
        if ($member->address) {
            $param['address'] = $member->address;
        }elseif ($member->address == 0) {
            $param['address'] = '0';
        }
        if ($member->age) {
            $param['age'] = $member->age;
        }
        if ($member->avatar) {
            $param['avatar'] = $member->avatar;
        }
        if ($member->email) {
            $param['email'] = $member->email;
        } else {
            $param['email'] = null;
        }
        if ($member->status) {
            $param['status'] = 1;
        }
        if ($member->updated_at) {
            $param['updated_at'] = $member->updated_at;
        }
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->where('id', $member->id)
                ->update($param);
            if ($sql) {
                $result->message = 'update new member successfully';
                $result->messageCode = 1;
                $result->result = $sql;
            } else {
                $result->message = 'update member failure';
                $result->messageCode = 0;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }

    /**
     * Function: Delete member:
     *
     * @param $id
     *
     * @return ResultObject
     */
    public function deleteMember($id)
    {
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->where('id', $id)
                ->delete();
            if ($sql) {
                $result->message = 'delete member successfully';
                $result->messageCode = 1;
                $result->result = $sql;
            } else {
                $result->message = 'delete member failure';
                $result->messageCode = 0;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }

    /**
     * Function: get member by ID
     *
     * @param $id
     *
     * @return ResultObject
     */
    public function getMemberById($id)
    {
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->where('id', $id)->first();
            if ($sql) {
                $result->message = 'get this member successfully';
                $result->messageCode = 1;
                $result->result = $sql;
            } else {
                $result->message = 'Can not find any member like this';
                $result->messageCode = 0;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }

    /**
     * Function: check name exist or not (if set 'name'=>unique)
     *
     * @param $name
     *
     * @return ResultObject
     */
    public function checkNameExist($name)
    {
        $result = new ResultObject();
        try {
            $sql = DB::table($this->table)->where('name', $name)->get()
                ->toArray();
            if ($sql) {
                $result->message = 'this name have been used';
                $result->messageCode = 0;
                $result->result = $sql;
            } else {
                $result->message = 'this name is ready';
                $result->messageCode = 1;
                $result->result = $sql;
            }
        } catch (\Exception $exception) {
            $result->message = $exception->getMessage();
            $result->messageCode = 0;
        }

        return $result;
    }
    /**************************************************************************/
    /*************************       ENDFILE         **************************/
    /**************************************************************************/
}
