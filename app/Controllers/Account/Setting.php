<?php

namespace App\Controllers\Account;

use App\Controllers\BaseController;
use CodeIgniter\I18n\Time;

class Setting extends BaseController
{
    public function index()
    {
        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - Settings';
        return view('account/settings', $data);
    }

    public function showAllActivityLog()
    {
        $ActivitylogModel = new \App\Models\ActivitylogModel();

        if ($this->request->getGet('keyword')) {
            $keyword = $this->request->getGet('keyword');

            $data['activitylogs'] = $ActivitylogModel->select('log, created_at')->where('id_users', session()->get('id'))->like('log', $keyword)->orderBy('created_at', 'desc')->paginate(10, 'activitylogs');
            $data['activitylogs_count'] = $ActivitylogModel->where('id_users', session()->get('id'))->like('log', $keyword)->countAllResults();
        } else {
            $data['activitylogs'] = $ActivitylogModel->select('log, created_at')->where('id_users', session()->get('id'))->orderBy('created_at', 'desc')->paginate(10, 'activitylogs');
            $data['activitylogs_count'] = $ActivitylogModel->where('id_users', session()->get('id'))->countAllResults();
        }

        // Memanusiakan created_at
        for ($i = 0; $i < count($data['activitylogs']); $i++) {
            $data['activitylogs'][$i]['created_at'] = Time::parse($data['activitylogs'][$i]['created_at'])->humanize();
        }
        $data['pager'] = $ActivitylogModel->pager;
        $data['current_page'] = $this->request->getGet('page_activitylogs') ? $this->request->getGet('page_activitylogs') : 1;

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - ' . $data['me']['username'] . ' Activity Log';
        return view('account/activity-log', $data);
    }

    public function showAllLoginLog()
    {
        $LoginlogModel = new \App\Models\LoginlogModel();

        if ($this->request->getGet('keyword')) {
            $keyword = $this->request->getGet('keyword');

            $data['loginlogs'] = $LoginlogModel->select('ip, browser, platform, created_at')->where('id_users', session()->get('id'))->like('ip', $keyword)->orLike('browser', $keyword)->orLike('platform', $keyword)->orderBy('created_at', 'desc')->paginate(10, 'loginlogs');
            $data['loginlogs_count'] = $LoginlogModel->where('id_users', session()->get('id'))->like('ip', $keyword)->orLike('browser', $keyword)->orLike('platform', $keyword)->orderBy('created_at', 'desc')->countAllResults();
        } else {
            $data['loginlogs'] = $LoginlogModel->select('ip, browser, platform, created_at')->where('id_users', session()->get('id'))->orderBy('created_at', 'desc')->paginate(10, 'loginlogs');
            $data['loginlogs_count'] = $LoginlogModel->where('id_users', session()->get('id'))->countAllResults();
        }

        // Memanusiakan created_at
        for ($i = 0; $i < count($data['loginlogs']); $i++) {
            $data['loginlogs'][$i]['created_at'] = Time::parse($data['loginlogs'][$i]['created_at'])->humanize();
        }
        $data['pager'] = $LoginlogModel->pager;
        $data['current_page'] = $this->request->getGet('page_loginlogs') ? $this->request->getGet('page_loginlogs') : 1;

        $data['me'] = $this->UserModel->select('username, slug, avatar, role, email_verified_at')->find(session()->get('id'));
        $data['title'] = APP_NAME . ' - ' . $data['me']['username'] . ' Login Log';
        return view('account/login-log', $data);
    }
}
