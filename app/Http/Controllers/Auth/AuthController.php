<?php namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\Registrar;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;

use Illuminate\Http\Request;
use App\Events\UserLoggedIn;
use Response;

class AuthController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Registration & Login Controller
	|--------------------------------------------------------------------------
	|
	| This controller handles the registration of new users, as well as the
	| authentication of existing users. By default, this controller uses
	| a simple trait to add these behaviors. Why don't you explore it?
	|
	*/

	use AuthenticatesAndRegistersUsers;

	/**
	 * Create a new authentication controller instance.
	 *
	 * @param  \Illuminate\Contracts\Auth\Guard  $auth
	 * @param  \Illuminate\Contracts\Auth\Registrar  $registrar
	 * @return void
	 */
	public function __construct(Guard $auth, Registrar $registrar)
	{
		$this->auth = $auth;
		$this->registrar = $registrar;

		$this->middleware('guest', ['except' => 'getLogout']);
	}

    /**
     * 验证email
     *
     * @param $email
     * @return bool
     */
    public function checkEmail(Request $request)
    {
        $checkEmail = false;

        if($request->ajax()){
            $checkEmail = $this->registrar->checkEmail($request->all());
        }

        return Response::json($checkEmail);
    }

    /**
     * ----------------------------------------
     * 会员登录页面,管理员登陆页面
     * ----------------------------------------
     * 
     */
    public function getAdminLogin()
	{
		return view('admin.login');
	}

    /**
     * ----------------------------------------
     * 会员登录,管理员登陆
     * ----------------------------------------
     */
    public function postLogin(Request $request)
	{
		$this->validate($request, [
			'email' => 'required|email', 'password' => 'required',
		]);

		$credentials = $request->only('email', 'password');

		if ($this->auth->attempt($credentials, $request->has('remember')))
		{
            //$user = \Auth::user();
            event(new UserLoggedIn(user('object')));  //触发登录事件
			return redirect()->intended($this->redirectPath());
		}

		return redirect($this->loginPath())
					->withInput($request->only('email', 'remember'))
					->withErrors([
						'email' => $this->getFailedLoginMessage(),
					]);
    }

}
