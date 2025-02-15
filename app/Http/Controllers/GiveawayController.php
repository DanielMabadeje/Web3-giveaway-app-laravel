<?php

namespace App\Http\Controllers;

use App\GiveawayStatusEnum;
use App\Http\Requests\ConfirmUserhasSentAmountToAddressRequest;
use App\Http\Requests\StoreGiveawayRequest;
use App\Http\Requests\UpdateGiveawayRequest;
use App\Interfaces\CryptoServiceInterface;
use App\Models\Giveaway;
use Illuminate\Support\Facades\Auth;

class GiveawayController extends Controller
{
    public function __construct(
        protected CryptoServiceInterface $cryptoService
        )
    {
        
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('giveaway.index', ['giveaways'=>Giveaway::where('user_id', Auth::id())->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('giveaway.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGiveawayRequest $request)
    {
        $data   =   $request->validated();
        $data['user_id']    =   Auth::id();


        if($giveaway = Giveaway::create($data)){
            $response   =   $this->initiateFundTransferToEscrow($giveaway->id.Auth::id());

            $giveaway->escrow_address   =   $response['escrow_address'];
            $giveaway->escrow           =   json_encode($response['escrow']);
            $giveaway->escrow_seed      =   $response['seed'];
            $giveaway->bump             =   $response['bump'];
            $giveaway->save();

            return redirect()->route('giveaway.send-money', $giveaway);
        }

        return redirect()->back()->withErrors('Something went wrong');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Giveaway $giveaway)
    {
        return view('giveaway.show', ['giveaway'  =>  $giveaway]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Giveaway $giveaway)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGiveawayRequest $request, Giveaway $giveaway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Giveaway $giveaway)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function sendAmount(Giveaway $giveaway)
    {
        return view('giveaway.view-escrow-wallet-address', ['giveaway'  =>  $giveaway]);
    }

    public function confirmUserhasSentAmountToAddress(ConfirmUserhasSentAmountToAddressRequest $request, Giveaway $giveaway)
    {
        if($this->cryptoService->getBalance($giveaway->escrow_address) == $giveaway->amount || $this->cryptoService->getBalance($giveaway->escrow_address) > $giveaway->amount){

            $giveaway->status   =   GiveawayStatusEnum::OPEN;
            $giveaway->save();
            
            return redirect()->route('giveaway.index');
        }

        return redirect()->route('giveaway.send-money', $giveaway)->withErrors('You have not sent '.$giveaway->amount.' '.$giveaway->wallet_type->value);
    }

    private function initiateFundTransferToEscrow(string $seed)
    {
        return $this->cryptoService->generateEscrowAccount($seed);
    }
}
