<?php

namespace App\Http\Providers;

use App\Http\Models\ScriptData;//教師填寫的資料
use App\Http\Models\ScriptAdminData;//管理員填寫的資料
use \Input;

class ScriptClass
{
    private $input_data = array(
        'id' => null,
        'uid' => null,
        'unlock' => null,
        'lock' => null,
    );

    private $result_msg = array(
        'message' => 'success',
    );

    private $result_data = array(
        'teacher' => array(),
        'admin' => array(),
    );

    public function init($data = array())
    {
        foreach ($data as $key => $value) {
            $this->input_data[$key] = $value;
        }
    }

    /**
     * 根據item_key回傳資料(包含教師填寫的資料跟管理員填寫的資料)
     *
     * @param array $insert_data 要新增的資料
     */
    public function getScriptData($user_id,$item_key)
    {
        $data = array(
            'ta' => array(),
            'ad' => array(),
        );
        //教師寫的資料
         $t = ScriptData::where('user_id', $user_id)
            ->where('item_key', $item_key)
            ->select(
                'user_id',
                'item_key',
                'dsc'
            )
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        foreach ($t as $v){
            $this->result_data['teacher'] = $v;
        }
        //管理員寫的資料
        $t = ScriptAdminData::where('user_id', $user_id)
            ->where('item_key', $item_key)
            ->select(
                'user_id',
                'item_key',
                'dsc'
            )
            ->orderBy('id','desc')
            ->limit(1)
            ->get();
        foreach ($t as $v){
            $this->result_data['admin'] = $v;
        }
        $this -> result_msg['item_key'] = $item_key;
        $this -> result_msg['script_data'] = $this->result_data;

        return $this->result_msg;
    }

    /**
     * 新增一筆 教師填寫的資料
     *
     * @param array $insert_data 要新增的資料
     */
    public function scriptAdd($insert_data)
    {
        $temp_obj = new ScriptData();
        foreach ($insert_data as $key => $value){
            $temp_obj->$key = $value;
        }
        $temp_obj->save();
        $this -> result_msg['item_key'] = $insert_data['item_key'];

        return $this->result_msg;
    }

    /**
     * 新增一筆 管理員填寫的資料
     *
     * @param array $insert_data 要新增的資料
     */
    public function scriptAdminAdd($insert_data)
    {
        $temp_obj = new ScriptAdminData();
        foreach ($insert_data as $key => $value){
            $temp_obj->$key = $value;
        }
        $temp_obj->save();
        $this -> result_msg['item_key'] = $insert_data['item_key'];

        return $this->result_msg;
    }

    /**
     * 回傳有填寫資料的教師資料
     *
     */
    public function teacher_list()
    {
        $t_obj = array(
            'teacher_data' => array(),
            'page_data' => '',
        );
        $temp_obj =
            ScriptData::select('user_info.user_id', 'user_info.uid', 'user_info.uname')
            ->leftJoin('user_info', 'user_info.uid', '=', 'script_data.uid')
            ->leftJoin('user_status', 'user_status.user_id', '=', 'user_info.user_id')
            ->whereIn('user_status.access_level', array('21','22','23'))
            ->groupBy('script_data.ui')
            ->orderBy('user_info.uname')
            ->paginate(20);
        foreach ($temp_obj as $v)
        {
            $t_obj['teacher_data'][] = $v->toArray();
        }
        if(count($temp_obj) > 0)
        {
            $t_obj['page_data'] = $temp_obj -> links();
        }

        return $t_obj;
    }
}
