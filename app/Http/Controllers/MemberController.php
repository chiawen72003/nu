<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \Input;
use \Validator;
use \Session;
use \DB;
use \Response;
use App\Http\Providers\MemberClass;
use App\Http\Providers\MemberAdminClass;

class MemberController extends Controller
{
    public function __construct()
    {
        // $this->middleware('guest');
    }

    public function LoginPage()
    {
        $data = array();

        return view('login.login', $data);
    }

    public function LoginChk()
    {
        $fp = Input::all();
        $member_class_obj = new MemberClass();
        $member_class_obj -> init($fp);
        $check_data = $member_class_obj -> chk_login_data();
        if ($check_data['check_result']) {
            $user_data = $check_data['user_data'];
            session(['user_data' => $user_data]);
            session(['user_type' => 'admin']);
            //判斷身份別 學生
            if(in_array($user_data['access_level'],array(1,2,3,8,9)))
            {
                session(['user_type' => 'student']);

                return redirect()->route('mem.index');
            }
            //判斷身份別 教師
            if(in_array($user_data['access_level'],array(21,22,23,31)))
            {
                session(['user_type' => 'teacher']);

                return redirect()->route('ta.examrecord.list.page');
            }

            //管理員
            return redirect()->route('ad.news.list');
        }

        return redirect()->back()->with('error', ['your message,here']);
    }

    /**
     * 使用者登出
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function LogOut()
    {
        app('request')->session()->flush();

        return redirect()->route('mem.loginpg');
    }

    /**
     * 管理員列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminList()
    {
        $member_admin_obj = new MemberAdminClass();
        $data = array();
        $data['user_data'] = app('request')->session()->get('user_data');
        $data['list_data'] = $member_admin_obj -> get_list();

        return view('admin.admin_list', $data);
    }

    /**
     * 新增一筆管理員的資料
     *
     */
    public function adminAdd()
    {
        $fp = Input::all();
        $member_admin_obj = new MemberAdminClass();
        $member_admin_obj ->init($fp);
        $member_admin_obj -> add();

        return '';
    }

    /**
     * 更新一筆管理員的資料
     *
     */
    public function adminUpdate()
    {
        $fp = Input::all();
        $member_admin_obj = new MemberAdminClass();
        $member_admin_obj -> init($fp);
        $member_admin_obj -> update_data();

        return '';
    }

    /**
     * 移除一個管理員
     *
     */
    public function adminDelete()
    {
        $fp = Input::all();
        $member_admin_obj = new MemberAdminClass();
        $member_admin_obj ->init($fp);
        $member_admin_obj -> delete_data();

        return;
    }

}
