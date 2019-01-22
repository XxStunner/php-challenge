<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Models\User;
use App\Models\Plan;
use App\Models\User_\Payment;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    /**
     * Verify if the email exists on the database.
     * @return bool - True if email exists.
     */
    public function checkEmail(Request $request) {
        $email = $request->query('email');
        $return = $email ? [
            'status' => 'success',
            'found' => User::where('email', $email)->count() > 0
        ] : [
            'status' => 'failure',
            'message' => 'Parametro email nao encontrado'
        ];
        return response($return, $email ? 200 : 400);
    }
    /**
     * Return all plans in the database.
     * @return array - A array of plans.
     */
    public function plans(Request $request) {
        return response([
            'status' => 'success',
            'items' => PLan::all()
        ]);
    }
    /**
     * Return all payments in the database.
     * @return array Return a array of Payment objects.
     */
    public function payments(Request $request) {
        return response([
            'status' => 'success',
            'items' => Payment::all()
        ]);
    }

    public function paymentById(Request $request, Payment $payment) {
        return response([
            'status' => 'success',
            'item' => $payment
        ]);
    }
    /**
     * Return all payments that belongs to the user.
     * @return array Return a array of Payment objects.
     */
    public function paymentsByUser(Request $request, User $user) {
        return response([
            'status' => 'success',
            'items' => $user->payments()->get()
        ]);
    }
    /**
     * Parse the request body and verify if the information is valid, if so, insert the user on the database.
     * @return bool - Return a indication of the action.
     */
    public function register(Request $request) {
        /**
         * Valdiate fields.
         */
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users',
            'doc'=> 'required|max:11',
            'address_street' => 'required|max:255',
            'address_complement' => 'max:255',
            'address_neighborhood' => 'required|max:255',
            'address_city' => 'required|max:255',
            'address_state' => 'required|max:255',
        ]);
        /**
         * The default response.
         */
        $response = [
            'created' => true,
            'message' => 'Criado com sucesso!',
        ];
        /**
         * Check if user has send atleast one phone.
         */
        $phonesTotal = count($request->phones);
        if($phonesTotal > 0) {
            $user_id = User::createWithPhones($request->json()->all());
            $response['user_id'] = $user_id;
        } else {
            $response = [
                'created' => false,
                'message' => 'Envie pelo menos um número de telefone'
            ];
        }

        return response($response, $phonesTotal > 0 ? 200 : 400);
    }
    /**
     * Process the payment.
     * @return bool Return a indication of the action.
     */
    public function charge(Request $request) {
        $cards = [
            '2672872851579012 123' => true,
            '7339526258668625 555' => false,
            '5122245908042818 321' => boolval(rand(0, 1))
        ];
        /**
         * Validate all fields.
         */
        $validatedData = $request->validate([
            'user_id' => 'required|integer',
            'plan_id' => 'required|integer',
            'card_number'=> 'required|max:16',
            'ccv' => 'required|max:5',
        ]);
        /**
         * Store the payment in the database.
         */
        $payment = $request->json()->all();
        $payment['status'] = 'pending';
        $paymentObj = Payment::create($payment);
        /**
         * Process payment
         */
        $card = "{$payment['card_number']} {$payment['ccv']}";
        $status = 'success';
        $response = [
            'status' => $status,
            'message' => 'Pagamento aprovado com sucesso!'
        ];
        if((isset($cards[$card]) && $cards[$card]) == false) {
            $status = 'failure';
            $response = [
                'status' => $status,
                'message' => 'Cartão de crédito recusado!'
            ];
        }
        /**
         * Update the payment object.
         */
        $paymentObj->status = $status;
        $paymentObj->save();

        $response['payment'] = $paymentObj;
        return response($response, $status === 'success' ? 200 : 400);
    }
}
