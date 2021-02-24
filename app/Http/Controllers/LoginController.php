<?php 

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;
use Exception;
use App\Http\Controllers\CommonController;
use App\Models\Login\LoginModel;
use App\Models\Order\OrderModel;
class LoginController extends CommonController {

    function __construct() {
    }

    public function index() {
        return View::make('login/login');
    }

    /**
     * This methos is used to check the session is expired or not
     */
    public function sessionExpired($val) {
        if ($val == "se") {
            $this->data['error_message'] = "You session has expired!";
           // return back()->with('error', 'You session has expired!');
            return View::make('login/login',$this->data);
        } else
            return view('login.login');
    }
   /* public function index() {
        return View::make('dashboard/dashboard');
    }*/
    /**
     * This method is used to make Login to the user application
     */
    public function makeLogin(Request $request)
    {
        try {
            $orderModel = new OrderModel();
            
            $count = OrderModel::count();
            $this->data['count'] = $count;

            $loginModel =  new LoginModel();
            $userName = $request->input('username');
            $password =  md5($request->input('password'));
            Log::info("password==>" . $password);
            $userInfo = $loginModel->authenticateUser($userName, $password);
            Log::info("userInfoCont==>" . json_encode($userInfo));
            if (sizeof($userInfo) > 0) {
                $user = $userInfo[0];
                Session::put('user', $user);
                Session::put('loggedInUserId', $user->id);
                Session::put('loggedInUserRole', $user->role_id);
                Session::put('userFullName', $user->first_name . ' ' . $user->last_name);
                if ($user->role_id == 1) {
                    Log::info("In succes role1 if");
                    return redirect('/dashboard');
                } else if ($user->role_id == 2) {
                    return redirect('/dashboard');
                } else if ($user->role_id == 3) {
                    return redirect('/dashboard');
                }else if ($user->role_id == 4) {
                    return redirect('/dashboard');
                }else if ($user->role_id == 5) {
                    return redirect('/dashboard');
                }else if ($user->role_id == 6) {
                    return redirect('/dashboard');
                }else if ($user->role_id == 7) {
                    return redirect('/dashboard');
                }
            } else {
                //$this->data['error_message'] = "Invalid Username or Password!";
                return back()->with('error', 'Invalid Username or Password!');
                log::info("errorMsg==>" . $this->data['error_message']);
                //return view("login.login", $this->data);
            }
        } catch (Exception $e) {
            Log::info("Something went wrong...! Exception Message: " . $e->getMessage());
            //$this->data['exception_message'] = "Something went wrong...";
            return back()->with('error', 'Something went wrong...');
            Log::error($e);
        }
    }

    /**
     * This method is used to expire the session and logout
     */
    public function logout()
    {
        Session::flush();
        return redirect('/');
    }

}