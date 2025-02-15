<?php

namespace App\Http\Controllers;

use App\DTOs\SendCryptoDTO;
use App\GiveawayStatusEnum;
use App\GiveawayTypeEnum;
use App\Http\Requests\StoreGiveawayParticipantRequest;
use App\Http\Requests\UpdateGiveawayParticipantRequest;
use App\Interfaces\CryptoServiceInterface;
use App\Models\Giveaway;
use App\Models\GiveawayParticipant;

class GiveawayParticipantController extends Controller
{
    public function __construct(
        protected CryptoServiceInterface $cryptoService
        )
    {
        
    }
    /**
     * Display a listing of the resource.
     */
    public function index($reference)
    {
        $giveaway   =   Giveaway::where('reference', $reference)->orWhere('id', $reference)->first();   
        return view('giveaway.view-participants', ['giveaway'   =>  $giveaway, 'reference'  =>  $reference]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($reference)
    {
        $giveaway   =   Giveaway::where('reference', $reference)->orWhere('id', $reference)->first();
        if($giveaway){
            if($giveaway->status == GiveawayStatusEnum::OPEN){
                return view('claim-giveaway', ['giveaway'   =>  $giveaway, 'reference'  =>  $reference]);
            }
            return view('giveaway.giveaway-closed', ['giveaway'   =>  $giveaway, 'reference'  =>  $reference]);
        }

        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGiveawayParticipantRequest $request, $reference)
    {
        $giveaway   =   Giveaway::where('reference', $reference)->orWhere('id', $reference)->first();
        if($giveaway){
            $giveawayParticipant =   GiveawayParticipant::create([
                                        'wallet_address'    =>  $request->wallet_address,
                                        'giveaway_id'       =>  $giveaway->id,
                                    ]);

            if($this->handleGiveAwayIfFirstParticipant($giveawayParticipant, $giveaway)){
                return redirect()->back()->with(['success'=>$giveaway->amount.' '.$giveaway->wallet_type->value.' sent successfully']);
            }
            return redirect()->back()->with(['success'=>'Wallet address sent successfully']);
        }

        return abort(404);
    }

    /**
     * Display the specified resource.
     */
    public function show(GiveawayParticipant $giveawayParticipant)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GiveawayParticipant $giveawayParticipant)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateGiveawayParticipantRequest $request, GiveawayParticipant $giveawayParticipant)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GiveawayParticipant $giveawayParticipant)
    {
        //
    }

    private function handleGiveAwayIfFirstParticipant(GiveawayParticipant $giveawayParticipant, Giveaway $giveaway)
    {
        if ($giveaway->giveaway_type    ==  GiveawayTypeEnum::FIRST_PARTICIPANT) {
            return $this->sendGiveawayToParticipant($giveawayParticipant, $giveaway);
        }
    }

    public function handleMakeWinner(Giveaway $giveaway, GiveawayParticipant $giveawayParticipant)
    {
        if ($giveaway->giveaway_type    ==  GiveawayTypeEnum::SELECT_WINNER) {
            if($this->sendGiveawayToParticipant($giveawayParticipant, $giveaway)){
                return redirect()->back()->with(['success'=>$giveaway->amount.' '.$giveaway->wallet_type->value.' sent successfully']);
            }
            return redirect()->back()->withError('Somethign went wrong');
        }
        return redirect()->route('giveaway.index');
    }

    public function handleRoundRobinWinner(Giveaway $giveaway)
    {
        if ($giveaway->giveaway_type    ==  GiveawayTypeEnum::ROUNDROBIN) {

            $giveawayParticipant = GiveawayParticipant::where('giveaway_id', $giveaway->id)->inRandomOrder()->first();
            if($this->sendGiveawayToParticipant($giveawayParticipant, $giveaway)){
                return redirect()->back()->with(['success'=>$giveaway->amount.' '.$giveaway->wallet_type->value.' sent successfully']);
            }
            return redirect()->back()->withError('Somethign went wrong');
        }

        return redirect()->route('giveaway.index');
    }

    private function sendGiveawayToParticipant(GiveawayParticipant $giveawayParticipant, Giveaway $giveaway) 
    {
        $send = $this->cryptoService->send(
            new SendCryptoDTO(
                $giveawayParticipant->wallet_address, 
                json_decode($giveaway->escrow), 
                $giveaway->escrow_address, 
                $giveaway->amount)
        );


        $giveaway->status   =   GiveawayStatusEnum::CLOSED;
        $giveaway->save();


        $giveawayParticipant->is_winner =   true;
        $giveawayParticipant->save();

        return $send;
    }
}
