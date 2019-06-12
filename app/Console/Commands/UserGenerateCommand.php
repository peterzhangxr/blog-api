<?php

namespace App\Console\Commands;

use App\Model\User;
use Illuminate\Console\Command;

class UserGenerateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user for blog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        $name = $this->ask('请输入你的用户名');
        $mobile = $this->askMobile('请输入您的手机号');
        $email = $this->askEmail('请输入您的邮箱');
        $password = $this->secret('请输入您的密码');

        $user = new User([
            'name' => $name,
            'mobile' => $mobile,
            'email' => $email,
            'password' => password_hash($password, PASSWORD_BCRYPT),
            'registered_at' => date('Y-m-d H:i:s')
        ]);

        $user->save();
        $this->info('创建成功');
    }

    /**
     * 校验手机号格式是否正确
     * @param string $question
     *
     * @return string
    */
    public function askMobile($question = '') {
        $mobile = $this->ask($question);
        if (!isValidTelephone($mobile)) {
            $mobile = $this->askMobile('手机号格式不正确，请输入正确的手机号');
        }

        return $mobile;
    }

    /**
     * 校验邮箱格式是否正确
     * @param string $question
     *
     * @return string
     */
    public function askEmail($question = '') {
        $email = $this->ask($question);
        if (!isValidEmail($email)) {
            $email = $this->askEmail('格式不正确，请输入正确的邮箱');
        }

        return $email;
    }
}
